<?php

// *******w******** 
    
//     Name: Eric Kosmolak
//     Date: May 23, 2024
//     Description: Web Dev 2 Final Project

// ****************/
require('authenticate.php');
require('connect.php');

$review = null;
$id = null;

if(isset($_GET['Review_Id']))
{
    $id = filter_input(INPUT_GET, 'Review_Id', FILTER_SANITIZE_NUMBER_INT);

    $query = "SELECT * FROM review WHERE Review_Id = :Review_Id";
    $statement = $db->prepare($query);
    $statement->bindValue(':Review_Id', $id, PDO::PARAM_INT);

    $statement->execute();
    $review = $statement->fetch();
} else {
    $id = false;
}

if($_POST)
{
    $is_post = true;

    if(isset($_POST['command']) && $_POST['command'] == "UpdateReview")
    {
        echo "update";

        $title = filter_input(INPUT_POST, 'Review_Title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $content = filter_input(INPUT_POST, 'Review_Content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $id = filter_input(INPUT_POST, 'Review_Id', FILTER_SANITIZE_NUMBER_INT);

        $query = "UPDATE review SET Review_Title = :Review_Title, Review_Content = :Review_Content WHERE Review_Id = :Review_Id";
        $statement = $db->prepare($query);
        $statement->bindValue(':Review_Title', $title);
        $statement->bindValue(':Review_Content', $content);
        $statement->bindValue(':Review_Id', $id, PDO::PARAM_INT);

        $statement->execute();

        $location = "reviews.php";

        echo nl2br("\n" . $query . "\n");
        echo nl2br($title . "\n");
        echo nl2br($content . "\n");

        header("Location: {$location}");
        exit;
    }
    elseif(isset($_POST['command']) && $_POST['command'] == "Delete")
    {
        $id = filter_input(INPUT_POST, 'Review_Id', FILTER_SANITIZE_NUMBER_INT);

        $query = "DELETE FROM review WHERE Review_Id = :Review_Id";
        $statement = $db->prepare($query);
        $statement->bindValue(':Review_Id', $id, PDO::PARAM_INT);
        $location = "reviews.php";

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
    <main class="editreview">
        <div id="postreview">
            <main class="postreview">
                <h1>Edit this review!</h1>
            </main>

        <?php if($review): ?>
        <form action="showreview.php?Review_Id=<?=$review['Review_Id']?>" method="POST">
                <input type="hidden" name="Review_Id" value="<?=$review['Review_Id']?>">
                <ul>
                    <li>
                        <div class="form-group">
                            <label for="title">Review Title</label>
                            <input type="text" name="Review_Title" id="title" value="<?=$review['Review_Title']?>" minlength="1" required>
                        </div>
                    </li>
                    <li>
                        <div class="form-group">
                            <label for="content">Review Content</label>
                            <textarea name="Review_Content" id="content" cols="30" rows="10" minlength="1" required> <?=$review['Review_Content']?></textarea>
                        </div>
                    </li>
                    <li class="reviewbutton">
                        <input type="hidden" name="command" value="UpdateReview">
                        <input type="submit" class="reviewbutton" name="button-primary" value="Update Review"> 
                    </li>
                </form>
                    <li class="reviewbutton">
                        <form action="editreview.php?Review_Id=<?=$review['Review_Id']?>" method="POST">
                            <input type="hidden" id="edit-input" name="Review_Id" value="<?=$review['Review_Id']?>">
                            <input type="hidden" name="command" value="Delete">
                            <input type="submit" class="reviewbutton" name="button-primary-outline" value="Delete" onclick="return confirm('Are you sure you want to delete this post?')">
                        </form>
                    </li>
                </ul>
            <?php else: ?>
                <p>No reviews found.</p>
            <?php endif ?>
        </div>
    </main>
    </div>
    <?php include('footer.php'); ?>
</body>
</html>