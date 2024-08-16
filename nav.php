<?php

// *******w******** 
    
//     Name: Eric Kosmolak
//     Date: May 23, 2024
//     Description: Web Dev 2 Final Project

// ****************/

// Get the current page name
$current_page = basename($_SERVER['PHP_SELF'], ".php");

// Define the button text based on the current page
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
?>

<nav class="nav">
    <ul class="container">
        <li><a href="index.php">Home</a></li>
        <li><a href="fish.php" class="button-primary-outline">Fish</a></li>
        <li><a href="catchlog.php" class="button-primary-outline">Recent Catches</a></li>
        <li><a href="masteranglers.php" class="button-primary-outline">Master Anglers</a></li>
        <li><a href="reviews.php" class="button-primary-outline">Reviews</a></li>
        <li><a href="bookstay.php" class="button-primary-outline">Book a Stay</a></li>
        <li><a href="login.php" class="button-primary-outline">Login</a></li>
    </ul>
</nav>
<!-- <nav class="mobilenavbar">
    <select name="mobilenavbar" id="mobilenavbar" media>
        <option value="home"><a href="index.php">Home</a></option>
        <option value="fish"><a href="fish.php" class="button-primary-outline">Fish</a></option>
        <option value="catchlog"><a href="catchlog.php" class="button-primary-outline">Recent Catches</a></option>
        <option value="masteranglers"><a href="masteranglers.php" class="button-primary-outline">Master Anglers</a></option>
        <option value="reviews"><a href="reviews.php" class="button-primary-outline">Reviews</a></option>
        <option value="bookstay"><a href="bookstay.php" class="button-primary-outline">Book a Stay</a></option>
        <option value="login"><a href="login.php" class="button-primary-outline">Login</a</option>
    </select>
</nav> -->

<nav class="mobilenavbar">
    <button id="menu-toggle" class="menu-toggle"><?php echo $button_text; ?></button>
    <ul id="menu" class="menu">
        <li><a href="index.php">Home</a></li>
        <li><a href="fish.php" class="button-primary-outline">Fish</a></li>
        <li><a href="catchlog.php" class="button-primary-outline">Recent Catches</a></li>
        <li><a href="masteranglers.php" class="button-primary-outline">Master Anglers</a></li>
        <li><a href="reviews.php" class="button-primary-outline">Reviews</a></li>
        <li><a href="bookstay.php" class="button-primary-outline">Book a Stay</a></li>
        <li><a href="login.php" class="button-primary-outline">Login</a></li>
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