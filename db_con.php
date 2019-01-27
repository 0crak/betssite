<?php
$hostname = "localhost";
$username = "root";
$password = "root";
$database = "bets";

$con = mysqli_connect($hostname,$username,$password) or die ("connection failed");
mysqli_select_db($con,$database) or die ("error connect database");
?>
