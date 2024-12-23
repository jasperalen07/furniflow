<?php
include 'db.php';

// Fetch existing data

if(isset($_GET['id'])){
    $id = intval($_GET['id']);
    $query = "SELECT * FROM `1` WHERE id =?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
}

// Update data

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $id = intval($_POST['id']);
    $name = $_POST['name'];
    $email = $_POST['email'];

    $updateQuery = "UPDATE `1` SET name = ?, email = ? WHERE id = ?";

    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("ssi", $name, $email, $id);

    if($stmt->execute()){
        header("Location: index.php");
        exit();
    } else {
        echo "Error updating " . $conn->error;
        }


}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Edit User</h1>
        <form action="edit.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
            <label for="name">Name:</label>
            <input type="text" name="name" value="<?php echo $user['name']; ?>" required>
            <label for="email">Email:</label>
            <input type="email" name="email" value="<?php echo $user['email']; ?>" required>
            <button type="submit">Update</button>
        </form>
    </div>
</body>
</html>