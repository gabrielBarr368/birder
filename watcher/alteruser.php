<?php
	ob_start();
     
	require_once ("include.php");
	

	$queryA = "SELECT * FROM users WHERE UserID = '".$_SESSION['username']."';";
	$resultA = mysqli_query($connection->conn,$queryA);
	mysqli_commit($connection->conn);
	
	$rowA = mysqli_fetch_array($resultA,MYSQLI_ASSOC);

	$fname = $rowA['First_Name'];
	$lname = $rowA['Last_Name'];
	$city = $rowA['City'];
	$state = $rowA['State'];
	$country = $rowA['Country'];
	$old_file = $rowA['Photo'];
	$about = $rowA['About'];

	

	if($_POST)
	{
		
		$error = array();
		extract($_POST);

		if(equals(mysqli_real_escape_string($connection->conn,$fname),""))
			$error['fname'] = "Mandatory field";
		if(equals(mysqli_real_escape_string($connection->conn,$lname),""))
			$error['lname'] = "Mandatory field";
			
		if(equals(mysqli_real_escape_string($connection->conn,$city),""))
			$error['city'] = "Mandatory field";
		
		if(equals(mysqli_real_escape_string($connection->conn,$state),""))
			$error['state'] = "Mandatory field";

		if(equals(mysqli_real_escape_string($connection->conn,$country),""))
			$error['country'] = "Mandatory field";
					

		
		
				
		if($_FILES['userfile']['name'] != "") {
                         $allowed_filetypes = array('.gif','.jpg','.jpeg','.png','.JPG','.GIF','.JPEG','.PNG');
                          $max_filesize = 2097152; // (currently 2.0MB).
                          $upload_path = './photoes_user/'.md5($email).'/';
 				
			if(!file_exists($upload_path)) // if dir doesn't exists, it will create
				mkdir($upload_path,0777);

                       $filename = $_FILES['userfile']['name'];
                       $ext = substr($filename, strpos($filename,'.'), strlen($filename)-1);

                    list($width, $height, $type, $attr) = getimagesize($_FILES['userfile']['tmp_name']);
                    if ($width > 1920 || $height > 1200)
                        $error['exceeded'] = "Maximum width and height exceeded. The maximum size is 190x150.";
 
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
		else{
			$new_file = $old_file;	
		}


		if(empty($error)){			
						
			
				$sql = "UPDATE users SET Last_Name = '".mysqli_real_escape_string($connection->conn,trim($lname))."', First_Name = '".mysqli_real_escape_string($connection->conn,trim($fname))."', Photo = '".$new_file."', City = '".mysqli_real_escape_string($connection->conn,trim($city))."', State = '".mysqli_real_escape_string($connection->conn,trim($state))."', Country = '".mysqli_real_escape_string($connection->conn,trim($country))."', About = '".$about."' WHERE UserID = '".$_SESSION['username']."';";
		
				$result = mysqli_query($connection->conn,$sql);
				mysqli_commit($connection->conn);
				header('Location: ./useradmin.php');
				

		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta http-equiv="content-language" content="en" />
		
		<title>Change Information</title>
	</head>
	<body>
		<form method="post" action="" enctype="multipart/form-data">
			<fieldset>
				<legend>User Information</legend>
				
			<table>
				

				<tr>

				<td><label for="name">First Name*: </label></td>
				<td><input type="text" id="fname" 
				name="fname" value="<?php echo $fname; ?>" /><br />
				<small style="color:red"><?php echo $error['fname'];?></small></td>
				
				</tr>
				
				<tr>

				<td><label for="name">Last Name*: </label></td>
				<td><input type="text" id="lname" 
				name="lname" value="<?php echo $lname; ?>" /><br />
				
				<small style="color:red"><?php echo $error['lname']; ?></small></td>
				
				</tr>
				
				<tr>
				
				<td><label for="name">City*: </label></td>
				<td><input type="text" id="city" 
				name="city" value="<?php echo $city; ?>" /><br />
				
				<small style="color:red"><?php echo $error['city'];?></small></td>
				

				</tr>

				<tr>

				<td><label for="name">State*: </label></td>
				<td><input type="text" id="state" 
				name="state" value="<?php echo $state; ?>" /><br />
				
				<small style="color:red"><?php echo $error['state'];?></small></td>
				</tr>

				<tr>
				<td><label for="name">Country*: </label></td>
				<td><input type="text" id="country" 
				name="country" value="<?php echo $country;?>" /><br />
				
				<small style="color:red"><?php echo $error['country'];?></small></td>
				</tr>
				
							
				<tr>		
				<td><label for="file">Photo: (max. 190x150) </label></td>
				<td><input type="hidden" name="MAX_FILE_SIZE" value="2097152" />
				<input type="file" name="userfile" id="userfile" /><br /> 
				<small style="color:red"><?php echo $error['type']; ?></small>
				<small style="color:red"><?php echo $error['size']; ?></small>
				<small style="color:red"><?php echo $error['path']; ?></small>
				<small style="color:red"><?php echo $error['up']; ?></small>
				<small style="color:red"><?php echo $error['exceeded']; ?></small></td>
				
				</tr>

			</table>

				
				
					Tell us something about you and the birds! <br />
					<textarea cols="33" rows="15" name = "about" id = "about" onkeyup="blocText(this.value)"><?php echo $about;?></textarea><br/>
					You still have: <span id="count">1000</span> characteres<br/><br/>

		

				
				
				
				<br/>
				<br/>
				
				<input type="submit" name="submit" id="submit" value="Submit" />
				<a href= './useradmin.php' style="text-decoration:none"><input type="button" name="cancel" id="cancel" value="Cancel" /></a>

			</fieldset>
		</form>
	</body>
</html>