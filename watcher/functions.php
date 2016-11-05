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

function isLogged($level)
	{
		// if not logged goes to login
		if($_SESSION['logged'] != true)
		{
			header('Location: ./login.php ');
			return false;
		}
		// if level not equal to needed one
		else if((int)$_SESSION['leveluser'] < (int)$level)
		{
				
				header('Location: ./search.php ');
				return false;
		}
		return true;
	}
function checkDateFormat($date)
{
  //match the format of the date
  if (preg_match ("@^([0-9]{4})-([0-9]{2})-([0-9]{2})$@", $date, $parts) || preg_match ("@^([0-9]{4})/([0-9]{2})/([0-9]{2})$@", $date, $parts))
  {
    //check weather the date is valid of not
        if(checkdate($parts[2],$parts[3],$parts[1]))
          return true;
        else
         return false;
  }
  else
    return false;
}
	

?>
<script type="text/javascript">
function blocText(val)
{
    quant = 1000;
    total = val.length;
    if(total <= quant)
    {
        have = quant - total;
        document.getElementById('count').innerHTML = have;
    }
    else
    {
        document.getElementById('note').value = val.substr(0,quant);
    }
}
</script>