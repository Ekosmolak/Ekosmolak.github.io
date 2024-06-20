<?php
/*******w******** 
    
    Name: Eric Kosmolak
    Date: May 23, 2024
    Description: Web Dev 2 Final Project

****************/
require('authenticate.php');
require('connect.php');

$clientsquery = "SELECT Client_Id, First_Name, Last_Name FROM client";
$clientstatement = $db->prepare($clientsquery);
$clientstatement->execute();
$clients = $clientstatement->fetchAll();

$fishquery = "SELECT * FROM fish";
$fishstatement = $db->prepare($fishquery);
$fishstatement->execute();
$fishes = $fishstatement->fetchAll();

if($_POST && !empty($_POST['Client_Id']) && !empty($_POST['Catch_Size']))
{
    $image_upload_detected = isset($_FILES['image']) && ($_FILES['image']['error'] === 0);

    // Sanitize user input
    $fish_size = filter_input(INPUT_POST, 'Catch_Size', FILTER_SANITIZE_NUMBER_FLOAT);
    $date_caught = filter_input(INPUT_POST, 'Date_Caught', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $client_id = filter_input(INPUT_POST, 'Client_Id', FILTER_SANITIZE_NUMBER_INT);
    $fish_id = filter_input(INPUT_POST, 'Fish_Id', FILTER_SANITIZE_NUMBER_INT);

    if($image_upload_detected)
    {
        $image_filename = $_FILES['image']['name'];
        $temporary_image_path = $_FILES['image']['tmp_name'];
        $upload_directory = 'uploads/';

        if(!file_exists($upload_directory))
        {
            mkdir($upload_directory, 0777, true);
        }

        $photo_path = $upload_directory . $image_filename;

        if(move_uploaded_file($temporary_image_path, $photo_path))
        {
            // Build the parameterized SQL query and bind to the above sanitized values
            $query = "INSERT INTO catchlog (Fish_Id, Catch_Size, Client_Id, fish_pic, Date_Caught) VALUES (:Fish_Id, :Catch_Size, :Client_Id, :fish_pic, :Date_Caught)";
            $statement = $db->prepare($query);

            // Bind values to parameters
            $statement->bindValue(':Catch_Size', $fish_size);
            $statement->bindValue(':Date_Caught', $date_caught);
            $statement->bindValue(':Client_Id', $client_id);
            $statement->bindValue(':Fish_Id', $fish_id);
            $statement->bindValue(':fish_pic', $photo_path);

            // Execute the INSERT
            if($statement->execute())
            {
                echo "Success";
                $location = "catchlog.php";
                header("Location: $location");
                exit;
            } else {
                echo "Error executing SQL query";
            }
        }
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
                <label for="client">Angler</label>
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
                    <option value="" disabled selected>Select a Species</option>
                    <?php foreach ($fishes as $fish): ?>
                        <option name="Fish_Type" value="<?= $fish['Fish_Id']?>"><?= $fish['Fish_Type']?></option>
                        <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="sizefish">Size of Fish</label>
                <br>
                <input type="number" name="Catch_Size" id="Catch_Size" step="0.01" min="9.00" max="60.00" required>
            </div>

            <div class="form-group">
                <label for="datecaught">Date Caught</label>
                <br>
                <input type="date" name="Date_Caught" id="Date_Caught" min="2024-01-01" max="<?=date("Y-m-d")?>" required>
            </div>

            <div class="form-group">
                <label for="image">Image Filename:</label>
                <br>
                <input type="file" name="image" id="image">
            </div>
            <br>

            <button type="submit" name="submit" class="button-primary">Submit Catch</button>
        </form>
        <br>
    </main>
    </div>
    <?php include('footer.php'); ?>
</body>
</html>