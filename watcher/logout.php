<?php
session_start();

unset($_SESSION['logged']);
unset($_SESSION['username']) ;
unset($_SESSION['level'] );
header('location: ./login.php');
?>
