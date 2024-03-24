<?php
session_start();

// Placeholder for user existence check (replace with actual database check)
$user_exists = true; // Assuming user exists for now

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if email and password are submitted
    if (isset($_POST["email"]) && isset($_POST["password"])) {
        $email = $_POST["email"];
        $password = $_POST["password"];

        $errors = array();

        // Validate email and password (assuming functions validate_email and validate_password are defined)

        // If there are no validation errors and user exists
        if (empty($errors) && $user_exists) {
            // Log user in and redirect to search page
            $_SESSION['user'] = $email; // Store user in session (you can store other user info as needed)
            // Output log message to console
            echo "<script>console.log('User with email $email is logged in and being redirected to search.php');</script>";
            // Redirect to search page after successful login
            header("Location: search.php");
            exit();
        } else {
            // User does not exist or validation errors, show error
            $errors["form"] = "Incorrect email or password.";
        }
    }
}
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
        <input type="submit" value="Login" class="login-button">
    </form>
</div>
</body>
</html>
