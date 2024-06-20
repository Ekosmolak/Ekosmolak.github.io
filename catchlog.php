<?php

// /*******w******** 
    
//     Name: Eric Kosmolak
//     Date: May 23, 2024
//     Description: Web Dev 2 Final Project

// ****************/

require('connect.php');

// SQL is written as a String.
$query = "SELECT * FROM catchlog JOIN 
client ON catchlog.Client_Id = client.Client_Id ORDER BY catchlog.Date_Caught DESC LIMIT 5";

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
    <title>Recent Catches</title>
</head>
<body>
    <?php include('header.php'); ?>
    <?php include('nav.php'); ?>

    <div id="wrapper">
            <main class="catchlogtitle">
                <h1>Here are some of our clients latest catches!</h2>
                <h2>Want to add your own catch? <a href="postcatch.php">Click Here</a></h2>
            </main>

        <div class="catchlog">
            <?php if($statement->rowCount() == 0): ?>
                <div class="text-center-py-1">
                    <h2>No Catches Yet!</h2>
                </div>
            <?php exit; endif; ?>

            <?php while($row = $statement->fetch()): ?>
                <h2 class="catchlog-post-title"><?=$row['Fish_Type']?></h2>
                <img src="<?=$row['fish_pic'] ?>" alt="Clients Fish" width="450px" height="225px">
                <h3>Length <?=$row['Catch_Size'] ?>", Caught By <?=$row['First_Name']?> <?=$row['Last_Name']?></h3>

                <small class="catchlog-post-date">
                    Caught on <time><?=date_format(date_create($row['Date_Caught']), 'F j, Y') ?></time> &ensp;
                    <a href="editcatch.php?Catch_Id=<?=$row['Catch_Id']?>" class="catch-post-edit">Edit</a>
                </small>
            <br><br>
            <?php endwhile; ?>
        </div>
    </div>
    <?php include('footer.php'); ?>
</body>
</html>