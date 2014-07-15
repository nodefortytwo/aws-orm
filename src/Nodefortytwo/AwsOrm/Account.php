<?php
namespace Nodefortytwo\AwsOrm;

class Account extends \Purekid\Mongodm\Model{

	 public static $collection = "account";


	 function client($name){

	 	$classname = '\Aws\\' . $name . '\\' . $name . 'Client';

	 	$client = $classname::factory(array());

	 }

}