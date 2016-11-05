<?php
	ob_start();
	require_once("include.php");
	
	if($_SESSION['logged'] == true) //display page deals with different levels of users
	{
		header('Location: ./display.php');
	}
	
	if($_POST)
	{
		$error = array();
		extract($_POST);
		
		//verify empty field
		if(!notEmpty(mysqli_real_escape_string($connection->conn,$username)))
		{
			$error['login']="<small style='color:red'>Mandatory field.</small><br/>";
		}
		if(!notEmpty(mysqli_real_escape_string($connection->conn,$password)))
		{
			$error['password']="<small style='color:red'>Mandatory field.</small><br/>";
		}
		
		if(empty($error))
		//verify user existence
		{
			//Search the user on the db
			$password = mysqli_real_escape_string($connection->conn,$password);
			$password = md5($password);
			$username = mysqli_real_escape_string($connection->conn,$username);
			$username = md5($username);

			$query="SELECT First_Name, UserID, LevelUser FROM users WHERE UserID = '".$username."' AND Password = '".$password."';";
			$result = mysqli_query($connection->conn,$query);
			
			$counter = mysqli_num_rows($result);
			
			
			if($counter == '1')
			{
				while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
				{
					
					$_SESSION['username'] = $row['UserID'];
					$_SESSION['leveluser'] = $row['LevelUser'];
				}
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
<meta http-equiv="content-Type" content="text/html; charset=iso-8859-1" /> 
	<head>
	
		<title>Birder</title>
	</head>
	<body >
		<div id="all" align = "center">

		<img src = "css/birder_sem_fundo.jpg"><h3>Welcome to Birder! The best way to keep track of your birds!</h3>


		
	<div id="login" align="center" >
		 <form method ='POST' action=" ">
			 <fieldset>
			 	
				<small style='color:blue'>*If you don't have login you can use login "guest@birder.com" and password "guest" (for search only) or <a href="register.php">Register now</a>.</small><br /> <br />

				<table>

					<tr>
					<td><label for="username">Email: </label></td>
					<td ><input type="text" id="username" name="username" /></td>
					
					</tr>
					<tr>
					<td></td>
					<td><?php echo "<span style='color:red'>".$error['login']."</span>";?></td>
					</tr>
					<tr>
				
					</tr>
					<tr>
				
					</tr>
					<tr>
					<td><label for="password">Password: </label></td>
					<td ><input type="password" id="password" name="password" /></td>
					
					</tr>
					<tr>
						<td></td>
						<td><?php echo "<span style='color:red'>".$error['password']."</span>";?></td>
					</tr>
					
										
							
				</table>
				<br/>
				<?php echo "<span style='color:red'>".$error['data']."</span>"."<br />";?></td>

				<br/>
				<input id="reset" name="reset" type="reset" value="Reset"/>
					<input id="submit" name="submit" type="submit" value="Submit" /><br />	
				</fieldset>
			</form>
		</div>
	<div>
	</body>
</html>

