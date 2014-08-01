<?php
namespace Nodefortytwo\AwsOrm;

class Resource extends \Nodefortytwo\MongoOdm\Model{

	public static function fetch($id, Account $account = null, $region = 'eu-west-1'){

		if(is_null($account)){
			$account = Account::getActive();
		}

		$region = Account::getActiveRegion();		

		$class = get_called_class();

		$client = $account->client($class::$client);

		$iterator = 'get' . $class::$list_method . 'Iterator';

		if(method_exists($class, 'fetchSingleFilter')){
			$filter = $class::fetchSingleFilter($id);
		}else{
			$filter = array();
			$filter[$class::$id_property] = $id;	
		}

		try{
			$results = $client->$iterator($filter);
			$results->next();
			$res = $results->current();
			return self::processFetch($res, $account, $region);
		} catch (\Aws\Ec2\Exception\Ec2Exception $e){
			return null;
		}
	}

	static function fetchAll(Account $account = null, $region = 'eu-west-1'){

		if(is_null($account)){
			$account = Account::getActive();
		}

		if(is_null($region)){
			$region = Account::getActiveRegion();
		}

		$class = get_called_class();

		$client = $account->client($class::$client, $region);

		$iterator = 'get' . $class::$list_method . 'Iterator';

		$fetchFilter = isset($class::$_list_filter) ? $class::$_list_filter : array();

		$results = $client->$iterator($fetchFilter);

		foreach($results as $res){
			self::processFetch($res, $account, $region);
		}

		return $class::all();

	}

	static function processFetch($res, $account, $region = null){
		$class = get_called_class();
		if(method_exists($class, 'postFetch')){
			$res = $class::postFetch($res);
		}

		$res['_id'] = $res[$class::$id_property];
		$res = new $class($res);
		$res['account'] = $account;
		$res['region'] = $region;
		$res->save();
		return $res;
	}

	function getTag($key){
		$tags = $this->tags;
		if(isset($tags[$key])){
			return $tags[$key];
		}else{
			return null;
		}
	}

	function getTags(){
		$tags = array();
		if(isset($this['Tags'])){
			foreach($this['Tags'] as $tag){
				$tags[$tag[0]] = $tag[1];
			}
		}
		return $tags;
	}

	function getAccount(){
		return $this['account'];
	}

	public static function idOrFetch($id){
		$obj = self::id($id);
		var_dump($obj);
		if($obj){return $obj;}

		return self::fetch($id);
	}

}