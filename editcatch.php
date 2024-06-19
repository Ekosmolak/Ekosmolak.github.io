<?php

/*******w******** 
    
    Name: Eric Kosmolak
    Date: May 23, 2024
    Description: Web Dev 2 Final Project

****************/
require('authenticate.php');
require('connect.php');

$id = [];
$review = [];

if(isset($_GET['Catch_Id']))
{
    $id = filter_input(INPUT_GET, 'Catch_Id', FILTER_SANITIZE_NUMBER_INT);

    $query = "SELECT * FROM catchlog WHERE Catch_Id = :Catch_Id";
    $statement = $db->prepare($query);
    $statement->bindValue(':Catch_Id', $id, PDO::PARAM_INT);

    $statement->execute();
    $review = $statement->fetch();
} else {
    $id = false;
}

if($_POST)
{
    $is_post = true;

    if(isset($_POST['command']) && $_POST['command'] == "UpdateCatch")
    {
        echo "update";

        $title = filter_input(INPUT_POST, 'Review_Title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $content = filter_input(INPUT_POST, 'Review_Content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $id = filter_input(INPUT_POST, 'Catch_Id', FILTER_SANITIZE_NUMBER_INT);

        $query = "UPDATE catchlog SET Review_Title = :Review_Title, Review_Content = :Review_Content WHERE Catch_Id = :Catch_Id";
        $statement = $db->prepare($query);
        $statement->bindValue(':Review_Title', $title);
        $statement->bindValue(':Review_Content', $content);
        $statement->bindValue(':Catch_Id', $id, PDO::PARAM_INT);

        $statement->execute();

        $location = "catchlog.php";

        echo nl2br("\n" . $query . "\n");
        echo nl2br($title . "\n");
        echo nl2br($content . "\n");

        header("Location: {$location}");
        exit;
    }
    elseif(isset($_POST['command']) && $_POST['command'] == "Delete")
    {
        $id = filter_input(INPUT_POST, 'Catch_Id', FILTER_SANITIZE_NUMBER_INT);

        $query = "DELETE FROM catchlog WHERE Catch_Id = :Catch_Id";
        $statement = $db->prepare($query);
        $statement->bindValue(':Catch_Id', $id, PDO::PARAM_INT);
        $location = "catchlog.php";

        $statement->execute();

        header("Location: {$location}");
        exit;

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
    <title>Edit Review</title>
</head>
<body id="edit-review">
    <?php include('header.php') ?>

    <?php include('nav.php') ?>
    <div id="wrapper">
    <main class="container py-1">

    <form action="editreview.php" method="POST">
        <h2>Edit this review!</h2>

        <input type="hidden" name="Review_Id" value="<?=$review['Catch_Id']?>">

        <div class="form-group">
            <label for="title">Review Title</label>
            <br>
            <input type="text" name="Catch_Id" id="title" value="<?=$review['Catch_Id']?>" minlength="1" required>
        </div>

        <div class="form-group">
            <label for="content">Review Content</label>
            <br>
            <textarea name="Review_Content" id="content" cols="30" rows="10" minlength="1" required> <?=$review['Review_Content']?></textarea>
        </div>

        <input type="hidden" name="command" value="UpdateCatch">
        <input type="submit" id="edit-input" name="button-primary" value="Update Catch"> 

        </form>

        <form action="editreview.php" method="POST">
            <input type="hidden" id="edit-input" name="Catch_Id" value="<?=$review['Catch_Id']?>">
            <input type="hidden" name="command" value="Delete">
            <input type="submit" name="button-primary-outline" value="Delete" onclick="return confirm('Are you sure you want to delete this post?')">
        </form>
    </main>
    </div>
    <?php include('footer.php'); ?>
</body>
</html>