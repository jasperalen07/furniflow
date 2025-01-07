<?php
// Include the database connection file
include 'db.php';

// Query to fetch data from furniture table 
$query = "SELECT * FROM `furniture`";
$result = $conn->query($query);

// Sorting Feature

if (isset($_GET['sort'])){
    $sort = $_GET['sort'];

    switch ($sort) {
        case 'price_asc':
            $query .= " ORDER BY price ASC";
            break;
        case 'price_desc':
            $query .= " ORDER BY price DESC";
            break;
        case 'name_asc':
            $query .= " ORDER BY name ASC";
            break;
        case 'name_desc':
            $query .= " ORDER BY name DESC";
            break;
    }

    $result = $conn->query($query);

if (!$result) {
    die("Query failed: " . $conn->error);
}
}


// Search Feature
// Check if search term exist

 if(isset($_GET['search']) && !empty($_GET['search'])) {

    $search = "%" . $_GET['search'] . "%";
    $query .= "WHERE name LIKE ? OR description LIKE ?";
}

// Prepare and execute the query
$stmt = $conn->prepare($query);

if (isset($search)) {
    $stmt->bind_param("ss", $search, $search);
}

if (!$result) {
    die("Query failed: " . $conn->error);
}

$stmt->execute();
$result = $stmt->get_result();
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
        <h1>FurniFlow Inventory List</h1>

        <form action="index.php" method="GET" class="search-form">
    <input type="text" name="search" placeholder="Search by name or description..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
    <button type="submit">Search</button>
</form>

<!-- Sorting Section -->
<form method="GET" action="index.php" class="sorting-form">
    <label for="sort">Sort By:</label>
    <select name="sort" id="sort" onchange="this.form.submit()">
        <option value="">Select Sorting</option>
        <option value="price_asc">Price: Low to High</option>
        <option value="price_desc">Price: High to Low</option>
        <option value="name_asc">Name: A-Z</option>
        <option value="name_desc">Name: Z-A</option>
    </select>
</form>


        <!-- Display Furniture Table -->
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
    echo "<tr><td colspan='6'>No matching results found</td></tr>";
}
?>

            </tbody>
        </table>
    </div>

    <!-- Add New Furniture Form -->
    <section class="add-furniture-section">
        <h2>Add New Product</h2>
        <form action="add.php" method="POST">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" required>

            <label for="price">Price:</label>
            <input type="text" name="price" id="price" required>

            <label for="image">Image (file name):</label>
            <input type="text" name="image" id="image" required>

            <label for="description">Description:</label>
            <textarea name="description" id="description" required></textarea>

            <button type="submit" class="btn">Add Furniture</button>
        </form>
    </section>

    <script src="script/app.js"></script>
</body>
</html>
