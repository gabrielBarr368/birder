<?php
	
	ob_start();
	require_once("include.php");
	
	isLogged(1);//Level 0 for guest, level 1 for registered user. If 0, goes to search page.
	
	
		$refPage = Request.ServerVariables;
	
		if(!empty($refPage)){
				
			
			$queryA="DELETE FROM messages WHERE MessagesID='".mysqli_real_escape_string($connection->conn,$_GET['bi'])."';";
			$resultA = mysqli_query($connection->conn,$queryA);
			
			
			
			mysqli_commit($connection->conn);
			
			header("Location: ./useradmin.php");
		}
		else header("Location: ./useradmin.php");
		
	

?>