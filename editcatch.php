<?php

/*******w******** 
    
    Name: Eric Kosmolak
    Date: May 23, 2024
    Description: Web Dev 2 Final Project

****************/
require('authenticate.php');
require('connect.php');

$id = [];
$catch = [];

if(isset($_GET['Catch_Id']))
{
    $fishquery = "SELECT * FROM fish";
    $fishstatement = $db->prepare($fishquery);
    $fishstatement->execute();
    $fishes = $fishstatement->fetchAll();

    $id = filter_input(INPUT_GET, 'Catch_Id', FILTER_SANITIZE_NUMBER_INT);

    $query = "SELECT * FROM catchlog INNER JOIN client ON catchlog.Client_Id = client.Client_Id WHERE Catch_Id = :Catch_Id";
    $statement = $db->prepare($query);
    $statement->bindValue(':Catch_Id', $id, PDO::PARAM_INT);

    $statement->execute();
    $catch = $statement->fetch();
} else {
    $id = false;
}

if($_POST)
{
    $is_post = true;

    if(isset($_POST['command']) && $_POST['command'] == "UpdateCatch")
    {
        echo "update";

        // Sanitize user input
        $fish_size = filter_input(INPUT_POST, 'Catch_Size', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $date_caught = filter_input(INPUT_POST, 'Date_Caught', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $client_id = filter_input(INPUT_POST, 'Client_Id', FILTER_SANITIZE_NUMBER_INT);
        $fish_id = filter_input(INPUT_POST, 'Fish_Id', FILTER_SANITIZE_NUMBER_INT);
        $catch_id = filter_input(INPUT_POST, 'Catch_Id', FILTER_SANITIZE_NUMBER_INT);

        // Handle the file upload
        
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) 
        {
            $file_tmp_path = $_FILES['image']['tmp_name'];
            $file_name = $_FILES['image']['name'];
            $upload_dir = 'uploads/';
            $image_path = $upload_dir . $file_name;

            // Ensure the upload directory exists
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            // Move the uploaded file to the destination directory
            if(move_uploaded_file($file_tmp_path, $image_path))
            {
                $query = "UPDATE catchlog SET Fish_Id = :Fish_Id, Catch_Size = :Catch_Size, Client_Id = :Client_Id, Date_Caught = :Date_Caught, fish_pic = :fish_pic WHERE Catch_Id = :Catch_Id";
                $statement = $db->prepare($query);

                // Bind values to parameters
                $statement->bindValue(':Catch_Size', $fish_size);
                $statement->bindValue(':Date_Caught', $date_caught);
                $statement->bindValue(':Client_Id', $client_id);
                $statement->bindValue(':Fish_Id', $fish_id);
                $statement->bindValue(':Catch_Id', $catch_id);
                $statement->bindValue(':fish_pic', $image_path);

                // Debugging: Output the query and bound values
                echo "<pre>$query\n";
                print_r([
                    ':Catch_Size' => $fish_size,
                    ':Date_Caught' => $date_caught,
                    ':Client_Id' => $client_id,
                    ':Fish_Id' => $fish_id,
                    ':Catch_Id' => $catch_id,
                    ':fish_pic' => $image_path
                ]);
                echo "</pre>";

                $statement->execute();

                $location = "catchlog.php";

                header("Location: $location");
                exit;
            }
        } else {
            $query = "UPDATE catchlog SET Fish_Id = :Fish_Id, Catch_Size = :Catch_Size, Client_Id = :Client_Id, Date_Caught = :Date_Caught WHERE Catch_Id = :Catch_Id"; 
            $statement = $db->prepare($query);

            // Bind values to parameters
            $statement->bindValue(':Catch_Size', $fish_size);
            $statement->bindValue(':Date_Caught', $date_caught);
            $statement->bindValue(':Client_Id', $client_id);
            $statement->bindValue(':Fish_Id', $fish_id);
            $statement->bindValue(':Catch_Id', $catch_id);

            // Debugging: Output the query and bound values
            echo "<pre>$query\n";
            print_r([
                ':Catch_Size' => $fish_size,
                ':Date_Caught' => $date_caught,
                ':Client_Id' => $client_id,
                ':Fish_Id' => $fish_id,
                ':Catch_Id' => $catch_id
            ]);
            echo "</pre>";


            $statement->execute();

            header("Location: catchlog.php");
            exit;
        }
    }
    elseif(isset($_POST['command']) && $_POST['command'] == "Delete")
    {
        $id = filter_input(INPUT_POST, 'Catch_Id', FILTER_SANITIZE_NUMBER_INT);

        $query = "DELETE FROM catchlog WHERE Catch_Id = :Catch_Id";
        $statement = $db->prepare($query);
        $statement->bindValue(':Catch_Id', $id, PDO::PARAM_INT);
        $location = "catchlog.php";

        $statement->execute();

        header("Location: $location");
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
    <title>Edit Catch</title>
</head>
<body id="edit-catch">
    <?php include('header.php') ?>

    <?php include('nav.php') ?>
    <div id="wrapper">
    <main class="container py-1">

    <form action="editcatch.php" method="POST" enctype="multipart/form-data">
        <h2>Edit your catch!</h2>

        <input type="hidden" name="Catch_Id" value="<?=$catch['Catch_Id']?>">

        <div class="form-group">
            <label for="Client_Id">Angler</label>
            <br>
            <select name="Client_Id" id="client" required>
                <option value="<?= $catch['Client_Id']?>"><?= ($catch['First_Name'] . ' ' . $catch['Last_Name']) ?></option>
            </select>
        </div>

        <div class="form-group">
            <label for="fish">Type of Fish</label>
            <br>
            <select name="Fish_Id" id="fish" required>
                <option name="Fish_Type" value="<?= $catch['Fish_Id']?>"><?= $catch['Fish_Type']?></option>
                <?php foreach ($fishes as $fish): ?>
                        <option name="Fish_Type" value="<?= $fish['Fish_Id']?>"><?= $fish['Fish_Type']?></option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label for="sizefish">Size of Fish</label>
            <br>
            <input type="number" name="Catch_Size" value="<?=$catch['Catch_Size']?>" id="Catch_Size" step="0.01" min="9.00" max="60.00" required>
        </div>

        <div class="form-group">
            <label for="datecaught">Date Caught</label>
            <br>
            <input type="date" name="Date_Caught" value="<?=$catch['Date_Caught']?>" id="Date_Caught" min="2024-01-01" max="<?=date("Y-m-d")?>" required>
        </div>

        <div class="form-group">
            <label for="image">Image:</label>
            <input type="file" name="image" id="image">
        </div>
        <br>

        <input type="hidden" name="command" value="UpdateCatch">
        <input type="submit" id="edit-input" name="button-primary" value="Update Catch"> 

        </form>

        <form action="editcatch.php" method="POST">
            <input type="hidden" id="edit-input" name="Catch_Id" value="<?=$catch['Catch_Id']?>">
            <input type="hidden" name="command" value="Delete">
            <input type="submit" name="button-primary-outline" value="Delete" onclick="return confirm('Are you sure you want to delete this post?')">
        </form>
    </main>
    </div>
    <?php include('footer.php'); ?>
</body>
</html>