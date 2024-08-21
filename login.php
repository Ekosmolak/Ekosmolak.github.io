<?php

// *******w******** 
    
//     Name: Eric Kosmolak
//     Date: May 23, 2024
//     Description: Web Dev 2 Final Project

// ****************/
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require('connect.php'); // Include your database connection file

    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!empty($username) && !empty($password)) {
        // Prepare the SQL statement to fetch the user
        $stmt = $db->prepare("SELECT Client_Id, Username, Password FROM client WHERE Username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if the user exists and the plain text password matches
        if ($user && $user['Password'] === $password) {
            // Password is correct, set session variables
            $_SESSION['client_id'] = $user['Client_Id']; 
            $_SESSION['username'] = $user['Username'];

            // Redirect to the homepage or any other page
            header("Location: index.php");
            exit();
        } else {
            // If username or password is incorrect
            $error = "Invalid username or password.";
        }
    } else {
        // Username or password is empty
        $error = "Please enter both username and password.";
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
    <title>Login</title>
</head>
<body>
    <?php include('header.php') ?>
    <?php include('nav.php') ?>
    <div id="wrapper">
        <h1>Login</h1>
        <?php if (isset($error)): ?>
            <p><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br>
            <button type="submit">Login</button>
        </form>
        
        <p>Don't have an account? <a href="register.php">Register</a></p>
    </div>
    <?php include('footer.php'); ?>
</body>
</html>