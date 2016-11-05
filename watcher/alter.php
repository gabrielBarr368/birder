<?php 
	ob_start();
	require_once("include.php");
	
	isLogged(1);//Level 0 for guest, level 1 for registered user. If 0, goes to search page.
	
	if(!isset($_SESSION['timezone']))
	{
    		if(!isset($_REQUEST['offset']))
    		{
    			?>
   		 <script>
    			var d = new Date()
   			 var offset= -d.getTimezoneOffset()/60;
    			location.href = "<?php echo $_SERVER['PHP_SELF']; ?>?offset="+offset;
    		</script>
    		<?php   
    		}
    		else
    		{
       		 $zonelist = array('Kwajalein' => -12.00, 'Pacific/Midway' => -11.00, 'Pacific/Honolulu' => -10.00, 'America/Anchorage' => -9.00, 'America/Los_Angeles' => -8.00, 'America/Denver' => -7.00, 'America/Tegucigalpa' => -6.00, 'America/New_York' => -5.00, 'America/Caracas' => -4.30, 'America/Halifax' => -4.00, 'America/St_Johns' => -3.30, 'America/Argentina/Buenos_Aires' => -3.00, 'America/Sao_Paulo' => -3.00, 'Atlantic/South_Georgia' => -2.00, 'Atlantic/Azores' => -1.00, 'Europe/Dublin' => 0, 'Europe/Belgrade' => 1.00, 'Europe/Minsk' => 2.00, 'Asia/Kuwait' => 3.00, 'Asia/Tehran' => 3.30, 'Asia/Muscat' => 4.00, 'Asia/Yekaterinburg' => 5.00, 'Asia/Kolkata' => 5.30, 'Asia/Katmandu' => 5.45, 'Asia/Dhaka' => 6.00, 'Asia/Rangoon' => 6.30, 'Asia/Krasnoyarsk' => 7.00, 'Asia/Brunei' => 8.00, 'Asia/Seoul' => 9.00, 'Australia/Darwin' => 9.30, 'Australia/Canberra' => 10.00, 'Asia/Magadan' => 11.00, 'Pacific/Fiji' => 12.00, 'Pacific/Tongatapu' => 13.00);
       		 $index = array_keys($zonelist, $_REQUEST['offset']);
       		 $_SESSION['timezone'] = $index[0];
    		}
	}
		date_default_timezone_set($_SESSION['timezone']);


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
	if($resultA && !empty($genus)){//if $genus is empty, a mandatory field, means that somebody digited something not valid
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
			$queryC = "SELECT Notes,Date,Weather,Habitat,Photo FROM notes WHERE BirdID = '".$birdID."' AND LocationID = '".$locationID."' AND UserID = '".$_SESSION['username']."';";
			$resultC = mysqli_query($connection->conn,$queryC);
			while($row = mysqli_fetch_array($resultC, MYSQLI_ASSOC))
			{
				$note = $row['Notes'];
				$weather = $row['Weather'];
				$data = $row['Date'];
				$habitat = $row['Habitat'];
				$old_file = $row['Photo'];
				
			}
			
			
			if($resultC && !empty($data)){//if $data is empty, a mandatory field, means that somebody digited something not valid
				mysqli_commit($connection->conn);
							
				if($_POST)
				{
					$error = array();
					extract($_POST);
					
						
										
					if(notEmpty(mysqli_real_escape_string($connection->conn,$genus)) && notEmpty(mysqli_real_escape_string($connection->conn,$species)) && notEmpty(mysqli_real_escape_string($connection->conn,$city)) && notEmpty(mysqli_real_escape_string($connection->conn,$country)) && notEmpty(mysqli_real_escape_string($connection->conn,$state)) && notEmpty(mysqli_real_escape_string($connection->conn,$data))){
						

							
											
						$queryA="UPDATE bird SET Genus = '".mysqli_real_escape_string($connection->conn,$genus)."', Species = '".mysqli_real_escape_string($connection->conn,$species)."', BirdOrder = '".mysqli_real_escape_string($connection->conn,$order)."', Family = '".mysqli_real_escape_string($connection->conn, $family)."', Common_Name = '".mysqli_real_escape_string($connection->conn,$common)."' WHERE BirdID = '".$birdID."';";
						$resultA = mysqli_query($connection->conn,$queryA);
							
							if ($resultA)
							{														
								$queryB="UPDATE location SET City =  '".mysqli_real_escape_string($connection->conn, $city)."', Country = '".mysqli_real_escape_string($connection->conn, $country)."', State = '".mysqli_real_escape_string($connection->conn, $state)."', Latitude = '".mysqli_real_escape_string($connection->conn, $latitude)."', Longitude = '".mysqli_real_escape_string($connection->conn, $longitude)."', Neighborhood = '".mysqli_real_escape_string($connection->conn, $neighborhood)."', Yard =  '".mysqli_real_escape_string($connection->conn, $yard)."', Continent = '".mysqli_real_escape_string($connection->conn, $continent)."', Lower48 = '".mysqli_real_escape_string($connection->conn, $lower48)."' WHERE LocationID = '".$locationID."';";
								$resultB = mysqli_query($connection->conn,$queryB);
														
								if ($resultB)
								{		
										if($_FILES['userfile']['name'] != "" ) {
											$allowed_filetypes = array('.gif','.jpg','.jpeg','.png','.JPG','.GIF','.JPEG','.PNG');
                        					  			$max_filesize = 2097152; // (currently 2.0MB).
                         					 			$upload_path = './photoes/'.md5($_SESSION['username']).'/';
 				
											if(!file_exists($upload_path)) // if dir doesn't exists, it will create
												mkdir($upload_path,0777);

											$upload_path .= md5($birdID).'/';

											if(!file_exists($upload_path)) // if dir doesn't exists, it will create
												mkdir($upload_path,0777);


                      					 			$filename = mysqli_real_escape_string($connection->conn,trim($_FILES['userfile']['name']));
                      					 			$ext = substr($filename, strpos($filename,'.'), strlen($filename)-1);

                   									/*list($width, $height, $type, $attr) = getimagesize($_FILES['userfile']['tmp_name']);
                   						 			if ($width > 1920 || $height > 1200)
                       					 				$error['exceeded'] = "Maximum width and height exceeded. The maximum size is 190x150.";   not using this part*/ 
 
                       								if(!in_array($ext,$allowed_filetypes))
                             					 			$error['type'] = "The file you attempted to upload is not allowed.";
 
                       								if(filesize($_FILES['userfile']['tmp_name']) > $max_filesize)
                             								$error['size'] = "The file you attempted to upload is too large.  2MB maximum.";
 
                      					 			if(!is_writable($upload_path))
                             			 					$error['path'] = "You cannot upload to the specified directory, please CHMOD it to 777.";
 
                   				 					if (empty($error)) {
												$new_file = $upload_path . $filename;
                       									$filename = $_FILES['userfile']['name'];
                        				 					if(move_uploaded_file($_FILES['userfile']['tmp_name'],$upload_path . $filename))
                            				 					echo "Your file upload was successful.";
                        				  					else
                             			  						$error['up'] = "There was an error during the file upload. Please try again later or contact support.";
                 				  					}  
										}	
										else $new_file = $old_file;

							if(checkDateFormat($data)){
								if(substr($data,4,-5) == "/"){
									list($year, $month, $day) = explode("/", $data);
									$temp = (int)$year;
								

									if((int)date('Y') >= $temp){
										$temp2 = (int)$month;
									

										if((int)date('n')>= $temp2){
											$temp3 = (int)$day;
										

											if((int)date('d')>= $temp3){
												$data=$data;
											}else $error['invalidata'] = "<small style='color:red'>Invalid Date. Date must be before or today.</small><br/>";
										}else $error['invalidata'] = "<small style='color:red'>Invalid Date. Date must be before or today.</small><br/>";
									}else $error['invalidata'] = "<small style='color:red'>Invalid Date. Date must be before or today.</small><br/>";	
								}
								else if(substr($data,4,-5)== "-"){
									list($year, $month, $day) = explode("-", $data);
									$temp = (int)$year;
								

									if((int)date('Y') >= $temp){
										$temp2 = (int)$month;
									

										if((int)date('n')>= $temp2){
											$temp3 = (int)$day;
										

											if((int)date('d')>= $temp3){
												$data=$data;
											}else $error['invalidata'] = "<small style='color:red'>Invalid Date. Date must be before or today.</small><br/>";
										}else $error['invalidata'] = "<small style='color:red'>Invalid Date. Date must be before or today.</small><br/>";
									}else $error['invalidata'] = "<small style='color:red'>Invalid Date. Date must be before or today.</small><br/>";	
								}
								else $error['invalidata'] = "<small style='color:red'>Invalid Date. Date must be before or today.</small><br/>";
							}else $error['invalidata'] = "<small style='color:red'>Invalid Date. </small><br/>";

										
									if(empty($note)) $note = "No notes for this bird"; 
									$queryC="UPDATE notes SET Notes = '".$note."', Date = '".mysqli_real_escape_string($connection->conn, $data)."', Weather = '".mysqli_real_escape_string($connection->conn, $weather)."', Habitat = '".mysqli_real_escape_string($connection->conn, $habitat)."', Photo = '".$new_file."' WHERE UserID = '".$_SESSION['username']."' AND BirdID = '".$birdID."' AND LocationID = '".$locationID."';";  
									
									

									
									if (!empty($error)) //if resultC fails
									{				
																				
										mysqli_rollback($connection->conn);
									}
									else{
										$resultC = mysqli_query($connection->conn,$queryC);
										mysqli_commit($connection->conn);
										header('Location: ./display.php');
									}
									
								}
								else{ //if resultB fails
									
									mysqli_rollback($connection->conn);
									echo "Error";
								}
							}
							else{ 
								echo "Error";
								mysqli_rollback($connection->conn);
								
							}
					}
					else {
							$error['bird']="<small style='color:red'>Not Submited. Please check the mandatory fields.</small><br/>";	
						}
				}
				
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
		else{ //needs to unset variables because something went wrong on url
			echo "Something went wrong with the URL.";
			mysqli_rollback($connection->conn);
			$genus = "";
			$species = "";
			$order = "";
			$family = "";
			$common = "";
		}
	}
	else{
		echo "Something went wrong with the URL.";
		
	}
	
	
	
		
	
	
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta http-equiv="content-language" content="en" />

        <title>Alter Bird Information</title>

        <link href="css/horizontal_menu.css" rel="stylesheet" type="text/css" />

    </head>

    <body>
	<div id="all">	
		<form method="post" action="" enctype="multipart/form-data">
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

				<small>(*)Required fields</small>
				<table>
					<tr>
						<td>Genus*:</td><td><input type="text" name="genus" id="genus" value="<?php echo $genus;?>"/></td>
						<td>Species*:</td><td><input type="text" name="species" id="species" value="<?php echo $species;?>"/></td>
						<td>Order:</td><td><input type="text" name="order" id="order" value="<?php echo $order;?>"/></td>
						<td>Family:</td><td><input type="text" name="family" id="family" value="<?php echo $family;?>"/></td>
						<td>Common name:</td><td><input type="text" name="common" id="common" value="<?php echo $common;?>"/></td>
						
					</tr>
					<tr>
						<td>City*:</td><td><input type="text" name="city" id="city" value="<?php echo $city;?>"/></td>
						<td>State*:</td><td><input type="text" name="state" id="state" value="<?php echo $state;?>"/></td>
						<td>Country*:</td><td><input type="text" name="country" id="country" value="<?php echo $country;?>"/></td>
						<td>Neighborhood:</td><td><input type="text" name="neighborhood" id="neighborhood" value="<?php echo $neighborhood;?>"/></td>
					</tr>						
					<tr>
						
							<td>Latitude: </td><td><input type="text" name="latitude" id="latitude" value="<?php echo $latitude;?>"/></td>
							<td>Longitude: </td><td><input type="text" name="longitude" id="longitude" value="<?php echo $longitude;?>"/></td>
							<td>Weather:</td><td><input type="text" name="weather" id="weather" value="<?php echo $weather;?>"/></td>
							<td>Date*:<small style="color:green">(yyyy/mm/dd)</small>
							</td><td><input type="text" name="data" id="data" value="<?php echo $data;?>"/></td>
							<td>Habitat:</td><td><input type="text" name="habitat" id="habitat" value="<?php echo $habitat;?>"/></td>
					</tr>
				</table>
				<br/>
				Pick a continent: 
				<select name="continent" id="continent">
					<option <?php if ($continent == ' ') { ?>selected="true" <?php }; ?> value=" "> </option>
					<option <?php if ($continent == 'North America') { ?>selected="true" <?php }; ?> value="North America">North America</option>
					<option <?php if ($continent == 'South America') { ?>selected="true" <?php }; ?> value="South America">South America</option>
					<option <?php if ($continent == 'Europe') { ?>selected="true" <?php }; ?> value="Europe">Europe</option>
					<option <?php if ($continent == 'Australia') { ?>selected="true" <?php }; ?> value="Australia">Australia</option>                   
					<option <?php if ($continent == 'Asia') { ?>selected="true" <?php }; ?> value="Asia">Asia</option>
					<option <?php if ($continent == 'Antartica') { ?>selected="true" <?php }; ?> value="Antartica">Antartica</option>
					<option <?php if ($continent == 'Africa') { ?>selected="true" <?php }; ?> value="Africa">Africa</option>
				</select> 
				<br /><br />
				Was the bird seen in your yard?<input type="checkbox" name="yard" id="yard" value = "1" <?php if ($yard == '1') { ?> Checked="true" <?php }; ?>/>
				<br /><br />
				Was the bird seen in one of the lower 48 states?<input type="checkbox" name="lower48" id="lower48" value = "1" <?php if ($lower48 == '1') { ?> Checked="true" <?php }; ?>/>
				<br />
				<br />
				<input type="hidden" name="MAX_FILE_SIZE" value="2097152" />
					Do you want to upload a photo? (max 2MB) <input type="file" name="userfile" id="userfile" /><br />
					<small style="color:red"><?php echo $error['type']; ?></small>
					
					<small style="color:red"><?php echo $error['path']; ?></small>
					<small style="color:red"><?php echo $error['up']; ?></small>
					<small style="color:red"><?php echo $error['exceeded']; ?></small>
					<br />
					<br />
				Use the following space for notes:<br />
				<textarea cols="40" rows="25" name = "note" id = "note" onkeyup="blocText(this.value)"><?php echo $note;?></textarea><br/>
				You still have: <span id="count"><?php echo 1000 - strlen($note);?></span> characteres<br>
				<br /> <br />
					<input type="submit" value="Submit" /></a>
					<input type="reset" value="Reset form"/>
					<a href= './display.php' style="text-decoration:none"><input type="button" name="cancel" id="cancel" value="Cancel" /></a>
					<br/><?php echo $error['bird'];?>
					<br/><?php echo $error['invalidata'];?>
				
			</div>
        </form>
	</div>
    </body>

</html>