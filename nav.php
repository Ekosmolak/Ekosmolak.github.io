<?php
// *******w******** 
    
//     Name: Eric Kosmolak
//     Date: May 23, 2024
//     Description: Web Dev 2 Final Project

// ****************/
// Check if a session is already started, and if not, start it
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
$is_logged_in = isset($_SESSION['username']);

// Get the current page name
$current_page = basename($_SERVER['PHP_SELF'], ".php");

// Define the button text and link based on login status and current page
if ($is_logged_in && $current_page === 'myaccount') {
    // When logged in and on 'myaccount.php', show 'My Profile'
    $button_text = 'My Profile';
    $button_link = 'myaccount.php';
} else {
    // When not logged in or not on 'myaccount.php', determine button text based on current page
    switch ($current_page) {
        case 'index':
            $button_text = 'Home';
            break;
        case 'fish':
            $button_text = 'Fish';
            break;
        case 'catchlog':
            $button_text = 'Recent Catches';
            break;
        case 'masteranglers':
            $button_text = 'Master Anglers';
            break;
        case 'reviews':
            $button_text = 'Reviews';
            break;
        case 'bookstay':
            $button_text = 'Book a Stay';
            break;
        case 'login':
            $button_text = 'Login';
            break;
        default:
            $button_text = 'Menu';
    }
    $button_link = $is_logged_in ? 'myaccount.php' : 'login.php';
}
?>

<nav class="nav">
    <ul class="container">
        <li><a href="index.php">Home</a></li>
        <li><a href="fish.php" class="button-primary-outline">Fish</a></li>
        <li><a href="catchlog.php" class="button-primary-outline">Recent Catches</a></li>
        <li><a href="masteranglers.php" class="button-primary-outline">Master Anglers</a></li>
        <li><a href="reviews.php" class="button-primary-outline">Reviews</a></li>
        <li><a href="bookstay.php" class="button-primary-outline">Book a Stay</a></li>
        <li><a href="<?php echo $button_link; ?>" class="button-primary-outline"><?php echo $is_logged_in ? 'My Profile' : 'Login'; ?></a></li>
    </ul>
</nav>

<nav class="mobilenavbar">
    <button id="menu-toggle" class="menu-toggle"><?php echo $button_text; ?></button>
    <ul id="menu" class="menu">
        <li><a href="index.php">Home</a></li>
        <li><a href="fish.php" class="button-primary-outline">Fish</a></li>
        <li><a href="catchlog.php" class="button-primary-outline">Recent Catches</a></li>
        <li><a href="masteranglers.php" class="button-primary-outline">Master Anglers</a></li>
        <li><a href="reviews.php" class="button-primary-outline">Reviews</a></li>
        <li><a href="bookstay.php" class="button-primary-outline">Book a Stay</a></li>
        <li><a href="<?php echo $button_link; ?>" class="button-primary-outline"><?php echo $is_logged_in ? 'My Profile' : 'Login'; ?></a></li>
    </ul>
</nav>

<script>
    document.getElementById('menu-toggle').addEventListener('click', function() {
    var menu = document.getElementById('menu');
    if (menu.style.display === 'block') {
        menu.style.display = 'none';
    } else {
        menu.style.display = 'block';
    }});
</script>