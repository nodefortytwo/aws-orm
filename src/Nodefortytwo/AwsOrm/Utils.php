<?php
namespace Nodefortytwo\AwsOrm;

class Utils{

	public static function getObjectLineage($obj){
		$class = new \ReflectionClass($obj);

		$lineage = array($class->getName());

		while ($class = $class->getParentClass()) {
		    $lineage[] = $class->getName();
		}

		return $lineage;
	}

	public static function arrayDiffAssocRecursive($array1, $array2) 
	{ 
	    foreach($array1 as $key => $value) 
	    { 
	        if(is_array($value)) 
	        { 
	              if(!isset($array2[$key])) 
	              { 
	                  $difference[$key] = $value; 
	              } 
	              elseif(!is_array($array2[$key])) 
	              { 
	                  $difference[$key] = $value; 
	              } 
	              else 
	              { 
	                  $new_diff = self::arrayDiffAssocRecursive($value, $array2[$key]); 
	                  if($new_diff != FALSE) 
	                  { 
	                        $difference[$key] = $new_diff; 
	                  } 
	              } 
	          } 
	          elseif(!isset($array2[$key]) || $array2[$key] != $value) 
	          { 
	              $difference[$key] = $value; 
	          } 
	    } 
	    return !isset($difference) ? 0 : $difference; 
	}

	//convert array to val.var.val
	public static function flattenArray($array, $glue = '.', $reset = true, $indexed = true)
	{
		static $return = array();
		static $curr_key = array();

		if ($reset)
		{
			$return = array();
			$curr_key = array();
		}

		foreach ($array as $key => $val)
		{
			$curr_key[] = $key;
			if (is_array($val) and ($indexed or array_values($val) !== $val) and !empty($val))
			{
				static::flattenArray($val, $glue, false);
			}
			else
			{
				$return[implode($glue, $curr_key)] = $val;
			}
			array_pop($curr_key);
		}
		return $return;
	}


	public static function arrayIntersectRecursive($array1, $array2) 
	{ 
	  foreach($array1 as $key => $value) 
	  { 
	    if (!isset($array2[$key])) 
	    { 
	      unset($array1[$key]); 
	    } 
	    else 
	    { 
	      if (is_array($array1[$key])) 
	      { 
	        $array1[$key] = self::arrayIntersectRecursive($array1[$key], $array2[$key]); 
	      } 
	      elseif ($array2[$key] !== $value) 
	      { 
	        unset($array1[$key]); 
	      } 
	    } 
	  } 
	  return $array1; 
	} 

	public static function arrayKeyExists(Array $keys, Array $search){

		if(count(array_intersect_key(array_flip($keys), $search)) === count($keys)) {
		    return true;           
		}else{
			return false;
		}

	}

}