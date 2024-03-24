<?php
function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validate_password($password) {
    return preg_match('/^(?=.*[A-Z])(?=.*\d).{9,}$/', $password);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["email"]) && isset($_POST["password"])) {
        $email = $_POST["email"];
        $password = $_POST["password"];

        $errors = array();

        if (!validate_email($email)) {
            $errors["email"] = "Indtast en gyldig email-adresse.";
        }

        if (!validate_password($password)) {
            $errors["password"] = "Adgangskoden skal indeholde mindst én stor bogstav, mindst ét tal, og være mindst 9 tegn lang.";
        }

        if (empty($errors)) {
            header("Location: login.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrer</title>
</head>
<body>
<h2>Register</h2>
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <div>
        <label for="email">Email:</label><br>
        <input type="text" id="email" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>"><br>
        <span style="color: red;"><?php echo isset($errors["email"]) ? $errors["email"] : ''; ?></span>
    </div>
    <div>
        <label for="password">Adgangskode:</label><br>
        <input type="password" id="password" name="password"><br>
        <span style="color: red;"><?php echo isset($errors["password"]) ? $errors["password"] : ''; ?></span>
    </div>
    <br>
    <input type="submit" value="Registrer">
</form>
</body>
</html>
