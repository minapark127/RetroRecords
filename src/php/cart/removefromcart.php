<?php
session_start();

if (isset($_GET['id'])) {
    //connect to database
    $mysqli = mysqli_connect("localhost", "root", "000000", "cart_test");

    //create safe values for use
    $safe_id = mysqli_real_escape_string($mysqli, $_GET['id']);

    $delete_item_sql = "DELETE FROM shoppertrack WHERE
                        trackId = '" . $safe_id . "' and sessionId =
                        '" . $_COOKIE['PHPSESSID'] . "'";
    $delete_item_res = mysqli_query($mysqli, $delete_item_sql)
        or die(mysqli_error($mysqli));

    //close connection to MySQL
    mysqli_close($mysqli);


    //redirect to showcart page
    header("Location: showcart.php");
    exit;
} else {
    //send them somewhere else
    header("Location: seestore.php");
    exit;
}
