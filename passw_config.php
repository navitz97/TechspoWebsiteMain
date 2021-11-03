<?php
    # Defining, setting up database
    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'techspo');

    #Physical connection  to database
    $Link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    #Test the link
    if($Link === false)
    {
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }

?>