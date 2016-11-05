<?php
	ob_start();
	require_once("include.php");
	
	isLogged(1);//Level 0 for guest, level 1 for registered user. If 0, goes to search page.
		
	 
	//data retrieval for the user
	$query = "SELECT * FROM users WHERE UserID ='".$_SESSION['username']."';"; 
	$result = mysqli_query($connection->conn,$query);

	$queryA = "SELECT * FROM messages INNER JOIN users WHERE users.UserID = messages.FromUser AND messages.ToUser = '".$_SESSION['username']."' ORDER BY messages.MessagesID;"; //takes received messages
	$resultA = mysqli_query($connection->conn,$queryA);



	$queryB = "SELECT * FROM messages INNER JOIN users WHERE users.UserID = messages.ToUser AND messages.FromUser = '".$_SESSION['username']."' ORDER BY messages.MessagesID;"; //takes sent messages
	$resultB = mysqli_query($connection->conn,$queryB);
	

	
		
	mysqli_commit($connection->conn);
	$row = mysqli_fetch_array($result);
	$counter = mysqli_num_rows($resultA);
	$counter2 = mysqli_num_rows($resultB);


	
	if($row['Photo'] == "") $row['Photo'] = "photoes/birder_no_photo.jpg";
	
		
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta http-equiv="content-language" content="en" />

		<style type="text/css">
			<!--

				#photo{
					float:left;
					position:relative;
					
				}
				#photo img{
					width:150px;
					height: 190px;
					border: 4px;
				}				
				#messages{

					margin-top:100px;
				}
				#info{
					margin-top: 50px;
					margin-left:250px;
				}


			-->
		</style>
	<title>User Admin</title>
		<link href="css/horizontal_menu.css" rel="stylesheet" type="text/css" />
		<link href="css/style.css" rel="stylesheet" type="text/css" />

	</head>
	<body>
		<div id="logo">

			<img id="birder" src='css/birder_fundo.jpg'><br/><br/>
		</div>
		<div id="content" align="center">
		<div id="menu" align="center">
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
		</div>
		<div id="log"><p align = "center"><small style="color:green">Logged as <a href="./useradmin.php"> <?php echo $_SESSION['fname']; ?> </a></small></p></div>
		
		<div id="all">
		<div id="data" align="left">
			

				<div id="photo" >

					<a href="./user.php?bi=<?php echo $_SESSION['username']; ?>" ><img src = "<?php echo $row['Photo']; ?>" alt="How people see you" ></a>
					<br/><small><small><a href="./alteruser.php" style = "text-decoration:none">Change information </a></small></small> |
					<small><small><a href="deleteuser.php" style="text-decoration:none" onclick="javascript: return confirm('Confirm delete choice');"> Delete account</a></small></small><br/>
				</div>
				
			<div id="info">
			Name:<i> <?php echo $row['First_Name']; ?> <?php echo $row['Last_Name']; ?> </i><br />
			Residence: <i> <?php echo $row['City'].", "; ?> <?php echo $row['State'].", "; ?> <?php echo $row['Country'].". "; ?> </i><br /> <br/>
			About: <i> <?php echo $row['About']; ?><br/>
			</div>
			
			<br/>
			<div id="messages">
			<hr>
			<p style="color:green"> Received Messages: </p>
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
						<td ><small><small><a href="./user.php?bi=<?php echo $data['FromUser']; ?>" style="text-decoration:none"> <?php echo $data['First_Name']." ".$data['Last_Name']."  "; ?> </a>  said </small></small></td>
						<td></td><td></td><td></td><td></td><td></td><td ><small> <i><b><span style="color:green"><?php echo $data['Message']; ?></span></b></i></small></td>
						<td><small><small><a href="deletemessage.php?bi=<?php echo $data['MessagesID']; ?>" style="text-decoration:none" onclick="javascript: return confirm('Confirm delete choice');"> Delete</a></small></small></td>
						
					</tr>
				
					
				<?php
					}

				}
				
				else{ ?> <i><p style="color:green">No received messages </p></i> <?php ; } ?>
				</table>
				<br/>
				
			<p style="color:green"> Sent Messages: </p>

			<?php 
			
				if($counter2 > 0){
					
					$user2Data = array();
					while($rowB = mysqli_fetch_array($resultB))
						{
						$user2Data[] = $rowB;
						}
					?>
					<table>
						
					<?php 
					reset($user2Data);
					foreach ($user2Data as $data2)
					{
					
					?>
					<tr>
						<td ><small><small><a href="./user.php?bi=<?php echo $data2['ToUser']; ?>" style="text-decoration:none"> <?php echo $data2['First_Name']." ".$data2['Last_Name']."  "; ?> </a></small> </small></td>
						<td></td><td></td><td></td><td></td><td></td><td > <small><i><b><span style="color:green"><?php echo $data2['Message']; ?></span></b></i></small></td>
						<td><small><small><a href="deletemessage.php?bi=<?php echo $data2['MessagesID']; ?>" style="text-decoration:none" onclick="javascript: return confirm('Confirm delete choice');"> Delete</a></small></small></td>
						
					</tr>
				
					
				<?php
					}

				}
				
				else{ ?> <i><p style="color:green">No sent messages.</p></i> <?php ; } ?>
				</table>


		</div>
	</div>
	</div>
		<br/><br/>

	</div>
	<div id="foot">
		</div>

			
	</body>
</html>
