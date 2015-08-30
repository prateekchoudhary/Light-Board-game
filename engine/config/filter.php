<?php
/**************************************************************/
/**** Feed input class ****************************************/
/**** validates UserInputs ************************************/
/**** @author : prateek.choudhary *****************************/
/**************************************************************/
/**************************************************************/


class feed_input {
	private $_MIN, $_MAX;
	private $_ARGS;
	private $_errorpage = "http://localhost/lightboard/error.html";
	
	function __construct(){
		
	}
	
	public function get_input($pos, $min, $max){
	  
	  $this->_ARGS = $_GET[$pos];
	  $this->_MIN = $min;
	  $this->_MAX = $max;
		$this->_ARGS = trim($this->_ARGS);
		if(is_int($this->_ARGS)){
			$this->_ARGS = $this->sanitize_int();
		
			if(!($this->_ARGS)){
					header($this->_errorpage);
			}
		}
		
		else if(is_string($this->_ARGS)){
			$this->_ARGS = $this->sanitize_string();
		
			if(!($this->_ARGS)){
					header($this->_errorpage);
			}
		}
		
		$this->_ARGS = $this->sanitize_sql_string();
		$this->_ARGS = $this->sanitize_full();
		
		if(!($this->_ARGS)){
				header($this->_errorpage);
		}
		
		return $this->_ARGS;
	}
	
	public function sanitize_full(){
		$this->_ARGS = mysql_real_escape_string(htmlentities($this->_ARGS, ENT_QUOTES, 'UTF-8'));
		return $this->_ARGS;
	}
	// paranoid sanitization -- only let the alphanumeric set through
	public function sanitize_string()
	{
		$this->_ARGS = preg_replace("/[^a-zA-Z0-9_]/", "", $this->_ARGS);
		$len = strlen($this->_ARGS);
		if((($this->_MIN != '') && ($len < $this->_MIN)) || (($this->_MAX != '') && ($len > $this->_MAX)))
		  return FALSE;
		return $this->_ARGS;
	}

	public function sanitize_html_string()
	{
		$pattern[0] = '/\&/';
		$pattern[1] = '/</';
		$pattern[2] = "/>/";
		$pattern[3] = '/\n/';
		$pattern[4] = '/"/';
		$pattern[5] = "/'/";
		$pattern[6] = "/%/";
		$pattern[7] = '/\(/';
		$pattern[8] = '/\)/';
		$pattern[9] = '/\+/';
		$pattern[10] = '/-/';
		$replacement[0] = '&amp;';
		$replacement[1] = '&lt;';
		$replacement[2] = '&gt;';
		$replacement[3] = '<br>';
		$replacement[4] = '&quot;';
		$replacement[5] = '&#39;';
		$replacement[6] = '&#37;';
		$replacement[7] = '&#40;';
		$replacement[8] = '&#41;';
		$replacement[9] = '&#43;';
		$replacement[10] = '&#45;';
		return preg_replace($pattern, $replacement, $this->_ARGS);
	}
	// sanitize a string for SQL input (simple slash out quotes and slashes)
	public function sanitize_sql_string()
	{
		$pattern[0] = '/(\\\\)/';
		$pattern[1] = "/\"/";
		$pattern[2] = "/'/";
		$replacement[0] = '\\\\\\';
		$replacement[1] = '\"';
		$replacement[2] = "\\'";
		$len = strlen($this->_ARGS);
		if((($this->_MIN != '') && ($len < $this->_MIN)) || (($this->_MAX != '') && ($len > $this->_MAX)))
		  return FALSE;
		return preg_replace($pattern, $replacement, $this->_ARGS);
	}
	// make int int!
	public function sanitize_int()
	{
		$int = intval($this->_ARGS);
		if((($this->_MIN != '') && ($int < $this->_MIN)) || (($this->_MAX != '') && ($int > $this->_MAX)))
		  return FALSE;
		return $int;
	}
}
?>
