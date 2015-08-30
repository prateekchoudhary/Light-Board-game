<?php

/***************************** ******************************************/
/************ Mysql Connection Class ************************************/
/************ @author : prateek.choudhary *************** ***************/
/************************************************************************/
/************************************************************************/


class mysql_db {
    
    /**
     * @var resource Database resource
     */
    var $db;
    var $logger;
    private static $P_Instance;
    
    /**
     * Connect to the database.
     * @param str[] config
     */
    
    // A private constructor; prevents direct creation of object
    private function __construct() 
    {
        //echo 'I am constructed';
    }
    
    //Add singleton design pattern
    public static function getConnection() {
    
    	if(!isset(self::$P_Instance)) {
     		$c = __CLASS__;
     		self::$P_Instance = new $c;
     	}
     	return self::$P_Instance;

    }
    		

    function connect($config) {
        if ($this->db = @mysql_pconnect(
			$config['server'],
			$config['username'],
			$config['password']
		)) {
			if ($this->select_db($config['database'])) {
				return TRUE;
			}
        }
        return FALSE;
    }

    /**
     * Close the database connection.
     */
    function close() {
        mysql_close($this->db);
    }
    
    /**
     * Use a database
     */
    function select_db($database) {
        if (mysql_select_db($database, $this->db)) {
            return TRUE;
        }
        return FALSE;
    }
    
    /**
     * Get the columns in a table.
     * @param str table
     * @return resource A resultset resource
     */
    function getColumns($table) {
        return mysql_query(sprintf('SHOW COLUMNS FROM %s', $table), $this->db);
    }
    
    /**
     * Get a row from a table.
     * @param str table
     * @param str where
     * @return resource A resultset resource
     */
    
    function getRows($table, $where) {
        return mysql_query(sprintf('
				    SELECT * FROM %s WHERE %s', $table, $where));
    }
    
   function insertRow($table, $names, $values) {
    	$q = sprintf('INSERT INTO %s (%s) VALUES (%s)', $table, $names,$values);
    	if (!mysql_query($q))
         {
 	 //die('Error: ' . mysql_error());
 	 }
        
    }
    
        /**
     * Fetch a row from a query resultset.
     * @param resource resource A resultset resource
     * @return str[] An array of the fields and values from the next row in the resultset
     */
    function row($resource) {
        return mysql_fetch_assoc($resource);
    }

    /**
     * The number of rows in a resultset.
     * @param resource resource A resultset resource
     * @return int The number of rows
     */
    function numRows($resource) {
        return mysql_num_rows($resource);
    }
    
   function getQuery($resource) {
        return mysql_query($resource);
    }
    
 }
  
 ?>
