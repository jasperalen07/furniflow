<?php 
// Database connection variables

$host = 'localhost'; 
$username = 'root'; // Default MAMP username
$password = 'root'; //Default MAMP password
$database = 'furniflow'; // Your database name

$conn = new mysqli($host, $username, $password, $database);

// Check connection

if($conn->connect_error){
    die("Connection faiiled" . $conn->connect_error);
}

?>