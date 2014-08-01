<?php
namespace Nodefortytwo\AwsOrm\Resource;

class Image extends \Nodefortytwo\AwsOrm\Resource{

	public static $client = 'Ec2';

	public static $list_method = 'describeImages';

	public static $id_property = 'ImageId';

	public static $_collection = 'awsImage';

	public static $_list_filter = array('Owners' => array('self'));
}