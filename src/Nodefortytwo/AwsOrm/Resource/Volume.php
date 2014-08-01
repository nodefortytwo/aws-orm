<?php
namespace Nodefortytwo\AwsOrm\Resource;

class Volume extends \Nodefortytwo\AwsOrm\Resource{

	public static $client = 'Ec2';

	public static $list_method = 'describeVolumes';

	public static $id_property = 'VolumeId';

	public static $_collection = 'awsVolume';

	public static function fetchSingleFilter($id){
		return array('VolumeIds' => array($id));
	}

	public static function postFetch($data){

		foreach($data['Attachments'] as &$attachment){
			$attachment['Instance'] = Instance::idOrFetch($attachment['InstanceId']);
		}
		
		return $data;
	}
}