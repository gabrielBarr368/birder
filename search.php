<html>

	<head>
	
		<title>Search</title>
		
		<link href="css/horizontal_menu.css" rel="stylesheet" type="text/css" />
		
	</head>
	
	<body>
		
		<div align="center">
		<p><div id="navbar" align="center">
			<ul>
				<li><a href="index.php">Home Page</a></li>
                <li><a href="input.php">Enter New Data</a></li>
                <li><a href="logout.php">logout</a></li>
            </ul>
        </div></p>
		
		<p>Please choose what type of search you want to do (Note: you can do both at once if you want to.  You will also always be informed of how many results were found.):</p>
		<p><input type="checkbox" name="search" value="search" />Search (Choose this if you merely want to search for a particular bird or location)</p>
		<p><input type="checkbox" name="count" value="count" />Count (Choose this if you want to count either the number of times that you have seen a particular bird or how many birds you have seen in one particular location)</p>
			
		
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
						<td colspan="2">North America:<input type="checkbox" name="neighborhood" id="neighborhood"/></td>
						<td colspan="2">South America:<input type="checkbox" name="latitude" id="latitude"/></td>
						<td colspan="2">Europe:<input type="checkbox" name="longitude" id="longitude"/></td>
						<td colspan="2">Australia:<input type="checkbox" name="weather" id="weather"/></td>
						<td colspan="2">Asia:<input type="checkbox" name="habitat" id="habitat"/> Antartica:<input type="checkbox" name="weather" id="weather"/> Africa:<input type="checkbox" name="habitat" id="habitat"/></td>
					</tr>
				</table>
					Show me all of the birds that I saw between: Date 1:<input type="text" name="date" id="date"/> and Date 2:<input type="text" name="date2" id="date2"/>
					</tr>
				
				
				<br />
				Was the bird seen in your yard?<input type="checkbox" name="yard" id="yard"/>
				<br />
				Was the bird seen in one of the lower 48 states?<input type="checkbox" name="lower48" id="lower48"/>
				<br />
			</div>
	</body>
</html>