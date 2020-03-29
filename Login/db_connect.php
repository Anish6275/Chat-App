<?php
$servername="HOST";
$username="USER_NAME";
$password="PASSWORD";
$database="DATABASE_NAME";

$conn = mysqli_connect($servername, $username, $password, $database);

if(!$conn){
	die("Failed to connect". mysqli_connect_error());
}
?>