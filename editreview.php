<?php

/*******w******** 
    
    Name: Eric Kosmolak
    Date: May 23, 2024
    Description: Web Dev 2 Assignment 3 Blog

****************/
// require('authenticate.php');
// require('connect.php');

// $blog = [];

// if(isset($_GET['id']))
// {
//     $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

//     $query = "SELECT * FROM blog WHERE id = :id";
//     $statement = $db->prepare($query);
//     $statement->bindValue(':id', $id, PDO::PARAM_INT);

//     $statement->execute();
//     $blog = $statement->fetch(PDO::PARAM_INT);
// } else {
//     $id = false;
// }

// if($_POST)
// {
//     $is_post = true;

//     if(isset($_POST['command']) && $_POST['command'] == "UpdateBlog")
//     {
//         echo "update";

//         $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
//         $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
//         $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

//         $query = "UPDATE blog SET title = :title, content = :content WHERE id = :id";
//         $statement = $db->prepare($query);
//         $statement->bindValue(':title', $title);
//         $statement->bindValue(':content', $content);
//         $statement->bindValue(':id', $id, PDO::PARAM_INT);

//         $statement->execute();

//         $location = "index.php";

//         echo nl2br("\n" . $query . "\n");
//         echo nl2br($title . "\n");
//         echo nl2br($content . "\n");

//         header("Location: {$location}");
//         exit;
//     }
//     elseif(isset($_POST['command']) && $_POST['command'] == "Delete")
//     {
//         $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

//         $query = "DELETE FROM blog WHERE id = :id";
//         $statement = $db->prepare($query);
//         $statement->bindValue(':id', $id, PDO::PARAM_INT);
//         $location = "index.php";

//         $statement->execute();

//         header("Location: {$location}");
//         exit;

//     }
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Edit Post</title>
</head>
<body id="edit-blog">
    <?php include('header.php'); ?>

    <?php include('nav.php'); ?>
    <div id="wrapper">
    <main class="container py-1">

    <form action="edit.php" method="POST">
        <h2>Edit this post!</h2>

        <input type="hidden" name="id" value="<?=$blog['id']?>">

        <div class="form-group">
            <label for="title">Title</label>
            <br>
            <input type="text" name="title" id="title" value="<?=$blog['title']?>" minlength="1" required>
        </div>

        <div class="form-group">
            <label for="content">Content</label>
            <br>
            <textarea name="content" id="content" cols="30" rows="10" minlength="1" required> <?=$blog['content']?> </textarea>
        </div>

        <input type="hidden" name="command" value="UpdateBlog">
        <input type="submit" id="edit-input" name="button-primary" value="Update Blog"> 

        </form>

        <form action="edit.php" method="POST">
            <input type="hidden" id="edit-input" name="id" value="<?=$blog['id']?>">
            <input type="hidden" name="command" value="Delete">
            <input type="submit" name="button-primary-outline" value="Delete" onclick="return confirm('Are you sure you want to delete this post?')">
        </form>
    </main>
    </div>
    <?php include('footer.php'); ?>
</body>
</html>