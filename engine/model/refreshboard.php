<?php
session_start();
require_once("init.php");
require_once("mySQLHandler.php");

$mySQLHandler =& new mySQLHandler();
require_once("../config/filter.php");

$input = new feed_input();
$userId = $input->get_input('userId', 5, 5);

$query = 'SELECT userid,sequence FROM engine_users';
$redraw = "";
$resource = $mySQLHandler->db->getQuery($query);
if(!empty($resource)){
	while($row = $mySQLHandler->db->row($resource)){
		$value = $row['sequence'];
		if($value == 'NULL' || $value == ''){
			$value = "";
		}
		$redraw .= $row['userid']."=".$value."|";
	}
}
$query = "SELECT status, userid FROM engine_users WHERE status='playing' AND userid !='".$userId."'";
$resource = $mySQLHandler->db->getQuery($query);
$fquery = $mySQLHandler->db->numRows($resource);
if($fquery > 0){
	$response = "1";
}
else{
	$response = "0";
}

echo $redraw."$".$response;

?>
