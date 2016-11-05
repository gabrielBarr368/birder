<?php
	class Connection{
		public $strServer 	= "localhost";
		public $strUser 	= "root";
		public $strPassword 		= "";
		public $strBD		 	= "birder";
		public $charset		= "utf8";
		
		public $conn;
		
		public function __construct() {
			$this->conn = mysql_connect($this->strServer, $this->strUser, $this->strPassword)
			or die ("<br /><br />Unable to connect to database.<br />Please call the system administrator.<br /><br />".mysql_error());
			mysql_select_db($this->strBD) or die ("Error selecting database.");
			mysql_set_charset($this->charset, $this->conn);
		}
		
		public function __destruct(){
			if(isset($this->conn) && gettype($this->conn) == "mysql link")
			{
				mysql_close($this->conn);
				settype($this, "null");
			}
		}
	}	
	
	$connection = new Connection();
	
	$conn = $connection->conn;
	$strServer 	= $connection->strServer;
	$strUser 	= $connection->strUser;
	$strPassword 		= $connection->strPassword;
	$strBD		 	= $connection->strBD;
	$charset		= $connection->charset;
?>