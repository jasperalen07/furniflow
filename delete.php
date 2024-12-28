<?php
include 'db.php';

// Check if 'id' is passed in the URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // To make sure the ID is treated as an integer
    
    // Prepare the delete query

    $stmt = $conn->prepare("DELETE FROM furniture WHERE id = ?");
    $stmt->bind_param("i", $id); //Bind the ID as an integer

    // EXecute the query
    if ($stmt->execute()){
        header("Location: index.php");
        exit();
    } else {
        echo " Invalid request . No ID Provided";
    }

}
?>