<?php 
	
	ob_start();
	header("Content-Type: text/html; charset=ISO-8859-1", true); 
	require_once("include.php");
	
	isLogged(0); //Level 0 for guest, level 1 for registered user. If 0, goes to search page.
		

	if($_POST){
		
		$error=array();
		extract($_POST);
			
		$query = "CREATE VIEW vi AS SELECT bird.BirdID,bird.Genus,bird.Species, bird.BirdOrder, bird.Family, bird.Common_Name, location.LocationID,";
		$query .= " location.City, location.State,location.Country,location.Neighborhood, location.Yard, location.Continent, location.Lower48,notes.Notes,notes.Date,";
		$query .= " notes.Weather, notes.Habitat,users.First_Name, users.Last_Name, users.UserID FROM bird INNER JOIN notes INNER JOIN users INNER JOIN location WHERE notes.LocationID = location.LocationID AND bird.BirdID = notes.BirdID AND users.UserID = notes.UserID;";
		
		$result = mysqli_query($connection->conn,$query);
		if($result){
			mysqli_commit($connection->conn);
		}
		else echo "Error";
		
		$flag = 0; //flag to say if there is already any where statement before  
		
		$queryS = "SELECT Notes, Date, Common_Name, Genus, Species, BirdID, LocationID FROM vi WHERE ";
		
		//all these if's start buikding the queyS
		if(notEmpty($genus = mysqli_real_escape_string($connection->conn,$genus))) {
			$queryS .= "Genus LIKE '%".$genus."%'";
			$flag = 1;
		}
		if(notEmpty($species = mysqli_real_escape_string($connection->conn,$species))) {
			if($flag ==1){
				$queryS .= " AND Species LIKE '%".$species."%'";
			}
			else {
				$queryS .= "Species LIKE '%".$species."%'";
				$flag = 1;
			}
		}
		if(notEmpty($order = mysqli_real_escape_string($connection->conn,$order))) {
			if($flag ==1){
				$queryS .= " AND BirdOrder LIKE '%".$order."%'";
			}
			else {
				$queryS .= "BirdOrder LIKE '%".$order."%'";
				$flag = 1;
			}
		}
		if(notEmpty($family = mysqli_real_escape_string($connection->conn,$family))) {
			if($flag ==1){
				$queryS .= " AND Family LIKE '%".$family."%'";
			}
			else {
				$queryS .= "Family LIKE '%".$family."%'";
				$flag = 1;
			}
		}
		if(notEmpty($common = mysqli_real_escape_string($connection->conn,$common))) {
			if($flag ==1){
				$queryS .= " AND Common_Name LIKE '%".$common."%'";
			}
			else {
				$queryS .= "Common_Name LIKE '%".$common."%'";
				$flag = 1;
			}
		}
		if(notEmpty($city = mysqli_real_escape_string($connection->conn,$city))) {
			if($flag ==1){
				$queryS .= " AND City LIKE '%".$city."%'";
			}
			else {
				$queryS .= "City LIKE '%".$city."%'";
				$flag = 1;
			}
		}
		if(notEmpty($state = mysqli_real_escape_string($connection->conn,$state))) {
			if($flag ==1){
				$queryS .= " AND State LIKE '%".$state."%'";
			}
			else {
				$queryS .= "State LIKE '%".$state."%'";
				$flag = 1;
			}
		}
		if(notEmpty($country = mysqli_real_escape_string($connection->conn,$country))) {
			if($flag ==1){
				$queryS .= " AND Country LIKE '%".$country."%'";
			}
			else {
				$queryS .= "Country LIKE '%".$country."%'";
				$flag = 1;
			}
		}
		if(notEmpty($continent = mysqli_real_escape_string($connection->conn,$continent))) {
			if($flag ==1){
				$queryS .= " AND Continent LIKE '%".$continent."%'";
			}
			else {
				$queryS .= "Continent LIKE '%".$continent."%'";
				$flag = 1;
			}
		}
		if(notEmpty($neighborhood = mysqli_real_escape_string($connection->conn,$neighborhood))) {
			if($flag ==1){
				$queryS .= " AND Neighborhood LIKE '%".$neighborhood."%'";
			}
			else {
				$queryS .= "Neighborhood LIKE '%".$neighborhood."%'";
				$flag = 1;
			}
		}
		if(notEmpty($yard = mysqli_real_escape_string($connection->conn,$yard))) {
			if($flag ==1){
				$queryS .= " AND Yard LIKE '%".$yard."%'";
			}
			else {
				$queryS .= "Yard LIKE '%".$yard."%'";
				$flag = 1;
			}
		}
		if(notEmpty($lower48 = mysqli_real_escape_string($connection->conn,$lower48))) {
			if($flag ==1){
				$queryS .= " AND Lower48 LIKE '%".$lower48."%'";
			}
			else {
				$queryS .= "Lower48 LIKE '%".$lower48."%'";
				$flag = 1;
			}
		}
		if(notEmpty($weather = mysqli_real_escape_string($connection->conn,$weather))) {
			if($flag ==1){
				$queryS .= " AND Weather LIKE '%".$weather."%'";
			}
			else {
				$queryS .= "Weather LIKE '%".$weather."%'";
				$flag = 1;
			}
		}
		if(notEmpty($habitat = mysqli_real_escape_string($connection->conn,$habitat))) {
			if($flag ==1){
				$queryS .= " AND Habitat LIKE '%".$habitat."%'";
			}
			else {
				$queryS .= "Habitat LIKE '%".$habitat."%'";
				$flag = 1;
			}
		}
		if(notEmpty($date = mysqli_real_escape_string($connection->conn,$date))) {
			if(notEmpty($date2 = mysqli_real_escape_string($connection->conn,$date2))) {
				if($flag ==1){
					$queryS .= " AND (Date >= '".$date."' AND Date <= '".$date2."')";
				}
				else {
					$queryS .= "(Date >= '".$date."' AND Date <= '".$date2."')";
					$flag = 1;
				}
			}
			else{
				if($flag ==1){
					$queryS .= " AND Date = '".$date."'";
				}
				else {
					$queryS .=  "Date = '".$date."'";
					$flag = 1;
				}
			
			}
		}
		if(notEmpty(mysqli_real_escape_string($connection->conn,$date2))) {
			if(!notEmpty(mysqli_real_escape_string($connection->conn,$date))) {
				if($flag ==1){
					$queryS .= " AND Date = '".$date2."'";
				}
				else {
					$queryS .=  "Date = '".$date2."'";
					$flag = 1;
				}
			
			}
		}
		if(notEmpty($note = mysqli_real_escape_string($connection->conn,$note))) {
			if($flag ==1){
				$queryS .= " AND Notes LIKE '%".$note."%'";
				}
			else {
				$queryS .= "Notes LIKE '%".$note."%'";
				$flag = 1;
			}
		}
		if(notEmpty($user = mysqli_real_escape_string($connection->conn,$user))) {
			if($flag ==1){
				$queryS .= " AND (First_Name LIKE '%".$user."%' OR Last_Name LIKE '%".$user."%')" ;
			}
			else {
				$queryS .= "(First_Name LIKE '%".$user."%' OR Last_Name LIKE '%".$user."%')" ;
				$flag = 1;
			}
		}
		
		if(notEmpty($useronly = mysqli_real_escape_string($connection->conn,$useronly))) {

			$queryU = "SELECT UserID, Last_Name, First_Name FROM users WHERE First_Name LIKE '%".$useronly."%' OR Last_Name LIKE '%".$useronly."%';";
			$resultU = mysqli_query($connection->conn,$queryU);
			$flag3 = 1;

		}
		else $flag3 = 0;
			
		
		if((strcmp($queryS,"SELECT Notes, Date, Common_Name, Genus, Species, BirdID, LocationID FROM vi WHERE ")) !=0){ //add ; to the end of the query if there is any search to do, else there's no search
			$queryS .= ";";
			$resultS = mysqli_query($connection->conn,$queryS);
			$flag2 = 1;
		}
		else $flag2 = 0;
		$queryD = "DROP VIEW vi;";
		$resultD = mysqli_query($connection->conn,$queryD);
		
		mysqli_commit($connection->conn);
 
	
	}
	
