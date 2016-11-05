<?php 
	extract($_POST);
	$queryE="INSERT INTO Bird VALUES ('ID', '$genus', '$species', '$order', '$family', '$common');";
	$resultE = mysql_query($queryE);
	if (!$resultE)
	{				
		echo "Error";	
	}			
	
	
	$queryE="INSERT INTO Location VALUES (...);";
	$resultE = mysql_query($queryE);
	if (!$resultE)
	{				
		echo "Error";	
	}	

	$queryE="INSERT INTO Notes VALUES (...);";
	$resultE = mysql_query($queryE);
	if (!$resultE)
	{				
		echo "Error";	
	}		
	
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >

    <head>
        <title>Bird Database Interface</title>

        <link href="css/horizontal_menu.css" rel="stylesheet" type="text/css" />

    </head>

    <body>
	
		<p><div id="navbar">
			<ul>
			    <li><a href="index.htm">Home Page</a></li>
				<li><a href="search.php">Search</a></li>
                <li><a href="logout.php">logout</a></li>
            </ul>
        </div></p>

				<h3>Would you like to perform a search, or merely count the number of times that your search term appears in the database?</h3>				
				
				<input type="radio" name="desire" value="search">Preform a search
				<input type="radio" name="desire" value="count">Preform a count
				
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
						<td>Date:</td><td><input type="text" name="date" id="date"/></td>
					</tr>						
					<tr>
						<td>Habitat:</td><td><input type="text" name="habitat" id="habitat"/></td>
					</tr>
				</table>
				
				<br />
				Was the bird seen in your yard?<input type="checkbox" name="yard" id="yard"/>
				<br />
				Was the bird seen in one of the lower 48 states?<input type="checkbox" name="lower48" id="lower48"/>
				<br />
						
                <select name="content" id="americanLaw2" style = "display: none">
                    <option value=" " selected="selected">Pick a content</option>
                    <option value="content1">North America</option>
                    <option value="content2">South America</option>
                    <option value="content3">Europe</option>
                    <option value="content4">Australia</option>                   
                    <option value="content5">Asia</option>
                    <option value="content6">Antartica</option>
                    <option value="content7">Africa</option>
                </select>     
				<br />
				<textarea cols="40" rows="25">Please place any additional notes here.</textarea>

            </div> <br /> <br />

            <div style="float:left; margin-left:10px">
                <a href="display.php"><input type="button" value="Submit" /></a>
                <input type="reset" value="Reset form"/>
            </div>

        </form>

    </body>

</html>