<?php
	
	ob_start();
	require_once("include.php");
	
	isLogged(1);//Level 0 for guest, level 1 for registered user. If 0, goes to search page.
	
	
		$refPage = Request.ServerVariables;
	
		if(!empty($refPage)){
				
			$query = "SELECT Photo FROM notes WHERE BirdID='".mysqli_real_escape_string($connection->conn,$_GET['bi'])."' AND LocationID='".mysqli_real_escape_string($connection->conn,$_GET['lo'])."' AND UserID ='".$_SESSION['username']."';";
			$result =  mysqli_query($connection->conn,$query);
			$row = mysqli_fetch_array($result,MYSQLI_ASSOC);

			if(!empty($row['Photo'])) unlink($row['Photo']);			

			/*delete with information passed by GET*/
			$queryA="DELETE FROM notes WHERE BirdID='".mysqli_real_escape_string($connection->conn,$_GET['bi'])."' AND LocationID='".mysqli_real_escape_string($connection->conn,$_GET['lo'])."' AND UserID ='".$_SESSION['username']."';";
			$resultA = mysqli_query($connection->conn,$queryA);
			
			$queryB="DELETE FROM bird WHERE BirdID='".mysqli_real_escape_string($connection->conn,$_GET['bi'])."';";
			$resultB = mysqli_query($connection->conn,$queryB);	
				
			$queryC="DELETE FROM location WHERE LocationID='".mysqli_real_escape_string($connection->conn,$_GET['lo'])."';";
			$resultC = mysqli_query($connection->conn,$queryC);	
			
			mysqli_commit($connection->conn);
			
			header("Location: ./display.php");
		}
		else header("Location: ./display.php");
		
	

?>