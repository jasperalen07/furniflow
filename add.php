<?php
include 'db.php';

// Check if form data is submitted

 if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name']; // Get the name from the form
    $email = $_POST['email']; // Get the email from the form


    // Prepare and execute the query to insert data

    $stmt = $conn->prepare("INSERT INTO `1` (name, email) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $email); // Bind the parameters
    $result = $stmt->execute();

    if ($result) {
        echo "User added successfully!";
        header("Location: index.php"); // Redirect to the main page
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>