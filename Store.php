<?php
    session_start();
    include('config.php');
    $status = "";

    if(isset($_POST['code']) && $_POST['code'] != "")
    {
        $code = $_POST['code'];
        $result = mysqli_query(
            $Link,
            "SELECT * FROM courses WHERE code = '$code'"
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

<body>
    <!-- Website logo -->
    <div class="logo">
        <img src="images/Logo_2.png" alt="logo">
    </div>

    <!-- Navigation Bar -->
    <div class="navbar">
        <a href="index.php">Home</a>
        <a href="About.php">About</a>
        <a href="Store.php" class="active">Shop</a>
        <a href="Contact.php">Contact</a>
        <a href="Members.php">Members</a>
    </div>

    <div class="store">
        <div class="products">

        </div>
    </div>
</body>

</html>