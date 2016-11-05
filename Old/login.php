<?php

	session_start();
	
	if($_POST){
		
		$login = new Login($_POST['username'], $_POST['password']);

		if(trim($_POST['username'])==""){ 
				$error['username']="Mandatory field"."<br />";
		}
		if(trim($_POST['password'])==""){ 
				$error['password']="Mandatory field"."<br />";
		}
		
		
		if(empty($error)){
			if($login->validation()){ //we need to write a function to validate the login, that`s what this field will check: userid and password at the database
				//header('location: ./index.php');
				$_SESSION['logged']="logged";
				
			}
			else {
				echo "Validation error.";
			}	
		}
		

	}
	
?>
	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		
		<meta http-equiv="content-language" content="en" />
		
		
		<title>Login</title>
	</head>
	<body>
		
	<div id="login">
		 <form method ='POST' action=" ">
			 <fieldset>
			 <label for="username">Username: </label>
					<input type="text" id="username" name="username" />
					<br /> 
				<?php echo "<span style='color:red'>".$error['login']."</span>"."<br />";?>
				
				
				<label for="password">Password: </label>
					<input type="password" id="password" name="password" />
					<br /> 
					<?php echo "<span style='color:red'>".$error['password']."</span>"."<br />";?>
				
				<input id="reset" name="reset" type="reset" value="Reset"/><br />
					<input id="submit" name="submit" type="submit" value="Submit" /><br />	
				</fieldset>
			</form>
		</div>
	</body>
</html>

