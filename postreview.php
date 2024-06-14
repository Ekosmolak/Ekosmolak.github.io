<?php
/*******w******** 
    
    Name: Eric Kosmolak
    Date: May 23, 2024
    Description: Web Dev 2 Assignment 3 Blog

****************/
require('authenticate.php');
require('connect.php');

if($_POST && !empty($_POST['Review_Title']) && !empty($_POST['Review_Content']))
{
    // Sanitize user input
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Build the parameterized SQL query and bind to the above sanitized values
    $query = "INSERT INTO review (Review_Title, Review_Content) VALUES (:Review_Title, :Review_Content)";
    $statement = $db->prepare($query);

    // Bind values to parameters
    $statement->bindValue(':Review_Title', $title);
    $statement->bindValue(':Review_Content', $content);

    // Execute the INSERT
    if($statement->execute())
    {
        echo "Success";
    }

    // Change to the show.php?{$id}
    header("Location: index.php?{$id}");
    exit;
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
    <main class="container py-1" id="create-post">
        <form action="postreview.php" method="POST">
            <h2>New Review</h2>

            <div class="form-group">
                <label for="title">Title</label>
                <br>
                <input type="text" name="title" id="title" minlength="1" maxlength="40" required>
            </div>

            <div class="form-group">
                <label for="content">Review Content</label>
                <br>
                <textarea name="content" id="content" cols="30" rows="10" minlength="1" maxlength="400" required></textarea>
            </div>

            <button type="submit" class="button-primary">Submit Review</button>
        </form>
    </main>
    </div>
    <?php include('footer.php'); ?>
</body>
</html>