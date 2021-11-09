<?php
    $Link = mysqli_connect("localhost", "root", "", "techspomerch");

    if($Link === false)
    {
        echo "Failed to connect";
        die();
    }
?>