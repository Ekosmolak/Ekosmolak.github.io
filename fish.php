<?php

// *******w******** 
    
//     Name: Eric Kosmolak
//     Date: May 23, 2024
//     Description: Web Dev 2 Final Project

// ****************/
require('connect.php');

$query = "SELECT * FROM fish";

// A PDO::Statement is prepared from the query
$statement = $db->prepare($query);

// Execution on the DB server is delayed until we execute()
$statement->execute();
$fishes =$statement->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Fish</title>
</head>
<body>
    <?php include('header.php'); ?>
    <?php include('nav.php'); ?>

    <div id="wrapper">
        <div class="container-py2">
            <h1>World Class Fishing!</h2>
        </div>

        <div class="fish">
            <?php foreach ($fishes as $fish): ?>
                <div id="fish-post">
                    <h3><?= $fish['Fish_Type'] ?></h3>
                    <h4>Master Angler Size: <?= $fish['Regulation_Size'] ?></h4>
                    <img src="<?=$fish['fish_pic']?>" alt="<?= $fish['Fish_Type'] ?>" height="200px" width="400px">
                    <p><?=$fish['Fish_Description']?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php include('footer.php'); ?>
</body>
</html>