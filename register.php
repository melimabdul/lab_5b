<?php
// Database connection setup
$servername = "localhost";
$username = "root"; // Replace with your DB username
$password = "";     // Replace with your DB password
$dbname = "lab_5b"; // Replace with your database name

// Connect to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Handle form submission
$message = ""; // For success or error messages
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $matric = trim($_POST['matric']);
    $name = trim($_POST['name']);
    $password = password_hash(trim($_POST['password']), PASSWORD_BCRYPT); // Secure password hashing
    $role = trim($_POST['role']);

    // Insert data into the users table
    $sql = "INSERT INTO users (matric, name, password, role) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $matric, $name, $password, $role);

    if ($stmt->execute()) {
        $message = "<p style='color:green;'>Registration successful!</p>";
    } else {
        $message = "<p style='color:red;'>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0 auto;
            padding: 20px;
            max-width: 600px;
            line-height: 1.6;
        }
        form {
            background: #f9f9f9;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        label {
            display: block;
            margin-bottom: 8px;
        }
        input, select, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background: coral;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background: darkorange;
        }
    </style>
</head>
<body>
    <h2>Registration Form</h2>
    <?php echo $message; ?>
    <form action="" method="POST">
        <label for="matric">Matric:</label>
        <input type="text" id="matric" name="matric" required>

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <label for="role">Role:</label>
        <select id="role" name="role" required>
            <option value="">Please select</option>
            <option value="Student">Student</option>
            <option value="Lecture">Lecture</option>
        </select>

        <button type="submit">Submit</button>
    </form>
</body>
</html>
