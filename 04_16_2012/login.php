<?php
	require_once("include.php");
	
	if($_SESSION['logged'] == true)
	{
		header('Location: ./display.php');
	}
	
	if($_POST)
	{
		$error = array();
		extract($_POST);
		
		//verify empty field
		if(!notEmpty($username))
		{
			$error['login']="<small style='color:red'>Mandatory field.</small><br/>";
		}
		if(!notEmpty($password))
		{
			$error['password']="<small style='color:red'>Mandatory field.</small><br/>";
		}
		
		if(empty($error))
		//verify user existence
		{
			//Search the user on the db
			$query="SELECT UserID, Password FROM users WHERE UserID LIKE '".mysql_real_escape_string($username)."' AND password = '".md5($password)."';";
			$result = mysql_query($query);
			$data = mysql_fetch_assoc($result);
			
			if(mysql_num_rows($result) == 1)
			{
				$_SESSION['username'] = $data['UserID'];
				$_SESSION['level'] = $data['Level'];
				$_SESSION['logged'] = true;
				
				header('Location: ./display.php');
				
			}
			else
			{
				$error['data'] = "<small style='color:red'>Login/Password not found.</small>";
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
					<br />
					<?php echo "<span style='color:red'>".$error['data']."</span>"."<br />";?>
					
					<small style='color:blue'>*If you don't have login you can use login and password "guest" (for search only) or <a href="register.php">Register now</a>.</small><br /> <br />
				
				<input id="reset" name="reset" type="reset" value="Reset"/>
					<input id="submit" name="submit" type="submit" value="Submit" /><br />	
				</fieldset>
			</form>
		</div>
	</body>
</html>

