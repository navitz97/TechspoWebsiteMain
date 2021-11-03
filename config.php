<?php
    $Link = mysqli_connect("localhost", "root", "", "ctucourses");

    if($Link === false)
    {
        echo "Failed to connect";
        die();
    }
?>