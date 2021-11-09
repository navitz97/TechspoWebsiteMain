<?php
    session_start();
    $status="";

    if (isset($_POST['action']) && $_POST['action'] == "remove")
    {
        if(!empty($_SESSION["cart"])) 
        {
            foreach($_SESSION["cart"] as $key => $value) 
            {
                if($_POST["code"] == $key)
                {
                    unset($_SESSION["cart"][$key]);
                    $status = "<div>Product is removed from your cart!</div>";
                }

                if(empty($_SESSION["cart"]))
                {    
                    unset($_SESSION["cart"]);
                }
            }		
        }
    }

    if (isset($_POST['action']) && $_POST['action']=="change")
    {
        foreach($_SESSION["cart"] as &$value)
        {
            if($value['code'] === $_POST["code"])
            {
                $value['quantity'] = $_POST["quantity"];
                break; 
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
            <a href="login.php">Members</a>
            <a href="cart.php" class="active">Cart</a>
        </div>
    </div>

    <div id="content">

        <?php
                    if(isset($_SESSION["cart"]))
                    {
                    $total_price = 0;
                ?>

        <style>
        table {
            width: 70%;
            margin: 20px auto;
            /* border: 1px solid #dedede; */
        }

        td {
            width: 20%;
            padding: 20px;
            border: 1px solid #dedede;
        }

        table>tr,
        table>td {
            padding: 20px;
        }

        form button {
            background-color: #70b1e9;
            color: white;
            margin-top: 10px;
            height: 25px;
            width: 100px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        form button:hover {
            background-color: #9ec7eb;
        }

        form select {
            background-color: white;
            border: 2px solid #dedede;
        }
        </style>

        <table class="table">
            <tbody>
                <tr>
                    <td></td>
                    <td><strong>Item</strong></td>
                    <td><strong>Amount</strong></td>
                    <td><strong>Price</strong></td>
                    <td><strong>Total</strong></td>
                </tr>

                <?php		
                        foreach ($_SESSION["cart"] as $product)
                        {
                    ?>

                <tr>
                    <td>
                        <img src='<?php echo $product["image"]; ?>' style="width: 75%;" />
                    </td>
                    <td>
                        <?php echo $product["name"]; ?>
                        <br />

                        <form method='post' action=''>
                            <input type='hidden' name='code' value="<?php echo $product["code"]; ?>" />
                            <input type='hidden' name='action' value="remove" />
                            <button type='submit' class='remove'>Remove Item</button>
                        </form>
                    </td>
                    <td>
                        <form method='post' action=''>
                            <input type='hidden' name='code' value="<?php echo $product["code"]; ?>" />
                            <input type='hidden' name='action' value="change" />
                            <select name='quantity' class='quantity' onChange="this.form.submit()">
                                <option <?php if($product["quantity"]==1) echo "selected";?> value="1">1
                                </option>
                                <option <?php if($product["quantity"]==2) echo "selected";?> value="2">2
                                </option>
                                <option <?php if($product["quantity"]==3) echo "selected";?> value="3">3
                                </option>
                                <option <?php if($product["quantity"]==4) echo "selected";?> value="4">4
                                </option>
                                <option <?php if($product["quantity"]==5) echo "selected";?> value="5">5
                                </option>
                            </select>
                        </form>
                    </td>
                    <td>
                        <?php echo "R".$product["price"]; ?>
                    </td>
                    <td>
                        <?php echo "R".$product["price"]*$product["quantity"]; ?>
                    </td>
                </tr>
                <?php
                            $total_price += ($product["price"]*$product["quantity"]);
                            }
                        ?>
                <tr>
                    <td colspan="5" allign="right">
                        <strong>TOTAL: <?php echo "R".$total_price; ?></strong>
                    </td>
                </tr>
            </tbody>
        </table>

        <?php
                }
                
                else
                {
                    echo "<h3>Your cart is empty!</h3>";
                }
            ?>

        <?php echo $status; ?>

    </div>

</body>

</html>