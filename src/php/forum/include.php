<?php
function doDB()
{
    global $mysqli;
    //connect to server and select database; you may need it
    $mysqli = mysqli_connect(
        "localhost",
        "root",
        "000000",
        "recordforum"
    );
    //if connection fails, stop script execution
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit();
    }
}
