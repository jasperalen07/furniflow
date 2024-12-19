<?php
// Include the database connection file
include 'db.php';

// Query to fetch data
$query = "SELECT * FROM `1`"; // Replace `1` with your actual table name if it's different
$result = $conn->query($query);

if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Data</title>
    <link rel="stylesheet" href="css/styles.css"> <!-- Link to your custom CSS file -->
</head>
<body>
    <div class="container">
        <h1>User List</h1>

        <!-- Add new user feature -->
        <h2 class="new-user">New User</h2>
        <form action="add.php" method="POST"> <!-- Correct the form placement -->
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" required>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
            <button type="submit">Add User</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Loop through the results and display in table rows
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>
                                <a href='edit.php?id=" . $row['id'] . "'>Edit</a> | 
                                <a href='delete.php?id=" . $row['id'] . "' onclick='return confirm(\"Are you sure you want to delete this record?\");'>Delete</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No data found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <script src="script/app.js"></script>
</body>
</html>
