<?php
	ob_start();
     
	require_once ("include.php");
	

	if($_POST)
	{
		

		if($_SESSION['logged']){
			
			unset($_SESSION['logged']);
			unset($_SESSION['username']) ;
			unset($_SESSION['level'] );
			unset($_SESSION['fname'] );

			}

		$error = array();
		extract($_POST);
		if(equals(mysqli_real_escape_string($connection->conn,$fname),""))
			$error['fname'] = "Mandatory field";
		if(equals(mysqli_real_escape_string($connection->conn,$lname),""))
			$error['lname'] = "Mandatory field";
			
		if(!equals(mysqli_real_escape_string($connection->conn,$email), mysqli_real_escape_string($connection->conn,$confirm_email)))
			$error['email'] = "The fields Email and Confirm Email must be the same.";	
		
		if(!ereg('^([0-9a-zA-Z]+([_.-]?[0-9a-zA-Z]+)*@[0-9a-zA-Z]+[0-9,a-z,A-Z,.,-]*(.){1}[a-zA-Z]{2,4})+$',mysqli_real_escape_string($connection->conn,trim($_POST['email']))))
			$error['email'] = "This email is not an email.";
			
		if(equals(mysqli_real_escape_string($connection->conn,$email),""))
			$error['email'] = "Mandatory field";
						
		if(equals(mysqli_real_escape_string($connection->conn,$confirm_email),""))
			$error['confirm_email'] = "Mandatory field";
		
		if(equals(mysqli_real_escape_string($connection->conn,$password),""))
			$error['password'] = "Mandatory field";
		
		if(!equals(mysqli_real_escape_string($connection->conn,$password), mysqli_real_escape_string($connection->conn,$confirm_password)))
			$error['password'] = "The fields Password and Confirm Password must be the same.";
			
		if(equals(mysqli_real_escape_string($connection->conn,$confirm_password),""))
			$error['confirm_password'] = "Mandatory field";

		if(equals(mysqli_real_escape_string($connection->conn,$city),""))
			$error['city'] = "Mandatory field";
		
		if(equals(mysqli_real_escape_string($connection->conn,$state),""))
			$error['state'] = "Mandatory field";

		if(equals(mysqli_real_escape_string($connection->conn,$country),""))
			$error['country'] = "Mandatory field";

		
		
		if(empty($error['email']))
		{
			$query = "SELECT UserID FROM users WHERE UserID = '".$email."';";
			$result = mysqli_query($connection->conn,$query);
			
			if(mysqli_num_rows($result) == 1){
				$error['email']='Email already registered.';
			}
			
		}
			
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


		if(empty($error)){			
						
			
				$sql = "INSERT INTO users VALUES('".md5(mysqli_real_escape_string($connection->conn,trim($email)))."','".mysqli_real_escape_string($connection->conn,trim($lname))."','".mysqli_real_escape_string($connection->conn,trim($fname))."', '".md5(mysqli_real_escape_string($connection->conn,trim($password)))."', '1','".$new_file."','".mysqli_real_escape_string($connection->conn,trim($city))."','".mysqli_real_escape_string($connection->conn,trim($state))."','".mysqli_real_escape_string($connection->conn,trim($country))."', '".$about."');";
		
				$result = mysqli_query($connection->conn,$sql);
				mysqli_commit($connection->conn);
			
				

				if($result){
					$_SESSION['username'] = md5($email);
					$_SESSION['leveluser'] = 1;
					$_SESSION['logged'] = true;
					header('Location: ./display.php');
				}

		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta http-equiv="content-language" content="en" />
		
		<title>New User</title>
	</head>
	<body>
		<form method="post" action="" enctype="multipart/form-data">
			<h1>User Register</h1>
			<fieldset>
				<legend>User Information</legend>
				
			<table>
				

				<tr>

				<td><label for="email">Email*: </label></td>
				<td><input type="text" id="email" name="email"
				value="<?php echo $_POST['email'];?>" /><br />
				<small style="color:red"><?php echo $error['email'];?></small></td>
				
				</tr>

				
				<tr>
				
				<td><label for="confirm_email">Confirm Email*: </label></td>
				<td><input type="text" id="confirm_email" name="confirm_email"
				value="<?php echo $_POST['confirm_email'];?>" /><br />
				<small style="color:red"><?php echo $error['confirm_email'];?></small></td>

				</tr>

				<tr>				

				<td><label for="password">Password*: </label></td>
				<td><input type="password" id="password" name="password" /><br />
				<small style="color:red"><?php echo $error['password'];?></small></td>
				

				</tr>
				
				<tr>

				<td><label for="confirm_password">Confirm Password*: </label></td>
				<td><input type="password" id="confirm_password" name="confirm_password" /><br />
				<small style="color:red"><?php echo $error['confirm_password'];?></small></td>

				</tr>

				<tr>

				<td><label for="name">First Name*: </label></td>
				<td><input type="text" id="fname" 
				name="fname" value="<?php echo $_POST['First_name'];?>" /><br />
				<small style="color:red"><?php echo $error['fname'];?></small></td>
				
				</tr>
				
				<tr>

				<td><label for="name">Last Name*: </label></td>
				<td><input type="text" id="lname" 
				name="lname" value="<?php echo $_POST['Last_Name'];?>" /><br />
				
				<small style="color:red"><?php echo $error['lname'];?></small></td>
				
				</tr>
				
				<tr>
				
				<td><label for="name">City*: </label></td>
				<td><input type="text" id="city" 
				name="city" value="<?php echo $_POST['City'];?>" /><br />
				
				<small style="color:red"><?php echo $error['city'];?></small></td>
				

				</tr>

				<tr>

				<td><label for="name">State*: </label></td>
				<td><input type="text" id="state" 
				name="state" value="<?php echo $_POST['State'];?>" /><br />
				
				<small style="color:red"><?php echo $error['state'];?></small></td>
				</tr>

				<tr>
				<td><label for="name">Country*: </label></td>
				<td><input type="text" id="country" 
				name="country" value="<?php echo $_POST['Country'];?>" /><br />
				
				<small style="color:red"><?php echo $error['country'];?></small></td>
				</tr>
				
							
				<tr>		
				<td><label for="file" >Photo: (max. 190x150) </label></td>
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
					<textarea cols="33" rows="15" name = "about" id = "about" onkeyup="blocText(this.value)"><?php echo $note;?></textarea><br/>
					You still have: <span id="count">1000</span> characteres<br/><br/>

		

				
				
				
				<br/>
				<br/>
				
				<input type="submit" name="submit" id="submit" value="Submit" />
				<a href= './login.php' style="text-decoration:none"><input type="button" name="cancel" id="cancel" value="Cancel" /></a>

			</fieldset>
		</form>
	</body>
</html>