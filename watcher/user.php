<?php
	ob_start();
	
	require_once ("include.php");

	isLogged(0);//Level 0 for guest, level 1 for registered user. If 0, goes to search page.
		
	 
	//data retrieval for the user
	$userid = mysqli_real_escape_string($connection->conn,trim($_GET['bi']));
	$query = "SELECT * FROM users WHERE UserID ='".$userid."';"; 
	$result = mysqli_query($connection->conn,$query);

	$queryA = "SELECT * FROM messages INNER JOIN users WHERE users.UserID = messages.FromUser AND messages.ToUser = '".$userid."' ;";
	$resultA = mysqli_query($connection->conn,$queryA);

	mysqli_commit($connection->conn);


	
	$row = mysqli_fetch_array($result);
	if($row['Photo'] == "") $row['Photo'] = "photoes/birder_no_photo.jpg";
	
	$counter = mysqli_num_rows($resultA);
	
	if($_POST){

		extract($_POST);
		if(notEmpty($message)){
			
			$uid = uniqid("",true);
			$messageID = $uid.$userid;

			$queryM = "INSERT INTO messages VALUES('".$messageID."', '".$message."','".$_SESSION['username']."','".$userid."');";
			$resultM = mysqli_query($connection->conn,$queryM);
			mysqli_commit($connection->conn);
			


		}

	}
		
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta http-equiv="content-language" content="en" />
	<title>User Profile</title>
		<link href="css/horizontal_menu.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<form method="post" action="user.php?bi=<?php echo $userid; ?>" enctype="multipart/form-data">
		<p><div id="navbar">
			<ul>
				<li><a href="display.php">Home</a></li>
				<li><a href="useradmin.php">Profile</a></li>
               		<li><a href="input.php">New Bird</a></li>
				<li><a href="search.php">Search</a></li>
				<li><a href="about.php">About</a></li>
               		<li><a href="logout.php">Logout</a></li>
				

           	 </ul>
		
        </div></p>
		
		
		
		<div id="data" align="center">
			<p align = "center"><small style="color:green">Logged as <a href="./useradmin.php"> <?php echo $_SESSION['fname']; ?> </a></small></p>

				<div id="photo">

					<img src = "<?php echo $row['Photo']; ?>" width = "190" height = "190" border = "2">
				</div>
			
			Name:<i> <?php echo $row['First_Name']; ?> <?php echo $row['Last_Name']; ?> </i><br />
			Residence: <i> <?php echo $row['City'].", "; ?> <?php echo $row['State'].", "; ?> <?php echo $row['Country'].". "; ?> </i><br /> <br/>
			About: <i> <?php echo $row['About']; ?><br/><br/>
			<a href="birds.php?bi=<?php echo $userid; ?>">See all the birds of this user</a><br/><br/>
			
			
			<?php

			if($_SESSION['leveluser']>0){ ?>
			Write a message for this user!<br/>
			<textarea cols="40" rows="10" name = "message" id = "message" onkeyup="blocText(this.value)"></textarea><br/>
					You still have: <span id="count">1000</span> characteres<br/><br/><input type="submit" name="submit" id="submit" value="Submit" />

			<?php }
				else{
					echo "You are not able to send messages for this user because you are in our guest account. <a href='./register.php' > Register now </a> for more features!";
					}	
			?>

			<hr>
			<p style="color:green"> Messages: <small>(You may have to press refresh button to see the message. We are working to make it better)</small></p><br/><br/>

			<?php 
			
				if($counter > 0){
					
					$userData = array();
					while($rowA = mysqli_fetch_array($resultA))
						{
						$userData[] = $rowA;
						}
					?>
					<table>
						
					<?php 
					reset($userData);
					foreach ($userData as $data)
					{
					
					?>
					<tr>
						<td colspan='3'><a href="./user.php?bi=<?php echo $data['FromUser']; ?>" style="text-decoration:none"> <?php echo $data['First_Name']." ".$data['Last_Name']."  "; ?> </a>  said:</td>
						<td colspan='5'> <i><small style="color:green"><?php echo $data['Message']; ?></small></i></td>
						
					</tr>
					
				<?php
					}

				}
				else{ ?> <i><p style="color:green">No messages.</p></i> <?php ; } ?>

					</div>

		</form>	
	</body>
</html>
