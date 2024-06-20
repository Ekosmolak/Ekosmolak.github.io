<?php

// /*******w******** 
    
//     Name: Eric Kosmolak
//     Date: May 23, 2024
//     Description: Web Dev 2 Final Project

// ****************/

require('connect.php');

// SQL is written as a String.
$query = "SELECT * FROM masterangler JOIN client ON masterangler.Client_Id = client.Client_Id ORDER BY masterangler.Catch_Size DESC LIMIT 5";

// A PDO::Statement is prepared from the query
$statement = $db->prepare($query);

// Execution on the DB server is delayed until we execute()
$statement->execute();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Master Anglers</title>
</head>
<body>
    <?php include('header.php'); ?>
    <?php include('nav.php'); ?>

    <div id="wrapper">
        <main class="mastertitle">
        <h1>The Master Angler Club!</h1>
        </main>

        <div class="catchlog">
            <?php if($statement->rowCount() == 0): ?>
                <div class="text-center py-1">
                    <h2>No Catches Yet!</h2>
                </div>
            <?php exit; endif; ?>

            <?php while($row = $statement->fetch()): ?>
                <h2 class="catchlog-post-title"><?=$row['Fish_Type']?></h3>
                <img src="<?=$row['fish_pic'] ?>" alt="Clients Fish" width="450px" height="225px">
                <h3>Length <?=$row['Catch_Size'] ?>", Caught By <?=$row['First_Name']?> <?=$row['Last_Name']?></h2>

                <small class="catchlog-post-date">
                    Caught on <time><?=date_format(date_create($row['Date_Caught']), 'F j, Y') ?></time> &ensp;
                </small>
            <br><br>
            <?php endwhile; ?>
        </div>
    </div>
    <?php include('footer.php'); ?>
</body>
</html>