<?php
class Utility
{

	function post($id, $type, $default="")
{	
	$val = isset($_POST[$id])?$_POST[$id]:$default;
	switch($type) {
		case 'int':	
			$val = intval($val); 
		break;
		case 'float': 
			$val = floatval($val); 
		break;
		case 'string': 
			$val = str_replace("'","''", htmlentities($val)); 
		break;
		case 'str_array':
			if (is_array($val)) {
				foreach($val as $k => $v) $val[$k]=str_replace("'","''",htmlentities($v));
			}
			else
				$val = array(); 			
		break;
		case 'int_array':
			if (is_array($val)) {
				foreach($val as $k => $v) $val[$k]=intval($v);
			}
			else 
				$val = array(); 

		break;
		default: 
			$val = $default;
	}
		
	return $val;
}
}
?>