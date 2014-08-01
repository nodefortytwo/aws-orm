<?php
define('INIT', microtime(true));
define('PID', getmypid());
chdir(__DIR__);
ini_set('memory_limit','999M');
error_reporting(E_ALL);
ini_set('display_errors', '1');

require "vendor/autoload.php";

use Nodefortytwo\AwsOrm\Resource\Instance;
use Nodefortytwo\AwsOrm\Resource\Volume;
use Nodefortytwo\AwsOrm\Resource\IP;
use Nodefortytwo\AwsOrm\Account;
use Nodefortytwo\MongoOdm\MongoDB;
use Nodefortytwo\Crypt\Crypt;

MongoDB::instance('default', array(
		'hostname' => '54.76.167.137',
		'name' => 'aws-orm'
	));

Crypt::setKey('thisisakey');

$accounts = Account::all();

foreach($accounts as $account){
	Account::setActive($account);
	Account::setActiveRegion('eu-west-1');
}

$vol = Volume::id('vol-4d620346');
$vol['Size'] = 12;
$vol->save();