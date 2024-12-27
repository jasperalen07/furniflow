<?php
// Include the database connection file
include 'db.php';

// Initialize variables
$id = $name = $price = $image = $description = "";

// Check if 'id' is passed in the URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Ensure the ID is an integer

    // Fetch the current furniture data
    $stmt = $conn->prepare("SELECT * FROM furniture WHERE id = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $name = htmlspecialchars($row['name']);
        $price = number_format($row['price'], 2); // Ensure it displays in proper float format
        $image = htmlspecialchars($row['image']);
        $description = htmlspecialchars($row['description']);
    } else {
        die("Furniture item not found.");
    }
} else {
    die("ID parameter is missing.");
}

// Handle form submission for updates
if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $price = floatval($_POST['price']); // Ensure it's converted to float
    $image = $_POST['image'];
    $description = $_POST['description'];

    // Validate Price
    if (!is_numeric($price) || $price <= 0) {
        die("Error: Price must be a positive number.");
    }

    // Update query
    $stmt = $conn->prepare("UPDATE furniture SET name = ?, price = ?, image = ?, description = ? WHERE id = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("sdssi", $name, $price, $image, $description, $id);

    if ($stmt->execute()) {
        header("Location: index.php"); // Redirect to main page after update
        exit();
    } else {
        echo "Error updating record: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Furniture</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Edit Furniture</h1>
        <form action="" method="POST">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" value="<?php echo $name; ?>" required>

            <label for="price">Price:</label>
            <input type="text" name="price" id="price" value="<?php echo $price; ?>" required>

            <label for="image">Image (file name):</label>
            <input type="text" name="image" id="image" value="<?php echo $image; ?>" required>

            <label for="description">Description:</label>
            <textarea name="description" id="description" required><?php echo $description; ?></textarea>

            <button type="submit" name="update">Update Furniture</button>
        </form>
        <a href="index.php" class="btn">Back to List</a>
    </div>
</body>
</html>
