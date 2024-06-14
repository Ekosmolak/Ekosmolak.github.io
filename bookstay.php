<?php

// /*******w******** 
    
//     Name: Eric Kosmolak
//     Date: May 23, 2024
//     Description: Web Dev 2 Final Project

// ****************/
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Book A Stay</title>
</head>
<body>
    <?php include('header.php'); ?>
    <?php include('nav.php'); ?>

    <div id="wrapper">
        <h1>Wanting to visit Lake of the Woods best fishing lodge?</h1>
        <p>Leave your contact information below and one of our booking agents will contact you never.</p>

        <form action="thanksforbooking.php" method="POST">
        <label for="name">Name</label>
        <br>
        <input type="text" name="name" id="name" maxlength="40" required>
        <br>
        <label for="phonenumber">Phone Number</label>
        <br>
        <input type="tel" name="phonenumber" id="phonenumber" required>
        <br>
        <label for="date">Dates</label>
        <br>
        <input type="date" name="date" id="date">
        <br>
        <button type="submit">Submit</button>
        </form>
    </div>
    <?php include('footer.php'); ?>
</body>
</html>