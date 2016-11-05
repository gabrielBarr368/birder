<?php
	
	ob_start();
	require_once("include.php");
	
	isLogged(1);//Level 0 for guest, level 1 for registered user. If 0, goes to search page.
	
	
			
		if($_POST){
				
			
			$queryA="DELETE FROM users WHERE UserID='".$_SESSION['username']."';";
			$resultA = mysqli_query($connection->conn,$queryA);
			
			mysqli_commit($connection->conn);
			
			
			unset($_SESSION['logged']);
			unset($_SESSION['username']) ;
			unset($_SESSION['level'] );
			header('location: ./login.php');
		}
				
	

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta http-equiv="content-language" content="en" />

	<title>User Admin</title>
		<link href="css/horizontal_menu.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
	<form method ='POST' action=" ">

	<div id="all">
		<h3>You are about to delete your account. Are you sure? It is not reversible.</h3>
		<a href="useradmin.php" style="text-decoration:none"><input id="cancel" name="cancel" type="button" value="Cancel"/></a>
					<input id="submit" name="submit" type="submit" value="Submit" /><br />
	</div>

	</form>
	</body>
	</html>