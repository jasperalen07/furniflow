<?php
// Make an include file to connec to the database
include 'db.php';

// Query to fetch data from furniture table 
$query = "SELECT * FROM `furniture`";
$result = $conn->query($query);

if(!$result){
 die("Query failed: " . $conn->error);
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Furniture Store</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Furniture List</h1>
        <a href="add.php" class="btn">Add New Furniture</a>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>$" . number_format($row['price'], 2) . "</td>";
                    echo "<td><img src='images/" . $row['image'] . "' alt='" . $row['name'] . "' width='150'></td>";
                    echo "<td>" . $row['description'] . "</td>";
                    echo "<td>
                            <a href='edit.php?id=" . $row['id'] . "' class='btn'>Edit</a> | 
                            <a href='delete.php?id=" . $row['id'] . "' class='btn' onclick='return confirm(\"Are you sure you want to delete this record?\");'>Delete</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No furniture items found</td></tr>";
            }
                ?>


            </tbody>