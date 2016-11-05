<?php
	require_once("include.php");
	
	isLogged('./login.php', 1); //level 0 for guest, level 1 for registered user
	
	if($_SESSION['level'] >= 1){
		header("location: ./search.php");
	}
?>



<html>
	<head>
		<title>Display</title>
	</head>
	<body>
	
		<p><div id="navbar">
			<ul>
				<li><a href="search.php">Search</a></li>
                <li><a href="input.php">Enter New Data</a></li>
                <li><a href="logout.php">logout</a></li>
            </ul>
        </div></p>

			<input type="button" value="Back" onClick="history.go(-1);return true;">
			
	</body>
</html>