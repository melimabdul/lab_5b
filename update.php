<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lab_5b";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user details
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['matric'])) {
    $matric = $conn->real_escape_string($_GET['matric']);
    $sql = "SELECT * FROM users WHERE matric = '$matric'";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
    } else {
        echo "User not found.";
        exit();
    }
}

// Update user details
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $matric = $conn->real_escape_string($_POST['matric']);
    $name = $conn->real_escape_string($_POST['name']);
    $role = $conn->real_escape_string($_POST['role']); // Ensure role is sanitized

    $sql = "UPDATE users SET name = '$name', role = '$role' WHERE matric = '$matric'";

    if ($conn->query($sql) === TRUE) {
        header("Location: display.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
</head>
<body>
    <h2>Update User</h2>
    <form action="update.php" method="POST">
        <input type="hidden" name="matric" value="<?php echo $user['matric']; ?>">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $user['name']; ?>" required><br><br>

        <label for="role">Role:</label>
        <input type="text" id="role" name="role" value="<?php echo $user['role']; ?>" required><br><br>

        <button type="submit">Update</button>
    </form>
</body>
</html>
