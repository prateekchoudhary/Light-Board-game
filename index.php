<?php
$init_engine = "engine";

if (strpos($init_engine, '/') === FALSE){
	if (function_exists('realpath') AND @realpath(dirname(__FILE__)) !== FALSE)
		$init_engine = realpath(dirname(__FILE__)).'/'.$init_engine;
}
else
	$init_engine = str_replace("\\", "/", $init_engine); 

define('BASEPATH', $init_engine.'/');

//define('LIBS', $init_engine.'/libs/');

require_once BASEPATH.'loadmodule.php';

?>
