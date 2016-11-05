<?php




function notEmpty($value){
		$value = trim($value); // take away any space character from end or beginning
		if($value == ""){ // veryfies if user wrote valid string
			return false;
		}
		else{
			return true;
		}
	}


function equals($value, $compare) {
		$value = trim($value); // take away any space character from end or beginning
		$compare = trim($compare); // take away any space character from end or beginning
		if(strcmp($value, $compare) != 0)
			return false;
		else
			return true;
	}

function isLogged($page, $level)
	{
		// if not logged goes to main page
		if($_SESSION['logged'] != true)
		{
			header("Location: $pagina");
			return false;
		}
		// if level not equal to needed one
		else if(isset($_SESSION['level']))
		{
			if((int)$_SESSION['level'] < (int)$level)
			{
				header("Location: $pagina");
				return false;
			}
		}
		return true;
	}

?>