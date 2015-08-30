<?php
session_start();
require_once("init.php");
require_once("mySQLHandler.php");

$mySQLHandler =& new mySQLHandler();
require_once("../config/filter.php");

$input = new feed_input();
$userId = $input->get_input('userId', 5, 5);

$query = "SELECT status, userid FROM engine_users WHERE status='playing' AND userid !='".$userId."'";
$resource = $mySQLHandler->db->getQuery($query);
$fquery = $mySQLHandler->db->numRows($resource);
if($fquery > 0){
	$response = "Lock is busy";
}
else{
	$query = sprintf('UPDATE engine_users SET status=\'%s\' WHERE userid=\'%s\'', 'playing', $userId);
	$resource = $mySQLHandler->db->getQuery($query);
	$response = "lock aquired";
}
echo $response;
?>
