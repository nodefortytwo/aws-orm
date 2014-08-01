<?php
namespace Nodefortytwo\AwsOrm\Resource;

use Nodefortytwo\AwsOrm\Resource\Volume;

class Instance extends \Nodefortytwo\AwsOrm\Resource{

	public static $client = 'Ec2';

	public static $list_method = 'describeInstances';

	public static $id_property = 'InstanceId';

	public static $_collection = 'awsInstance';

	public static function postFetch($data){

		foreach($data['BlockDeviceMappings'] as &$mapping){
			$mapping['Ebs']['Volume'] = Volume::idOrFetch($mapping['Ebs']['VolumeId']);
		}
		
		return $data;
	}

}