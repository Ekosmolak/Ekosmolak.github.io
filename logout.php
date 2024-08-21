<?php

// *******w******** 
    
//     Name: Eric Kosmolak
//     Date: May 23, 2024
//     Description: Web Dev 2 Final Project

// ****************/

// Start the session
session_start();

// Unset all of the session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to a login page or another appropriate page
header("Location: login.php");
exit; 
?>