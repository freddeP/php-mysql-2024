<?php


$servername = "localhost";
$username = "pefr";
$password = "1234";
$db = "php1";

// Create connection
$con = new mysqli($servername, $username, $password, $db);

// Check connection
if ($con->connect_error) {
  die("Connection failed: " . $con->connect_error);
}
echo "Connected successfully";

