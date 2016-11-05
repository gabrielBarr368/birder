<?php
session_start();

unset($_SESSION['logged']);
header('location: ./login.php');
?>
