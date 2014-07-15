<?php
namespace Nodefortytwo\AwsOrm;

class Resource extends \Purekid\Mongodm\Model{

	function fetch(){

	}

	static function fetchAll(Account $account, $region = 'eu-west-1'){

		$class = get_called_class();

		$client = $account::client($class::$client);



	}

}