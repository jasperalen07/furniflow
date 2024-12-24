<?php
include 'db.php';

// Check if 'id' is passed in the URL

if(isset($_GET['id'])){
    $id = intval($_GET['id']);

    // Prepare and execute the delete query

    $query = "DELETE FROM `1` WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Redirect back to the index page after successful deletion
        header("Location: index.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "Invalid request.";
}

       


?>