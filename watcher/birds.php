<?php
	ob_start();
	require_once("include.php");
	
	isLogged(1);//Level 0 for guest, level 1 for registered user. If 0, goes to search page.
	
	$userid = mysqli_real_escape_string($connection->conn,trim($_GET['bi']));

	 
	//data retrieval for the user
	$query = "SELECT bird.Genus, bird.Species,bird.Common_Name, notes.Date,notes.Notes, notes.LocationID,notes.BirdID, users.First_Name, users.Last_Name FROM users INNER JOIN notes INNER JOIN bird WHERE bird.BirdID = notes.BirdID AND users.UserID = notes.UserID AND notes.UserID ='".$userid."';"; 
	$result = mysqli_query($connection->conn,$query);
		
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta http-equiv="content-language" content="en" />

	<title>Home</title>
		<link href="css/horizontal_menu.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		
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
			<?php
				if(mysqli_num_rows($result) == 0){
				echo "<h3><i>This user doesn't have any record yet. </i></h3><br />"; ?>
				
				<?php
				}
			else{
				$userData = array();
				while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
				{
					$userData[] = $row;
				}
				?>
				These are all the records entered by this user until today:<br/> <br/>
				<table border=1>
					<tr>
						<th>Scientific Name</th>
						<th>Common Name</th>
						<th>Note</th>
						<th>Date of View</th>
					</tr>
					<?php 
				foreach ($userData as $data)
				{
					
				?>
					<tr>
						<td><?php echo $data['Genus']?> <?php echo $data['Species']?></td>
						<td><?php echo $data['Common_Name']?></td>
						<td><?php echo substr($data['Notes'], 0, 50) ?><a href='./view.php?bi=<?php echo $data['BirdID']?>&lo=<?php echo $data['LocationID']?>' style="text-decoration:none"> (View more)</a> </td>
						<td><?php echo $data['Date']?></td>
						
					</tr>
				
					
				<?php
				}
			}
				?>
			</table>
			<br/><br/><input type="button" value="Back" onClick="history.go(-1);return true;">


		</div>

			
	</body>
