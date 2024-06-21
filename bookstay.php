<?php

// *******w******** 
    
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
        <div class="bookstay">
            <main class="staytitle">
                <h1>Wanting To Visit Lake of the Woods Best Fishing lodge?</h1>
                <p>Leave your contact information below and one of our booking agents will contact you never.</p>
            </main>

            <form action="thanksforbooking.php" method="POST" id="bookstay">
                <ul>
                    <li>
                        <label for="name">Name</label>
                        <br>
                        <input type="text" name="name" id="name" maxlength="40" required>
                    </li>
                    <li>
                        <label for="phonenumber">Phone Number</label>
                        <br>
                        <input type="tel" name="phonenumber" id="phonenumber" placeholder="123-456-7890" pattern="[0-9]{3}[0-9]{3}[0-9]{4}" required>
                    </li>
                    <li>
                        <label for="date">Dates</label>
                        <br>
                        <input type="date" name="date" id="date" min="<?=date("Y-m-d")?>" max="2024-12-31" required>
                    </li>
                    <li>
                        <br>
                        <button class="book" type="submit">Submit</button>
                    </li>
                </ul>
            </form>
    </div>
    <?php include('footer.php'); ?>
</body>
</html>