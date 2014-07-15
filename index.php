<?php

require "vendor/autoload.php";

use Nodefortytwo\AwsOrm\Resource\Instance;
use Nodefortytwo\AwsOrm\Account;

$account = new Account(array(
	"name" => 'test',
	"key" => "key",
	"secret" => "secret"
));

Instance::fetchAll($account);

//$instance = new Instance();