<?php
session_start();

$errors = [];

// Define database connection parameters
define('DB_SERVER', 'mysql');
define('DB_USER', 'pw2user');
define('DB_PASSWORD', 'pw2pass');
define('DB_DATABASE', 'PW2_project_db');

// Create a new mysqli connection
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if email and password are submitted
    if (isset($_POST["email"]) && isset($_POST["password"])) {
        $email = $_POST["email"];
        $password = $_POST["password"];

        // Prepare SQL statement with parameterized query
        $sql = "SELECT * FROM Users WHERE email = ? AND password = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $password); // Assuming password is stored as plain text
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // User exists, log user in
            $_SESSION['user'] = $email; // Store user in session (you can store other user info as needed)
            // Redirect to search page after successful login
            header("Location: search.php");
            exit();
            // Output log message to console
            echo "<script>console.log('User with email $email is logged in.');</script>";
        } else {
            // Incorrect email or password
            $errors["form"] = "Incorrect email or password.";
        }

        $stmt->close();
    }
}


// Close connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/login.css">
    <title>Login</title>
</head>
<body>
<div class="login-box">
    <h2>Login</h2>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="user-box">
            <input type="text" name="email" id="email" required autocomplete="email">
            <label for="email">Email</label>
        </div>
        <div class="user-box">
            <input type="password" name="password" id="password" required autocomplete="current-password">
            <label for="password">Password</label>
        </div>
        <span style="color: red;"><?php echo isset($errors["form"]) ? $errors["form"] : ''; ?></span>
        <br>
        <div class="button-container">
            <input type="submit" value="Login" class="login-button">
            <a href="register.php" class="login-button">Register</a>
        </div>
    </form>
</div>

</body>
</html>