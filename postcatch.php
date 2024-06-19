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
    $title = filter_input(INPUT_POST, 'Review_Title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $content = filter_input(INPUT_POST, 'Review_Content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $client_id = filter_input(INPUT_POST, 'Client_Id', FILTER_SANITIZE_NUMBER_INT);
    $type_fish = filter_input(INPUT_POST, 'Fish_Type', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $fish_id = filter_input(INPUT_POST, 'Fish_Id', FILTER_SANITIZE_NUMBER_INT);
    $fish_pic = $new_image_path;

    // Build the parameterized SQL query and bind to the above sanitized values
    $query = "INSERT INTO catchlog (Fish_Id, Review_Content, Client_Id, Fish_Type, fish_pic) VALUES (:Review_Title, :Review_Content, :Client_Id, :Fish_Type, :image)";
    $statement = $db->prepare($query);

    // Bind values to parameters
    $statement->bindValue(':Review_Title', $title);
    $statement->bindValue(':Review_Content', $content);
    $statement->bindValue(':Client_Id', $client_id);
    $statement->bindValue(':Fish_Type', $type_fish);
    $statement->bindValue(':Fish_Id', $fish_id);
    $statement->bindValue(':fish_pic', $fish_pic);

    // Execute the INSERT
    if($statement->execute())
    {
        echo "Success";
    }

    $location = "catchlog.php";

    // Change to the show.php?{$id}
    header($location);
    exit;
}

$clientsquery = "SELECT Client_Id, First_Name, Last_Name FROM client";
$clientstatement = $db->prepare($clientsquery);
$clientstatement->execute();
$clients = $clientstatement->fetchAll();

$fishquery = "SELECT * FROM fish";
$fishstatement = $db->prepare($fishquery);
$fishstatement->execute();
$fishes = $fishstatement->fetchAll();

function file_upload_path($original_filename, $upload_subfolder_name = 'uploads')
{
    $current_folder = dirname(__FILE__);

    $path_segments = [$current_folder, $upload_subfolder_name, basename($original_filename)];

    return join(DIRECTORY_SEPARATOR, $path_segments);
}

function file_is_an_image($temporary_path, $new_path)
{
    $allowed_mime_types = ['image/gif', 'image/jpeg', 'image/png', 'application/pdf'];
    $allowed_file_extensions = ['gif', 'jpg', 'jpeg', 'png', 'pdf'];
    
    $actual_file_extension = pathinfo($new_path, PATHINFO_EXTENSION);
    //$actual_mime_type = getimagesize($temporary_path)['mime'];

    if (in_array($actual_file_extension, ['gif', 'jpg', 'jpeg', 'png'])) {
        // Handle images
        $actual_mime_type = getimagesize($temporary_path)['mime'];
    } else {
        // Handle non-images (like PDFs)
        $actual_mime_type = mime_content_type($temporary_path);
    }

    $file_extension_is_valid = in_array($actual_file_extension, $allowed_file_extensions);
    $mime_type_is_valid = in_array($actual_mime_type, $allowed_mime_types);

    return $file_extension_is_valid && $mime_type_is_valid;
}

$image_upload_detected = isset($_FILES['image']) && ($_FILES['image']['error'] === 0);
$upload_error_detected = isset($_FILES['image']) && ($_FILES['image']['error'] > 0);

if($image_upload_detected)
{
    $image_filename = $_FILES['image']['name'];
    $temporary_image_path = $_FILES['image']['tmp_name'];
    $new_image_path = file_upload_path($image_filename);
    if(file_is_an_image($temporary_image_path, $new_image_path))
    {
        move_uploaded_file($temporary_image_path, $new_image_path);
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
    <title>Post Your Catch</title>
</head>
<body>
    <?php include('header.php'); ?>
    <?php include('nav.php'); ?>
    <div id="wrapper">
    <main class="container py-1" id="create-post">
        <form action="postcatch.php" method="POST" enctype="multipart/form-data">
            <h2>New Catch</h2>

            <div class="form-group">
                <label for="client">Client</label>
                <br>
                <select name="Client_Id" id="client" required>
                    <option value="" disabled selected>Select a Client</option>
                    <?php foreach ($clients as $client): ?>
                        <option value="<?= $client['Client_Id']?>"><?= ($client['First_Name'] . ' ' . $client['Last_Name']) ?></option>
                        <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="fish">Type of Fish</label>
                <br>
                <select name="Fish_Id" id="fish" required>
                    <?php foreach ($fishes as $fish): ?>
                        <option value="<?= $fish['Fish_Id']?>"><?= $fish['Fish_Type']?></option>
                        <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="sizefish">Size of Fish</label>
                <br>
                <input type="number" name="Catch_Size" id="Catch_Size" min="5.00" max="60.00" required>
            </div>

            <div class="form-group">
                <label for="datecaught">Date Caught</label>
                <br>
                <input type="date" name="Date_Caught" id="Date_Caught" min="2024-01-01" max="2024-12-31" required>
            </div>

            <div class="form-group">
                <label for="image">Image Filename:</label>
                <br>
                <input type="file" name="image" id="image">
            </div>

            <?php if($upload_error_detected): ?>
                <p>Error Number: <?= $_FILES['image']['error'] ?></p>
            <?php elseif ($image_upload_detected): ?>
                <p>Client-Side Filename <?= $_FILES['image']['name'] ?></p>
                <p>Client-Side Filename <?= $_FILES['image']['type'] ?></p>
                <p>Client-Side Filename <?= $_FILES['image']['size'] ?></p>
                <p>Client-Side Filename <?= $_FILES['image']['tmp_name'] ?></p>
            <?php endif; ?>
            <br>

            <button type="submit" name="submit" class="button-primary">Submit Catch</button>
        </form>
        <br>
    </main>
    </div>
    <?php include('footer.php'); ?>
</body>
</html>