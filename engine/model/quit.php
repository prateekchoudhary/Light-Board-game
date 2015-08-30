<?php
session_start();
require_once("init.php");
require_once("mySQLHandler.php");

$mySQLHandler =& new mySQLHandler($iniFile);

require_once("../config/filter.php");

$input = new feed_input();
$userId = $input->get_input('userId', 5, 5);
$query = sprintf('SELECT userid FROM engine_users WHERE userid=\'%s\'', $userId);
$resource = $mySQLHandler->db->getQuery($query);
$fquery = $mySQLHandler->db->numRows($resource);
if($fquery > 0){
	session_unset($_SESSION['PHPSESSID']);
	session_destroy();
	$query = sprintf('DELETE FROM engine_users WHERE userid=\'%s\'', $userId);
	$resource = $mySQLHandler->db->getQuery($query);
}
?>
