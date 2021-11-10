<?php
    // Start of session
    session_start();

    // Check if user is logged in
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
    {
        header("location: Members.php");
        exit;
    }

    //Include Config
    require_once "passw_config.php";

    // Define variables
    $username = $password = "";
    $username_err = $password_err = $login_err = "";

    // Process the data sent
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {

        // Check for empty username
        if(empty(trim($_POST["username"])))
        {
            $username_err = "<p>Please enter a username.</p>";
        }

        else
        {
            $username = trim($_POST["username"]);
        }

        // Check for empty password
        if(empty(trim($_POST["password"])))
        {
            $password_err = "<p>Please enter a password.</p>";
        }

        else
        {
            $password = trim($_POST["password"]);
        }

        //Validate Credentials
        if(empty($username_err) && empty($password_err))
        {
            // Preparing a select statement
            $LinkTest = "SELECT id, username, password 
                            FROM users WHERE username = ?;";

            if($stmt = mysqli_prepare($Link, $LinkTest))
            {
                // Bind statements as parameters
                mysqli_stmt_bind_param($stmt, "s", $param_username);

                //Set parameter
                $param_username = $username;

                //Attempt to execute the statement
                if(mysqli_stmt_execute($stmt))
                {
                    // Store the result
                    mysqli_stmt_store_result($stmt);

                    // check if user exists id yes then 
                    // validate if passwords match
                    if(mysqli_stmt_num_rows($stmt) == 1)
                    {
                        // Bind result variable
                        mysqli_stmt_bind_result($stmt, $id, $username 
                                                        ,$hashed_password);
                        
                        //Validating password
                        if(mysqli_stmt_fetch($stmt))
                        {
                            if(password_verify($password, $hashed_password))
                            {
                                //Password is correct
                                session_start();

                                // Store session details
                                $_SESSION["loggedin"] = true;
                                $_SESSION["id"] = $id;
                                $_SESSION["username"] = $username;

                                //Redirect user to the account/members page
                                header("location: Members.php");
                            }

                            else
                            {
                                //Password is not matching/valid 
                                $login_err = "Invalid username or password";
                            }
                        }
                    }

                    else
                    {
                        // Username doesn't exist
                        $login_err = "Invalid username or password";
                    }
                }

                else
                {
                    echo "Oops! something went wrong...";
                }

                // Close statement
                mysqli_stmt_close($stmt);
            }
        }

        //Close Connection
        mysqli_close($Link);
    }
?>

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
            <a href="index.php">Home</a>
            <a href="About.php">About</a>
            <a href="Store.php">Shop</a>
            <a href="Contact.php">Contact</a>
            <a href="login.php" class="active">Members</a>
            <a href="cart.php">Cart</a>
        </div>
    </div>

    <div class="membercontent" style="background-color: #077BC2;">
        <div class="memberleft">
            <img src="Images/contact_cartoon.png" alt="">
        </div>

        <div class="membershell">
            <h2 style="font-size: 40px; padding: 20px 0px 0px 20px;">Welcome Back!</h2>
            <p style="padding-left: 20px">Log in to continue</p> <br>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="loginform">
                <label>Username:</label><br>
                <input type="text" name="username" class="<?php echo (!empty($username)) ? 'is-valid' : '' ?> ">

                <?php echo $username_err; ?>
                <br><br>
                <label>Password: </label><br>
                <input type="password" name="password" class="<?php echo (!empty($password)) ? 'is-valid' : '' ?> ">

                <?php echo $password_err; ?>
                <br><br>
                <p>Need an account? <a href="register.php">Register</a></p>
                <br><br>
                <input type="submit" value="Login">
            </form>
        </div>
    </div>

    <footer>
        <p>&copy; Techspo 2022. All Rights Reserved. Website by Stefan van Deventer & Dewald Oberholzer 2021</p>
    </footer>
</body>

</html>