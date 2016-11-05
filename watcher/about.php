<?php
	ob_start();
	require_once("include.php");
	
	isLogged(0);//Level 0 for guest, level 1 for registered user. If 0, goes to search page.
		
	 
	
	
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
		<div id = "log"><p align = "center"><small style="color:green">Logged as <a href="./useradmin.php"> <?php echo $_SESSION['fname']; ?> </a></small></p></div>
		<div id="all"	>
		<div id="data" align = "left">
			
			

			<p> This is a project developed by <a href="mailto:ysiquei1@ithaca.edu" style="text-decoration:none">Yaissa Siqueira</a> 
				and <a href="mailto:gbarr2@ithaca.edu" style="text-decoration:none">Gabriel Barr </a>
					as requirement for the Database Systems course
						at Ithaca College. <br>
							May/2012<br/>
							Ithaca, NY.<br/>
								</p>



	</div>
	</div>
	</div>
	</div>
			
	</body>
</html>
