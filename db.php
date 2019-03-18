<?php


$servername = "192.185.5.16";
$username = "arthur_romymua";
$password = "mua0309";
$dbname = "arthur_apm";


//Create New Database Connection
$conn = new mysqli($servername, $username, $password, $dbname);

//Check Connection
if($conn->connect_error) {
	die("Connection Failed: ". $conn->connect_error);
}