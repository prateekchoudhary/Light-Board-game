<?php
session_start();
require_once("init.php");
require_once("mySQLHandler.php");

$mySQLHandler =& new mySQLHandler();
require_once("../config/filter.php");

$input = new feed_input();
$userId = $input->get_input('userId', 5, 5);

	$query = sprintf('UPDATE engine_users SET status=\'%s\' WHERE userid=\'%s\'', '', $userId);
	$resource = $mySQLHandler->db->getQuery($query);
?>
