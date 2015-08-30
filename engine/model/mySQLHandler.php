<?php

class mySQLHandler{
     public $db; 
     public $config;
     public $iniFile;
     function __construct() {
	$this->iniFile = '../config/mysql.ini';
	$this->config = parse_ini_file($this->iniFile, TRUE);
	$this->connect();
     }
     
     /**
     * Connect to the database.
     */
    function connect() {
        $this->db = mysql_db::getConnection();
		if (isset($this->config['database']['username']) && isset($this->config['database']['password'])) {
			if (!$this->db->connect($this->config['database'])) {
				$this->_err_code = 100;
				$this->_err_msg = 'Could not connect to database server';
			}
		}
    }
}

?>
