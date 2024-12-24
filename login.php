<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form action="login.php" method="POST">
        <label for="matric">Matric:</label>
        <input type="text" id="matric" name="matric" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="register.php">Register here</a></p>

    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Database connection
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "lab_5b";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Retrieve and sanitize inputs
        $matric = $conn->real_escape_string($_POST['matric']);
        $password = $_POST['password'];

        // Fetch user data
        $sql = "SELECT password FROM users WHERE matric = '$matric'";
        $result = $conn->query($sql);

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                // Redirect to display page
                header("Location: display.php");
                exit();
            } else {
                echo "<p style='color: red;'>Invalid matric or password. Try login again.</p>";
            }
        } else {
            echo "<p style='color: red;'>Invalid matric or password. Try login again.</p>";
        }

        $conn->close();
    }
    ?>
</body>
</html>
