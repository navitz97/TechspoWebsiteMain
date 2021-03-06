<?php
    session_start();
    include('config.php');
    $status = "";

    if(isset($_POST['code']) && $_POST['code'] != "")
    {
        $code = $_POST['code'];
        $result = mysqli_query(
            $Link,
            "SELECT * FROM merch WHERE code = '$code'"
        );

        $row = mysqli_fetch_assoc($result);

        $name = $row['name'];
        $code = $row['code'];
        $price = $row['price'];
        $image = $row['image'];

        $wishArray = array(
            $code => array(
                'name' => $name,
                'code' => $code,
                'price' => $price,
                'quantity' => 1,
                'image' => $image
            )
        );

        if(empty($_SESSION["cart"]))
        {
            $_SESSION["cart"] = $wishArray;
            $status = "Product added to cart!";
        }

        else
        {
            $wish_keys = array_keys($_SESSION["cart"]);

            if(in_array($code,$wish_keys))
            {
                $status = "Product is already on your list!";
            }

            else
            {
                $_SESSION["cart"] = array_merge(
                    $_SESSION["cart"],
                    $wishArray
                );

                $status = "Course is already in your cart!";
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
    <title>Store</title>
</head>

<body class="storebody">
    <div class="navigation">
        <!-- Website logo -->
        <div class="logo">
            <img src="images/logo.png" alt="logo">
        </div>

        <!-- Navigation Bar -->
        <div class="navbar">
            <a href="index.php">Home</a>
            <a href="About.php">About</a>
            <a href="Store.php" class="active">Shop</a>
            <a href="Contact.php">Contact</a>
            <a href="login.php">Members</a>
            <a href="cart.php">Cart</a>
        </div>
    </div>

    <h1 class="storeheading">Shop for Techspo 2022</h1>
    <div class="store">
        <h2>Clothing and Merchandise</h2>
        <div class="products">
            <?php
            	if(!empty($_SESSION["cart"]))
            	{
        	?>

            <div class="Wishlist_Container">
                <a href="wishlist.php">

                    <span>
                        <?php $wish_count; ?>
                    </span>
                </a>
            </div>

            <?php
            	}
        	?>

            <?php
                $result = mysqli_query($Link, "SELECT * FROM merch");

           	    while($row = mysqli_fetch_assoc($result))
                {
                    echo "
                        <div class='product'>
                            <form method = 'post' action = '' style='float: left; margin: 20px;'>
                                <input type='hidden' name = 'code' value = ".$row['code'].">
                                <div>
                                    <img src=".$row['image']." style='height:150px; width: 150px; object-fit: contain;'>
                                </div> <br>
                                <div>
                                    ".$row['name']."
                                </div> <br>
                                <div>
                                    ".$row['price']."
                                </div>

                                <button type='submit' class='itemButton'>Add to Cart</button>
                            </form>
                        </div>
                    ";  
                }

                mysqli_close($Link);
            ?>

            <br>
            <div>
                <?php echo $status ?>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; Techspo 2022. All Rights Reserved. Website by Stefan van Deventer & Dewald Oberholzer 2021</p>
    </footer>
</body>

</html>