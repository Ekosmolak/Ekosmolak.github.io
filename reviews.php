<?php

// /*******w******** 
    
//     Name: Eric Kosmolak
//     Date: May 23, 2024
//     Description: Web Dev 2 Final Project

// ****************/

require('connect.php');

// SQL is written as a String.
$query = "SELECT * FROM review JOIN client ON review.Client_Id = client.Client_Id ORDER BY date_posted DESC LIMIT 10";

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
    <title>Reviews</title>
</head>
<body>
    <?php include('header.php'); ?>
    <?php include('nav.php'); ?>

    <div id="wrapper">
        <main class="review-title">
        <h1>Here are our latest reviews!</h1>
        <h2>Want to add your own? <a href="postreview.php">Click Here</a></h2>
        </main>
        <div class="index">
            <?php if($statement->rowCount() == 0): ?>
                <div class="text-center py-1">
                    <p>No Reviews Yet!</p>
                </div>
            <?php exit; endif; ?>

            <?php while($row = $statement->fetch()): ?>
                <h3 class="review-post-title">
                    <?=$row['Review_Title']?></a>
                </h3>

                <h4 class="review-post-client">
                    Review by <?=$row['First_Name']?> <?=$row['Last_Name']?>
                </h4>

                <small class="review-post-date">
                    Posted on <time datetime="<?=$row['date_posted']?>"><?=
                    date_format(date_create($row['date_posted']), 'F j, Y G:i') ?> <time> &ensp;
                    <a href="editreview.php?Review_Id=<?=$row['Review_Id']?>" class="review-post-edit">Edit</a>
                </small>
            <br>
                <p class="review-post-content">
                    <?php if(strlen($row['Review_Content']) > 200) : ?>
                        <?=substr($row['Review_Content'], 0, 200)?>
                        ...<a href="showreview.php?Review_Id=<?=$row['Review_Id']?>">Read full post</a>
                    <?php else: ?>
                        <?=$row['Review_Content'] ?>
                    <?php endif ?>
                </p>
                <br>
            <?php endwhile; ?>
        </div>
    </div>
    <?php include('footer.php'); ?>
</body>
</html>