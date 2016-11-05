<html>

	<head>
	
		<title>Search</title>
		
		<link href="css/horizontal_menu.css" rel="stylesheet" type="text/css" />
		
	</head>
	
	<body>
	
		<p><div id="navbar">
			<ul>
				<li><a href="index.php">Home Page</a></li>
                <li><a href="input.php">Enter New Data</a></li>
                <li><a href="logout.php">logout</a></li>
            </ul>
        </div></p>
		
		Please choose what type of search you want to do (Note: you can do both at once if you want to):
			<input type="check" name="search" value="search" />Search (Choose this if you merely want to search for a particular bird or location)	
			<input type="check" name="count" value="count" />Count (Choose this if you want to count either the number of times that you have seen a particular bird or how many birds you have seen in one particular location)
			
		
				<table>
					<tr>
						<td>Genus:</td><td><input type="text" name="genus" id="genus"/></td>
						<td>Species:</td><td><input type="text" name="species" id="species"/></td>
						<td>Order:</td><td><input type="text" name="order" id="order"/></td>
						<td>Family:</td><td><input type="text" name="family" id="family"/></td>
						<td>Common name:</td><td><input type="text" name="common" id="common"/></td>
					</tr>
					<tr>
						<td>Neighborhood:</td><td><input type="text" name="neighborhood" id="neighborhood"/></td>
						<td>Latitude:</td><td><input type="text" name="latitude" id="latitude"/></td>
						<td>Longitude:</td><td><input type="text" name="longitude" id="longitude"/></td>
						<td>Weather:</td><td><input type="text" name="weather" id="weather"/></td>
						<td>Habitat:</td><td><input type="text" name="habitat" id="habitat"/></td>
					</tr>
					<tr>
						<td>North America:</td><td><input type="text" name="neighborhood" id="neighborhood"/></td>
						<td>South America:</td><td><input type="text" name="latitude" id="latitude"/></td>
						<td>Europe:</td><td><input type="text" name="longitude" id="longitude"/></td>
						<td>Australia:</td><td><input type="text" name="weather" id="weather"/></td>
						<td>Asia:</td><td><input type="text" name="habitat" id="habitat"/></td>
						<td>Antartica:</td><td><input type="text" name="weather" id="weather"/></td>
						<td>Africa:</td><td><input type="text" name="habitat" id="habitat"/></td>
					</tr>						
					<tr>
						<td>Date:</td><td><input type="text" name="date" id="date"/></td>
						<td>Date:</td><td><input type="text" name="date2" id="date2"/></td>
					</tr>
				</table>
				
				<br />
				Was the bird seen in your yard?<input type="checkbox" name="yard" id="yard"/>
				<br />
				Was the bird seen in one of the lower 48 states?<input type="checkbox" name="lower48" id="lower48"/>
				<br />
		
	</body>
</html>