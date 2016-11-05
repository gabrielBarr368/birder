<?php
	ob_start();
	require_once("include.php");
	
	isLogged(1);//Level 0 for guest, level 1 for registered user. If 0, goes to search page.
		
	
	$page = $_GET['page'];
	$num_by_page = 8; 
	if (!$page) {
     		$page = 1;
 	 }
	$first_register = ($page*$num_by_page) - $num_by_page;
	


	 
	//data retrieval for the user
	$query = "SELECT bird.Genus, bird.Species,bird.Common_Name, notes.Photo, notes.Date,notes.Notes, notes.LocationID,notes.BirdID FROM notes INNER JOIN bird WHERE bird.BirdID = notes.BirdID AND notes.UserID ='".$_SESSION['username']."' ORDER BY notes.Date DESC LIMIT ".$first_register.",".$num_by_page.";"; 
	$result = mysqli_query($connection->conn,$query);
	
	$queryC = "SELECT bird.Genus, bird.Species,bird.Common_Name, notes.Photo, notes.Date,notes.Notes, notes.LocationID,notes.BirdID FROM notes INNER JOIN bird WHERE bird.BirdID = notes.BirdID AND notes.UserID ='".$_SESSION['username']."';"; 
	$resultC = mysqli_query($connection->conn,$queryC);
	$rowC = mysqli_fetch_array($resultC, MYSQLI_ASSOC);

	$userData = array();
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		$userData[] = $row;
	}
	$total_pages = ceil(mysqli_num_rows($resultC)/$num_by_page);
	
		
	$prev = $page - 1;
	$next = $page + 1;
			if ($page > 1) {
   				$prev_link = "<a href= 'display.php?page=".$prev."'>Previous</a>";
  			} else { // senão não há link para a página anterior
    					$prev_link = "Previous";
 			 }
			if ($total_pages > $page) {
    					$next_link = "<a href='display.php?page=".$next."\'>Next</a>";
 			 } else { 
					// senão não há link para a próxima página
    					$next_link = "Next";
  			}

			
			$panel = "";
  			for ($x=1; $x<=$total_pages; $x++) {
   				 if ($x==$page) { 
					// se estivermos na página corrente, não exibir o link para visualização desta página 
     					 $panel .= " [$x] ";
   				 } else {
     						 $panel .= " <a href=\"$PHP_SELF?page=$x\">[$x]</a>";
   				 }
 			}	
	
	$query2 = "SELECT First_Name FROM users WHERE UserID = '".$_SESSION['username']."';";	
	$result2 = mysqli_query($connection->conn,$query2);
	$row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC);
	$_SESSION['fname'] = $row2['First_Name'];

	$query3 = "Select Photo, BirdID, LocationID, actual FROM notes WHERE Photo != '' ORDER BY actual DESC LIMIT 0,3;";
	$result3 = mysqli_query($connection->conn,$query3);

	
	mysqli_commit($connection->conn);
	
	
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta http-equiv="content-language" content="en" />
		<style type="text/css">
			<!--
				.photoes{
					padding: 7px 7px 7px 7px;
					border:1px inset;
					border-color: black;
					width:90px;
					height:90px;
					
							
				}
				

				.updates{
					padding: 10px 10px 10px 10px;
					border:1px inset;
					border-color: black;
					width:130px;
					height:130px;
					margin-left: 18px;

				}
				
				
				
			-->
		</style>

	<title>Home</title>
		<link href="css/horizontal_menu.css" rel="stylesheet" type="text/css" />
		<link href="css/style.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
	
	<div id="logo">

			<img id="birder" src='css/birder_fundo.jpg'><br/><br/>

			<h4><i><center>Last Photoes</h4></i></center>
			<?php 
				while($row3 = mysqli_fetch_array($result3, MYSQLI_ASSOC))
				{
					$photoes[] = $row3;
				}

				foreach ($photoes as $photo)
				{
				?>
					<a href='./view.php?bi=<?php echo $photo['BirdID']; ?>&lo=<?php echo $photo['LocationID']; ?>' style="text-decoration:none"> <img src='<?php echo $photo['Photo']; ?>' class="updates"></a><br/>
				<?php 
				} 
				?>



		</div>
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
			
			<?php
				if(mysqli_num_rows($result) == 0){
				echo "<center><h3><i>You don't have any record yet. Start right now: just press 'New Bird' on the menu! </i></h3></center><br />"; ?>
				
				<?php
				}
			else{
								
				?>
				<center><i><h3>These are all your records until today:</h3></i> 
				<table>
				
					<?php 
				$counter=1;
				?> <tr> <?php
				foreach ($userData as $data)
				{
					
					if($counter %3 != 0){?>
						
						<td>
						<a href='./view.php?bi=<?php echo $data['BirdID']?>&lo=<?php echo $data['LocationID']?>' style="text-decoration:none"> <img src='
							<?php 
								if ($data['Photo'] =="") 
									$data['Photo'] = "photoes/birder_no_photo.jpg";
								echo $data['Photo']; 
							?>
						' class="photoes"></a><br/>
						
						<small><a href='./alter.php?bi=<?php echo $data['BirdID']?>&lo=<?php echo $data['LocationID']?>'>Alter</a> |
						<a href='./delete.php?bi=<?php echo $data['BirdID']?>&lo=<?php echo $data['LocationID']?>' onclick="javascript: return confirm('Confirm delete choice');">Delete</a></small><br/><br/>
						</td>
						<td>
						<i><small><?php echo $data['Genus']?> <?php echo $data['Species']?></small></i><br/>
						<small><?php echo $data['Common_Name']?></small><br/>
						
						</td>
						<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>

						

				<?php	
					
					}else{ ?>
						</tr>
						<tr>
							<td>
							<a href='./view.php?bi=<?php echo $data['BirdID']?>&lo=<?php echo $data['LocationID']?>' style="text-decoration:none"> <img src='
							<?php 
								if ($data['Photo'] =="") 
									$data['Photo'] = "photoes/birder_no_photo.jpg";
								echo $data['Photo']; 
								?>
								' class="photoes"></a><br/>
						
								<small><a href='./alter.php?bi=<?php echo $data['BirdID']?>&lo=<?php echo $data['LocationID']?>'>Alter</a> |
								<a href='./delete.php?bi=<?php echo $data['BirdID']?>&lo=<?php echo $data['LocationID']?>' onclick="javascript: return confirm('Confirm delete choice');">Delete</a></small><br/><br/>
								</td>
								<td>
								<i><small><?php echo $data['Genus']?> <?php echo $data['Species']?></small></i><br/>
								<small><?php echo $data['Common_Name']?></small><br/>
								
								</td>
								<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>




						
					<?php 
						$counter=1;
						}
					$counter++;
					
										
				}
			}
				?>
			</table></center>
			<?php
				
					// exibir painel na tela
				echo "<center> $prev_link | $panel | $next_link </center>";
				
	
			?>
			
		</div>
		
	</div>
		<br/><br/>
	
			
	</div>	
	<div id="foot">
		</div>
	
	</body>
</html>