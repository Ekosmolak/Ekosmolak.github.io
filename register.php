<?php

// *******w******** 
    
//     Name: Eric Kosmolak
//     Date: May 23, 2024
//     Description: Web Dev 2 Final Project

// ****************/
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the registration form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require('connect.php'); // Include your database connection file

    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Check if passwords match
    if ($password !== $confirmPassword) {
        $error = "Passwords do not match.";
    }
    // Check if password is exactly 6 characters long
    elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters long.";
    }
    // Check if password contains only letters and numbers
    elseif (!ctype_alnum($password)) {
        $error = "Password must contain only letters and numbers.";
    }
    else {
        

        // Insert into the database
        $stmt = $db->prepare("INSERT INTO `client`(`First_Name`, `Last_Name`, `Username`, `Password`) VALUES (:first_name, :last_name, :username, :password)");
        $stmt->bindParam(':first_name', $firstName);
        $stmt->bindParam(':last_name', $lastName);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);

        if ($stmt->execute()) {
            // Redirect to login page after successful registration
            header("Location: login.php");
            exit();
        } else {
            $error = "Error registering user." . $stmt->errorInfo()[2];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Register</title>
</head>
<body>
    <?php include('header.php') ?>
    <?php include('nav.php') ?>
    <div id="wrapper">
        <h1>Create Your Account!</h1>
        <?php if (isset($error)): ?>
            <p><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

            <label for="first_name">First Name:</label>
            <input type="first_name" id="first_name" name="first_name" required><br><br>

            <label for="last_name">Last Name:</label>
            <input type="last_name" id="last_name" name="last_name" required><br><br>

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br>

            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password"  required><br><br>

            <button type="submit">Register</button>
        </form>
    </div>
    <?php include('footer.php'); ?>
</body>
</html>