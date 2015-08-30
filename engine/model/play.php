<?php
session_start();
require_once("init.php");
require_once("mySQLHandler.php");

$mySQLHandler =& new mySQLHandler($iniFile);

require_once("../config/filter.php");

$input = new feed_input();
$userId = $input->get_input('userId', 5, 5);
$action = $input->get_input('action', 3, 4);

$query = sprintf('SELECT userid FROM engine_users WHERE userid=\'%s\'', $userId);
$resource = $mySQLHandler->db->getQuery($query);
$fquery = $mySQLHandler->db->numRows($resource);
if($fquery > 0){
	$query = sprintf('SELECT sequence FROM engine_users WHERE userid=\'%s\'', $userId);
	$resource = $mySQLHandler->db->row($mySQLHandler->db->getQuery($query));
	$value = $resource['sequence'];
	if($action == 'add'){
		$cell = $input->get_input('cell', 11, 13);
		if($value == 'NULL' || $value == ''){
			$value = "";
		}
		else{
			$value .= ":";
		}
		$value .= $cell;
	
			$query = sprintf('UPDATE engine_users SET sequence=\'%s\' WHERE userid=\'%s\'', $value, $userId);
			$resource = $mySQLHandler->db->getQuery($query);
	}
	elseif($action == 'del'){
		$cell = $input->get_input('cell', 11, 13);
		$value = str_replace($cell, "", $value);
		$value = str_replace("::", ":", $value);
		$value = preg_replace('/^:(.*)/', '\1', $value);
		$query = sprintf('UPDATE engine_users SET sequence=\'%s\' WHERE userid=\'%s\'', $value, $userId);
		$resource = $mySQLHandler->db->getQuery($query);
	}
	else{
	}
	echo $value;
}
?>
