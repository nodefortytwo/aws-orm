<?php
namespace Nodefortytwo\AwsOrm;

use Nodefortytwo\Crypt\Crypt;


class Account extends \Nodefortytwo\MongoOdm\Model{

	public static $_collection = "account";

	public static $_refs = array();

	public static $active_account = null;

	public static $active_region = null;

	function client($name, $region = 'eu-west-1'){

		$classname = '\Aws\\' . $name . '\\' . $name . 'Client';

		$config = array(
			'key' => $this['key'],
			'secret' => $this->secret,
			'region' => $region
		);

		return $classname::factory($config);

	}

	public function getSecret(){
		return Crypt::decrypt($this['secret']);
	}

	public function setSecret($val){
		$this['secret'] = Crypt::encrypt($val);
		return $this['secret'];
	}

	public function fetch($type, $region = 'eu-west-1'){
		$type = 'Nodefortytwo\AwsOrm\Resource\\' . $type;

		return $type::fetchAll($region, $this);
	}


	public static function setActive(Account $account){
		self::$active_account = $account;
	}

	public static function getActive(){
		return self::$active_account;
	}

	public static function setActiveRegion($region){
		self::$active_region = $region;
	}

	public static function getActiveRegion(){
		return self::$active_region;
	}
}