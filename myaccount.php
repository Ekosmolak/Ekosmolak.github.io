<?php

// *******w******** 
    
//     Name: Eric Kosmolak
//     Date: May 23, 2024
//     Description: Web Dev 2 Final Project

// ****************/

session_start();

// Redirect to login page if not logged in
if (!isset($_SESSION['client_id'])) {
    header("Location: login.php");
    exit();
}

require('connect.php');

// Retrieve the client's ID from the session
$client_id = $_SESSION['client_id'];

// Prepare SQL query to fetch client information
$stmt = $db->prepare("SELECT First_Name, Last_Name, Username FROM client WHERE Client_Id = :client_id");
$stmt->bindParam(':client_id', $client_id);
$stmt->execute();

// Fetch client data
$client = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if client data was retrieved
if (!$client) {
    echo "Error retrieving client information.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>My Profile</title>
</head>
<body>
    <?php include('header.php') ?>
    <?php include('nav.php') ?>
    <div id="wrapper">
        <h1>My Profile</h1>
        <p><strong>First Name:</strong> <?php echo htmlspecialchars($client['First_Name']); ?></p>
        <p><strong>Last Name:</strong> <?php echo htmlspecialchars($client['Last_Name']); ?></p>
        <p><strong>Username:</strong> <?php echo htmlspecialchars($client['Username']); ?></p>
        <form method="POST" action="logout.php">
            <button type="submit">Log Out</button>
        </form>
    </div>
    <?php include('footer.php'); ?>
</body>
</html>