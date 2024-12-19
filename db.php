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

<?php
// Function for adding furniture
function addFurniture($conn, $name, $description, $price, $image) {
    $stmt = $conn->prepare("INSERT INTO furniture (name, description, price, image) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssds", $name, $description, $price, $image);
    return $stmt->execute();
}
?>