?>
	

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta http-equiv="content-language" content="en" />

		<title>Search</title>
		
		<link href="css/horizontal_menu.css" rel="stylesheet" type="text/css" />
		
	</head>
	
	<body>
		<form method="post" action="">
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

		<h3>Search by:</h3>
				<table>
					<tr>
						<td>Genus:</td><td><input type="text" name="genus" id="genus" /></td>
						<td>Species:</td><td><input type="text" name="species" id="species" /></td>
						<td>Order:</td><td><input type="text" name="order" id="order"/></td>
						<td>Family:</td><td><input type="text" name="family" id="family"/></td>
						<td>Common name:</td><td><input type="text" name="common" id="common"/></td>
					</tr>
					<tr>
						<td>Neighborhood:</td><td><input type="text" name="neighborhood" id="neighborhood"/></td>
						<td>City:</td><td><input type="text" name="city" id="city" value="<?php echo $city;?>"/></td>
						<td>State:</td><td><input type="text" name="state" id="state" value="<?php echo $state;?>"/></td>
						<td>Country:</td><td><input type="text" name="country" id="country" value="<?php echo $country;?>"/></td>
						<td>Continent:</td><td><input type="text" name="continent" id="continent"/></td>
					</tr>
					<tr>
						<td>Weather:</td><td><input type="text" name="weather" id="weather"/></td>
						<td>Habitat:</td><td><input type="text" name="habitat" id="habitat"/></td>	
					</tr>
				</table>
				<br/>
				Show me all of the birds that were seen between: Date 1:<input type="text" name="date" id="date"/> and Date 2:<input type="text" name="date2" id="date2"/>
				<br />
				Birds seen in yards <input type="checkbox" name="yard" id="yard" value = "1"/>
				<br />
				Birds seen in one of the lower 48 states<input type="checkbox" name="lower48" id="lower48" value = "1"/>
				<br />

				Birds seen by the user:<input type="text" name="user" id="user" />
				<br />

				Note with words:<br/><textarea cols="40" name = "note" id = "note"></textarea><br/><br/>
				<input type="submit" value="Submit" /></a>
                		</br></br>
				<hr>

				Search for a user:<input type="text" name="useronly" id="useronly" />
				<br/>

				</br><input type="submit" value="Submit" /></a>
				<hr><br/>
				<div name = "data">
					<?php
					if($_POST){ 
						if($flag2){
							if(mysqli_num_rows($resultS) == 0){
								echo "No results for your search.";?>
							<br />
							<?php
							}
							else{
								$searchData = array();
								while($row = mysqli_fetch_array($resultS, MYSQLI_ASSOC))
								{	
									$searchData[] = $row;
								}
								?>
								You have <?php echo mysqli_num_rows($resultS); ?> results: <br/>
								<table border=1>
								<tr>
									<th>Scientific Name</th>
									<th>Common Name</th>
									<th>Note</th>
									<th>Date of View</th>
									
								
								</tr>
								<?php 
								foreach ($searchData as $data)
								{
							
								?>
								<tr>
									<td><?php echo $data['Genus']; ?> <?php echo $data['Species']; ?></td>
									<td><?php echo $data['Common_Name']; ?></td>
									<td><?php echo substr($data['Notes'], 0, 50); ?><a href='view.php?bi=<?php echo $data['BirdID']; ?>&lo=<?php echo $data['LocationID']; ?>' style="text-decoration:none"> (View more)</a> </td>
									<td><?php echo $data['Date']; ?></td>
									
								</tr>
								
							<?php
								}
							}
						}
					else if($flag3){
							if(mysqli_num_rows($resultU) == 0){
								echo "No users for your search.";?>
							<br />
							<?php
							}
							else{
							$searchData = array();
							while($row = mysqli_fetch_array($resultU, MYSQLI_ASSOC))
							{	
								$searchData[] = $row;
							}
							?>
							You have <?php echo mysqli_num_rows($resultU); ?> users: <br/>
							<table border=1>
								<tr>
									<th>Name</th>
										
								
								</tr>
							<?php 
							foreach ($searchData as $data)
							{
							
							?>
								<tr>
									
									<td><?php echo substr($data['Notes'], 0, 50); ?><a href='user.php?bi=<?php echo $data['UserID']; ?>' style="text-decoration:none"> <?php echo $data['First_Name']." ".$data['Last_Name'];  ?></a> </td>
																		
								</tr>
								
							<?php
							}
							}
					}
					else echo "Empty fields";
				}

				?>
		
					
				</div>
			</div>
		</form>
	</body>
</html>