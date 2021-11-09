<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Styles.css?v=<?php echo time(); ?>">
    <title>Welcome</title>
</head>

<body>
    <!-- Navigation -->
    <div class="navigation">
        <!-- Website logo -->
        <div class="logo">
            <img src="images/logo.png" alt="logo">
        </div>

        <!-- Navigation Bar -->
        <div class="navbar">
            <a href="index.php" class="active">Home</a>
            <a href="About.php">About</a>
            <a href="Store.php">Shop</a>
            <a href="Contact.php">Contact</a>
            <a href="login.php">Members</a>
            <a href="cart.php">Cart</a>
        </div>
    </div>

    <div class="home-hero">
        <div class="home-hero_banner">
            <div class="home-hero_banner-date">
                <h1>2-3 November 2022</h1>
            </div>
            <div class="home-hero_banner-venue">
                <p>
                    Ticket Pro Dome, <br>
                    Northgate Shopping Centre, Johannesburg
                </p>
            </div>
        </div>    

        <div class="home-hero_text">
            <h1>A Big Tech Collaboration</h1>
            <p>
                Be prepared to be inspired, amazed and educated on the evolution of technology that
                will impact your business growth.
            </p>

        </div>

        <button onclick="document.location='About.php'">Read More</button>
    </div>

</body>

</html>