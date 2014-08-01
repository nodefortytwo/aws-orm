<?php
namespace Nodefortytwo\AwsOrm\Resource;

class IP extends \Nodefortytwo\AwsOrm\Resource{

	public static $client = 'Ec2';

	public static $list_method = 'describeAddresses';

	public static $id_property = 'PublicIp';

	public static $_collection = 'awsInstance';

}