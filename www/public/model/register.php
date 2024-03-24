<?php
session_start();

$errors = array();

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

// Function to validate email address
function validate_email($email) {
    $email = trim($email);
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Function to validate password
function validate_password($password, $confirm_password){
    $password = trim($password);
    $confirm_password = trim($confirm_password);

    // Check if password contains at least one number, one capital letter, and is longer than or equal to 9 characters
    return preg_match('/^(?=.*\d)(?=.*[A-Z]).{9,}$/', $password) && $password === $confirm_password;
}

// Function to check if email already exists
function email_exists($email, $conn) {
    $sql = "SELECT COUNT(*) AS count FROM Users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['count'] > 0;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are set
    if (isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["confirm_password"])) {
        $email = $_POST["email"];
        $password = $_POST["password"];
        $confirm_password = $_POST["confirm_password"];

        // Validate email
        if (!validate_email($email)) {
            $errors["email"] = "Enter a valid email address.";
        }

        // Check if email already exists
        if (email_exists($email, $conn)) {
            $errors["email_exists"] = "Email already exists.";
        }

        // Validate password
        if (!validate_password($password, $confirm_password)) {
            $errors["password"] = "Password must contain at least one number, one capital letter, and be longer than or equal to 9 characters.";
        }

        // If no errors, proceed with user creation
        if (empty($errors)) {
            // Hash the password for security
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Prepare the SQL statement
            $sql = "INSERT INTO Users (email, password, created_at, updated_at) VALUES (?, ?, NOW(), NOW())";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $email, $hashed_password);

            // Execute the SQL statement
            if ($stmt->execute()) {
                // Set user in session
                $_SESSION['user'] = $email;
                // Redirect to search page after successful login
                header("Location: search.php");
                exit();
            } else {
                // Handle errors if the query fails
                $errors["database"] = "Error creating user: " . $conn->error;
            }

            $stmt->close();
        }
    } else {
        // Set error message for required fields if not filled out
        if (empty($_POST["email"])) {
            $errors["email"] = "Email is required.";
        }
        if (empty($_POST["password"])) {
            $errors["password"] = "Password is required.";
        }
        if (empty($_POST["confirm_password"])) {
            $errors["confirm_password"] = "Confirm password is required.";
        }
    }
}

// Close database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/register.css">
    <title>Register</title>
</head>
<body>
<div class="register-box">
    <h2>Register</h2>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <!-- Error message for email -->
        <span class="error"><?php echo isset($errors["email"]) ? $errors["email"] : ''; ?></span>
        <span class="error"><?php echo isset($errors["email_exists"]) ? $errors["email_exists"] : ''; ?></span>

        <div class="user-box">
            <!-- Move the email input here -->
            <input type="text" id="email" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
            <label for="email">Email</label>
        </div>

        <!-- Error message for password -->
        <span class="error"><?php echo isset($errors["password"]) ? $errors["password"] : ''; ?></span>

        <div class="user-box">
            <!-- Move the password input here -->
            <input type="password" id="password" name="password">
            <label for="password">Password</label>
        </div>

        <!-- Error message for confirm password -->
        <span class="error"><?php echo isset($errors["confirm_password"]) ? $errors["confirm_password"] : ''; ?></span>

        <div class="user-box">
            <!-- Move the confirm password input here -->
            <input type="password" id="confirm_password" name="confirm_password">
            <label for="confirm_password">Confirm Password</label>
        </div>

        <input type="submit" value="Register">
        <a href="http://localhost:8080/index.php" class="login-button register-button">Back</a>
        <!-- Error message for database -->
        <span class="error"><?php echo isset($errors["database"]) ? $errors["database"] : ''; ?></span>
    </form>
</div>
</body>
</html>
