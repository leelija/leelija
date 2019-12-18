<?php 
session_start();
header("Cache-control: private");

session_destroy(); 
header("Location:login.php");
?>