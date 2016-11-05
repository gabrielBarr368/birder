<?php
	class Connection{
		public $strServer 	= "localhost";
		public $strUser 	= "root";
		public $strPassword 		= "ithacamysql";
		public $strBD		 	= "birder";
		public $charset		= "utf8";
		
		public $conn;
		
		public function __construct() {
			$this->conn = mysqli_connect($this->strServer, $this->strUser, $this->strPassword)
			or die ("<br /><br />Unable to connect to database.<br />Please call the system administrator.<br /><br />".mysqli_error());
			mysqli_select_db($this->conn,$this->strBD) or die ("Error selecting database.");
			mysqli_set_charset($this->conn, $this->charset);
			mysqli_autocommit($this->conn, false);
		}
		
		public function __destruct(){
			if(isset($this->conn) && gettype($this->conn) == "mysql link")
			{
				mysqli_close($this->conn);
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