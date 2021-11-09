<?php
    #Include Config
    require_once "passw_config.php";

    # Variables
    $username = $password = $confirm_password = "";
    $username_err = $password_err = $confirm_password_err = "";

    # Sending data when the form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        #Validating Username
        if(empty(trim($_POST["username"])))
        {
            $username_err = "Please enter a username";
        }

        elseif(!preg_match('/^[a-zA-Z0-9]+$/', trim($_POST["username"])))
        {
            $username_err = "Username can only contain letters, numbers and 
                                underscores";
        }

        else
        {
            #Preparing to select data
            $sql = "SELECT id FROM users WHERE username = ?";

            if($stmt = mysqli_prepare($Link, $sql))
            {
                #Binding data to the statement
                mysqli_stmt_bind_param($stmt, "s", $param_username);

                #Set parameter
                $param_username = trim($_POST["username"]);

                #Executing the parameter
                if(mysqli_stmt_execute($stmt))
                {
                    #Storing the data
                    mysqli_stmt_store_result($stmt);

                    if(mysqli_stmt_num_rows($stmt) == 1)
                    {
                        $username_err = "This username is already taken";
                    }

                    else
                    {
                        $username = trim($_POST["username"]);
                    }
                } 

                else
                {
                    echo "Oops... something went wrong, please try again later.";
                }

                #close statement
                mysqli_stmt_close($stmt);
            }
        }

        // Validate Password
        if(empty(trim($_POST["password"])))
        {
            $password_err = "Please enter a password";
        }

        elseif(strlen(trim($_POST["password"])) < 6)
        {
            $password_err = "Password must have at least 6 characters";
        }

        else
        {
            $password = trim($_POST["password"]);
        }

        //Validate Confirm Password
        if(empty(trim($_POST["confirm_password"])))
        {
            $confirm_password_err = "Please confirm password";
        }

        else
        {
            $confirm_password = trim($_POST["confirm_password"]);

            if(empty($password_err) && ($password != $confirm_password))
            {
                $confirm_password_err = "Password did not match";
            }
        }

        //Check for input errors
        if(empty($username_err) && empty($password_err) 
                                        && empty($confirm_password_err))
        {
            // Preparing the statement
            $InsertMethod = "INSERT INTO users (username, password) VALUES (?, ?)";

            if($stmt = mysqli_prepare($Link, $InsertMethod))
            {
                // Bind variables to the prepared parameters
                mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            
                // Set parameters
                $param_username = $username;
                //Password Hash
                $param_password = password_hash($password, PASSWORD_DEFAULT); 

                //Executing the statement
                if(mysqli_stmt_execute($stmt))
                {
                    // Redirect the user to the login page
                    header("location: login.php");
                }

                else
                {
                    echo "Oops Something went wrong, please try again later.";
                }

                //Close statement
                mysqli_stmt_close($stmt);
            }
        }

        // Closing the connection
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

    <div class="membercontent" style="background-color: #49A8E2;">
        <div class="memberleft">
            <img src="Images/contact_cartoon.png" alt="">
        </div>

        <div class="membershell">
            <h2 style="font-size: 40px; padding: 20px 0px;">Register</h2>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="loginform">
                <label>Username:</label><br>
                <input type="text" name="username" class="<?php echo(!empty($username_err)) ? 'is-valid': ''; ?>"
                    value="<?php echo $username; ?>">
                <br><br>
                <label>Password:</label><br>
                <input type="password" name="password" class="<?php echo(!empty($password_err)) ? 'is-valid': ''; ?>"
                    value="<?php echo $password; ?>">
                <br><br>
                <label>Confirm Password:</label><br>
                <input type="password" name="confirm_password"
                    class="<?php echo(!empty($confirm_password_err)) ? 'is-valid': ''; ?>">
                <br><br>
                <p>Already have an account? <a href="login.php">Login</a></p>
                <br><br>
                <input type="submit" value="Submit">
            </form>
        </div>

</body>

</html>