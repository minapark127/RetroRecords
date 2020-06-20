<?php
session_start();

if (isset($_POST["sel_productId"])) {

    //connect to database
    $mysqli = mysqli_connect("localhost", "root", "000000", "cart_test");

    //create safe values for use
    $safe_sel_productId = mysqli_real_escape_string(
        $mysqli,
        $_POST["sel_productId"]
    );

    $safe_sel_productQty = mysqli_real_escape_string(
        $mysqli,
        $_POST["sel_productQty"]
    );

    // $safe_sel_productSize = mysqli_real_escape_string($mysqli,
    //       $_POST["sel_productSize"]);

    // $safe_sel_productColor = mysqli_real_escape_string($mysqli,
    //       $_POST["sel_productColor"]);


    //validate product and get title and price
    $get_productinfo_sql = "SELECT productTitle FROM products WHERE
                            productId = '" . $safe_sel_productId . "'";
    $get_productinfo_res = mysqli_query($mysqli, $get_productinfo_sql)
        or die(mysqli_error($mysqli));

    if (mysqli_num_rows($get_productinfo_res) < 1) {

        //free result
        mysqli_free_result($get_productinfo_res);

        //close connection to MySQL
        mysqli_close($mysqli);

        //invalid id, send away
        header("Location: seestore.php");
        exit;
    } else {
        //get info
        while ($product_info = mysqli_fetch_array($get_productinfo_res)) {
            $product_title =  stripslashes($product_info["productTitle"]);
        }

        //free result
        mysqli_free_result($get_productinfo_res);

        //add info to cart table
        $addtocart_sql = "INSERT INTO shoppertrack
                      (sessionId, sel_productId, sel_productQty, date_added)
                      VALUES ('" . $_COOKIE['PHPSESSID'] . "',
                       '" . $safe_sel_productId . "',
                       '" . $safe_sel_productQty . "', now())";
        $addtocart_res = mysqli_query($mysqli, $addtocart_sql)
            or die(mysqli_error($mysqli));

        //close connection to MySQL
        mysqli_close($mysqli);

        //redirect to showcart page
        header("Location: showcart.php");
        exit;
    }
} else {
    //send them somewhere else
    header("Location: seestore.php");
    exit;
}
