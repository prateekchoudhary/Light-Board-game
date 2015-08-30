<?php

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
	session_start();
	$_SESSION['userid'] = $userId;
}
else{
	ob_start();	
	session_start();
	session_register();
	$SESSID = session_id();
	$_SESSION['userid'] = $userId;
	$query = sprintf('INSERT INTO engine_users VALUES (\'%s\',\'%s\',\'%s\',\'%s\')', $userId, $SESSID, 'playing', 'NULL');
	$fquery = $mySQLHandler->db->getQuery($query);
}
echo $userId;
?>
