<?php

// /*******w******** 
    
//     Name: Eric Kosmolak
//     Date: May 23, 2024
//     Description: Web Dev 2 Final Project

// ****************/

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Fish</title>
</head>
<body>
    <?php include('header.php'); ?>
    <?php include('nav.php'); ?>

    <div id="wrapper">
        <div class="container py2">
            <h1>World Class Fishing!</h2>
        </div>

        <div id="walleye-post">
            <h3>Walleye</h3>
            <img src="images/walleye.png" alt="Walleye" height="100px" width="200px"> <!-- https://www.eekwi.org/animals/fish/walleye -->
            <p>The walleye is a freshwater fish native to North America, known for its distinctive olive and gold coloring, and large, glassy eyes. 
                It is highly prized both as a game fish and for its delicious, flaky white meat. Walleyes inhabit a variety of aquatic environments, from lakes to rivers, preferring clear, cool waters. 
                They are nocturnal feeders, primarily consuming smaller fish and invertebrates. This fish species is significant not only for recreational fishing but also for its role in local ecosystems and economies, often being stocked in lakes to support both natural populations and fishing industries.</p>
        </div>
        <div id="pike-post">
            <h3>Pike</h3>
            <img src="images/pike.png" alt="Pike" height="100px" width="200px"> <!-- https://nookipedia.com/wiki/Pike -->
            <p>
            The pike is a predatory freshwater fish widely distributed across the Northern Hemisphere, including North America, Europe, and Asia. 
            Recognizable by its elongated body, sharp teeth, and distinctive, duckbill-like snout, the pike is an apex predator in many freshwater ecosystems. 
            This fish thrives in a variety of habitats such as lakes, rivers, and marshes, preferring dense vegetation where it can ambush prey. Known for its aggressive behavior and formidable hunting skills, the pike is a popular target for sport fishing, valued for the challenge it presents to anglers.</p>
        </div>
        <div id="smallmouth-post">
            <h3>Smallmouth Bass</h3>
            <img src="images/smallmouth.png" alt="SmallMouth Bass" height="100px" width="200px"> <!-- https://huntfishmanitoba.ca/species/smallmouth-bass/ -->
            <p>The smallmouth bass is a freshwater fish native to North America, particularly found in clear, cool rivers and lakes. 
                It is easily identifiable by its bronze to greenish-brown coloration and the vertical bars along its sides. 
                Smallmouth bass prefer rocky habitats and areas with strong currents, making them a common sight in streams and rivers with abundant cover. 
                Known for their spirited fighting ability when hooked, smallmouth bass are a favorite among anglers. 
                Their presence in various water bodies contributes significantly to recreational fishing, supporting both local economies and conservation efforts.</p>
        </div>
        <div id="largemouth-post">
            <h3>Largemouth Bass</h3>
            <img src="images/largemouth.png" alt="LargeMouth Bass" height="100px" width="200px"> <!-- https://wiki.fishingplanet.com/Largemouth_Bass -->
            <p>The largemouth bass is a prominent freshwater fish native to North America, characterized by its olive-green body with a series of dark blotches forming a horizontal stripe along each flank. 
                Unlike the smallmouth bass, largemouth bass prefer warmer, slower-moving waters, thriving in lakes, ponds, and reservoirs with ample vegetation. 
                This species is recognized by its large mouth, extending past the eye, and its robust build. 
                Largemouth bass are highly valued in sport fishing due to their size and strength, making them a popular target for anglers. 
                Their adaptability to various habitats and their role in the fishing industry highlight their ecological and economic importance.</p>
        </div>
        <div id="perch-post">
            <h3>Perch</h3>
            <img src="images/perch.png" alt="Perch" height="100px" width="200px"> <!-- https://www.deviantart.com/zoostock/art/Fish-perch-on-a-transparent-background-757649780 -->
            <p>The perch, commonly known as the yellow perch, is a freshwater fish native to North America. 
                It is easily recognizable by its golden-yellow body with distinct dark vertical stripes and its spiny dorsal fin.
                Yellow perch inhabit a wide range of freshwater environments, including lakes, rivers, and ponds, preferring clear, vegetated waters. 
                Known for their schooling behavior, perch are often found in large groups, particularly during spawning seasons. 
                They are a popular species for both recreational and commercial fishing, appreciated for their cooperative feeding habits and accessibility, making them an important part of local fishing communities and ecosystems.</p>
        </div>
        <div id="musky-post">
            <h3>Musky</h3>
            <img src="images/musky.png" alt="Perch" height="100px" width="200px"> <!-- https://bassonline.com/freshwater-species/musky-fish/ -->
            <p>The muskellunge, commonly known as the musky, is a large, freshwater fish native to North America. Renowned for its impressive size and predatory nature, it can grow over 50 inches long and weigh more than 30 pounds. 
                Muskies have elongated bodies, pointed snouts, and sharp teeth, making them formidable hunters that prey on fish, frogs, and small mammals. 
                Found primarily in the northern United States and Canada, they inhabit lakes and rivers with clear water and abundant vegetation. 
                Anglers prize muskies for their challenging catch, often referring to them as the "fish of 10,000 casts" due to their elusive nature.</p>
        </div>
    </div>
    <?php include('footer.php'); ?>
</body>
</html>