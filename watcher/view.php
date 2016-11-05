<?php 
	ob_start();
	require_once("include.php");
	
	isLogged(0); //Level 0 for guest, level 1 for registered user. If 0, goes to search page.
		
	
	$error = array();
	
	$birdID = mysqli_real_escape_string($connection->conn,$_GET['bi']);
	$locationID = mysqli_real_escape_string($connection->conn,$_GET['lo']);
	
	$queryA = "SELECT * FROM bird WHERE BirdID = '".$birdID."';";	
	$resultA = mysqli_query($connection->conn,$queryA);
	while($row = mysqli_fetch_array($resultA, MYSQLI_ASSOC))
		{
			$genus = $row['Genus'];
			$species = $row['Species'];
			$order = $row['BirdOrder'];
			$family = $row['Family'];
			$common = $row['Common_Name'];
		}
	if($resultA && !empty($genus)){ //if $genus is empty, a mandatory field, means that somebody digited something not valid
		$queryB = "SELECT * FROM location WHERE LocationID = '".$locationID."';";
		$resultB = mysqli_query($connection->conn,$queryB);
		while($row = mysqli_fetch_array($resultB, MYSQLI_ASSOC))
		{
			$city = $row['City'];
			$state = $row['State'];
			$country = $row['Country'];
			$neighborhood = $row['Neighborhood'];
			$latitude = $row['Latitude'];
			$longitude = $row['Longitude'];
			$continent = $row['Continent'];
			$yard = $row['Yard'];
			$lower48 = $row['Lower48'];
							
		}
			if($resultB && !empty($city)){//if $city is empty, a mandatory field, means that somebody digited something not valid
				$queryC = "SELECT Notes,Date,Weather,Habitat, Photo, UserID FROM notes WHERE BirdID = '".$birdID."' AND LocationID = '".$locationID."';"; //tirei user, ver se da algum problema
				$resultC = mysqli_query($connection->conn,$queryC);
				while($row = mysqli_fetch_array($resultC, MYSQLI_ASSOC))
				{
					$note = $row['Notes'];
					$weather = $row['Weather'];
					$date = $row['Date'];
					$habitat = $row['Habitat'];
					$userid = $row['UserID'];
					$photo = $row['Photo'];
							
				}
					if($photo == "") $photo = "photoes/birder_no_photo.jpg";

					$queryR = "SELECT First_Name, Last_Name FROM users WHERE UserID = '".$userid."';";
					$resultR = mysqli_query($connection->conn,$queryR);
					while($row = mysqli_fetch_array($resultR, MYSQLI_ASSOC))
					{
						$fname = $row['First_Name'];
						$lname = $row['Last_Name'];
					}

					if($resultC && !empty($note)){//if $note is empty, a mandatory field, means that somebody digited something not valid
						mysqli_commit($connection->conn);
						
						if($yard == '1') $yard = "Was seen at a yard.";
						else $yard = "Was not seen at a yard.";
				
						if($lower48 == '1') $lower48 = "Was seen on lower48.";
						else $lower48 = "";
					}
					else {//needs to unset variables because something went wrong on url
						echo "Something went wrong with the URL.";
						mysqli_rollback($connection->conn);
						$genus = "";
						$species = "";
						$order = "";
						$family = "";
						$common = "";
						$city = "";
						$state = "";
						$country = "";
						$neighborhood = "";
						$latitude = "";
						$longitude = "";
						$continent = "";
						$yard = "";
						$lower48 = "";
					}
			}
			else { //needs to unset variables because something went wrong on url
				echo "Something went wrong with the URL.";
				mysqli_rollback($connection->conn);
				$genus = "";
				$species = "";
				$order = "";
				$family = "";
				$common = "";
			}
	}
	else {
		echo "Something went wrong with the URL.";
		mysqli_rollback($connection->conn);
	}
	
	
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta http-equiv="content-language" content="en" />

	<title><?php echo $genus." ".$species; ?></title>
		
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
		<div align="center">
			<p align = "center"><small style="color:green">Logged as <a href="./useradmin.php"> <?php echo $_SESSION['fname']; ?> </a></small></p>


			<div id="photo">

				<img src = "<?php echo $photo; ?>" width = "20%" height = "20%" border = "2">
			</div>
			

			Scientific Name:  <i><?php echo $genus; ?> <?php echo $species; ?></i><br/>
			Order:  <i><?php echo $order; ?><br/></i>
			Family:  <i><?php echo $family; ?><br/></i>
			Common Name:  <i><?php echo $common; ?></i><br/><br/>
			Note:  <i><?php echo $note; ?></i><br/><br/>	
			Date:  <i><?php echo $date; ?></i><br/>		
			Wheather:  <i><?php echo $weather; ?></i><br/>		
			Habitat:  <i><?php echo $habitat; ?></i><br/>
			Neighborhood: <i><?php echo $neighborhood."   "; ?></i><br/>
			City: <i> <?php echo $city."   "; ?></i><br/>
			State: <i><?php echo $state."   "; ?></i><br/>
			Country: <i> <?php echo $country." "; ?></i><br/>
			Continent: <i><?php echo $continent."  "; ?></i> <br/>
			<i><?php if (!empty($latitude))echo "Latitude:".$latitude." "; ?>    <?php if (!empty($longitude)) echo "Longitude:".$longitude."  "; ?><br/>
			<?php echo $yard; ?><br/> <?php echo $lower48; ?></i> <br/>
			<br/>
			Sent by: <a href='./user.php?bi=<?php echo $userid; ?>' style="text-decoration:none"> <?php echo $fname; ?> <?php echo $lname; ?><br/> </a>
			<input type="button" value="Back" onClick="history.go(-1);return true;">
		</div>
	</body>
</html>