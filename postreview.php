<?php
// *******w******** 
    
//     Name: Eric Kosmolak
//     Date: May 23, 2024
//     Description: Web Dev 2 Final Project

// ****************/
require('authenticate.php');
require('connect.php');
$review = null;

if($_POST && !empty($_POST['Review_Title']) && !empty($_POST['Review_Content']))
{
    // Sanitize user input
    $title = filter_input(INPUT_POST, 'Review_Title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $content = filter_input(INPUT_POST, 'Review_Content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $client_id = filter_input(INPUT_POST, 'Client_Id', FILTER_SANITIZE_NUMBER_INT);

    // Build the parameterized SQL query and bind to the above sanitized values
    $query = "INSERT INTO review (Review_Title, Review_Content, Client_Id) VALUES (:Review_Title, :Review_Content, :Client_Id)";
    $statement = $db->prepare($query);

    // Bind values to parameters
    $statement->bindValue(':Review_Title', $title);
    $statement->bindValue(':Review_Content', $content);
    $statement->bindValue(':Client_Id', $client_id);

    // Execute the INSERT
    $statement->execute();
    $review = $statement->fetch();
    $location = "reviews.php";

    // Change to the show.php?{$id}
    header("Location: $location");
    exit;
}

$clientsquery = "SELECT Client_Id, First_Name, Last_Name FROM client";
$clientstatement = $db->prepare($clientsquery);
$clientstatement->execute();
$clients = $clientstatement->fetchAll();

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
    <main class="editview" id="create-post">
        <div id="postreview">
            <main class="postreview">
                <h1>New Review</h1>
            </main>
            <form action="postreview.php" method="POST">
                <ul>
                    <li>
                        <div class="post-group">
                            <label for="client">Client</label>
                            <select name="Client_Id" id="client" required>
                                <option value="" disabled selected>Select a client</option>
                                <?php foreach ($clients as $client): ?>
                                    <option value="<?= $client['Client_Id']?>"><?= ($client['First_Name'] . ' ' . $client['Last_Name']) ?></option>
                                    <?php endforeach; ?>
                            </select>
                        </div>
                    </li>
                    <li>
                        <div class="post-group">
                            <label for="title">Title</label>
                            <input type="text" name="Review_Title" id="title" minlength="1" maxlength="40" required>
                        </div>
                    </li>
                    <li>
                        <div class="post-group">
                            <label for="content">Review Content</label>
                            <textarea name="Review_Content" id="content" cols="30" rows="10" minlength="1" maxlength="400" required></textarea>
                        </div>
                    </li>
                    <li>
                        <button type="submit" class="button-primary">Submit Review</button>
                    </li>
                </ul>
            </form>
        </div>
    </main>
    </div>
    <?php include('footer.php'); ?>
</body>
</html>