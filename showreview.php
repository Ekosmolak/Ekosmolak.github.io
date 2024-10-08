<?php

// *******w******** 
    
//     Name: Eric Kosmolak
//     Date: May 23, 2024
//     Description: Web Dev 2 Final Project

// ****************/

require('connect.php');

if(isset($_GET['Review_Id']))
{
    $id = filter_input(INPUT_GET, 'Review_Id', FILTER_SANITIZE_NUMBER_INT);

    $query = "SELECT * FROM review WHERE Review_Id = :Review_Id";
    $statement = $db->prepare($query);
    $statement->bindValue(':Review_Id', $id, PDO::PARAM_INT);

    $statement->execute();
    $review = $statement->fetch();
} else 
{
    $id = false;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Review</title>
</head>
<body>
    <?php include('header.php'); ?>

    <?php include('nav.php'); ?>

    <div id="wrapper">
    <main class="showreview">
    <?php if($id): ?>
        <main class="showreviewtitle">
            <h2 class="reviewshowtitle"><?=$review['Review_Title']?></h2>
        </main>
        <small class="review-post-date">
            Posted on
            <time><?=date_format(date_create($review['date_posted']), 'F j, Y') ?><time>&ensp; 
            <a href="editreview.php?Review_Id=<?=$review['Review_Id']?>" class="review-post-edit">Edit</a>
        </small>
        <p class="review-post-content">
            <?=$review['Review_Content']?>
        </p>
    <?php else: ?>
        <p>No review selected. <a href="?id=1">Try this link</a>.</p>
    <?php endif ?>
    </main>
    </div>
    <?php include('footer.php'); ?>
</body>
</html>