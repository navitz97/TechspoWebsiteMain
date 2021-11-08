<?php
    session_start();

    // Check if user is logged in
    if(!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] !== true)
    {
        header("location: login.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Styles.css?v=<?php echo time(); ?>">
    <title>Members</title>
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
            <a href="index.php">Home</a>
            <a href="About.php">About</a>
            <a href="Store.php">Shop</a>
            <a href="Contact.php">Contact</a>
            <a href="login.php" class="active">Members</a>
        </div>
    </div>

    <div class="membershell">
        <h2 style="font-size: 40px; padding: 20px 0px;">Account Details</h2>
        <br><br>

        <h1>Welcome back to Techspo, <strong><?php echo 
                    htmlspecialchars($_SESSION["username"]); ?></strong></h1>

        <br><br>

        <!--<a href="reset.php"><p>Reset Password</p></a>-->
        <a href="logout.php">
            <p>Logout</p>
        </a>
        <br><br>
    </div>
</body>

</html>