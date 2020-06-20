<!-- get the detail from form and save on order products
& print out the thank you msg to the user
& clear out shopper track -->
<?php
session_start();
if (isset($_POST["submit"])) {
    //connect to database
    $mysqli = mysqli_connect("localhost", "root", "000000", "cart_test");

    $safe_orderName = mysqli_real_escape_string(
        $mysqli,
        $_POST["orderName"]
    );
    $safe_orderAddress = mysqli_real_escape_string(
        $mysqli,
        $_POST["orderAddress"]
    );
    $safe_orderCity = mysqli_real_escape_string(
        $mysqli,
        $_POST["orderCity"]
    );
    $safe_orderState = mysqli_real_escape_string(
        $mysqli,
        $_POST["orderState"]
    );
    $safe_orderPostcode = mysqli_real_escape_string(
        $mysqli,
        $_POST["orderPostcode"]
    );
    $safe_orderTel = mysqli_real_escape_string(
        $mysqli,
        $_POST["orderTel"]
    );
    $safe_orderEmail = mysqli_real_escape_string(
        $mysqli,
        $_POST["orderEmail"]
    );
    $productTotal = mysqli_real_escape_string(
        $mysqli,
        $_POST["productTotal"]
    );
    $safe_productTotal = floatval($_POST["productTotal"]);
    $saveorder_sql = "INSERT INTO orders
                    (orderDate, orderName, orderAddress, orderCity, orderState,
                    orderPostcode, orderTel, orderEmail, productTotal)
                    VALUES (now(), 
                    '" . $safe_orderName . "','" . $safe_orderAddress . "',
                    '" . $safe_orderCity . "','" . $safe_orderState . "',
                    '" . $safe_orderPostcode . "','" . $safe_orderTel . "',
                    '" . $safe_orderEmail . "','" . $safe_productTotal . "'
                    )";
    // $saveorder_res = mysqli_query($mysqli, $saveorder_sql)
    //     or die(mysqli_error($mysqli));

    if (mysqli_query($mysqli, $saveorder_sql)) {

        $ordersId = mysqli_insert_id($mysqli);

        $get_cart_sql = "SELECT p.productPrice, st.sel_productQty, st.sel_productId
        FROM shoppertrack AS st LEFT JOIN products AS p ON p.productId = st.sel_productId 
        WHERE sessionId = '" . $_COOKIE['PHPSESSID'] . "'";

        $get_cart_res = mysqli_query($mysqli, $get_cart_sql)
            or die(mysqli_error($mysqli));

        while ($cart_info = mysqli_fetch_array($get_cart_res)) {
            $sel_productId = $cart_info['sel_productId'];
            $sel_productQty = $cart_info['sel_productQty'];
            $sel_productPrice = $cart_info['productPrice'];

            $ordersproducts_sql = "INSERT INTO orders_products 
        (orderId, sel_productId, sel_productQty, sel_productPrice)
        VALUES(
            '" . $ordersId . "',
            '" . $sel_productId . "', 
            '" . $sel_productQty . "', 
            '" . $sel_productPrice . "'
        )";
            $ordersproducts_res = mysqli_query($mysqli, $ordersproducts_sql)
                or die(mysqli_error($mysqli));
        }

        $products_sql = "SELECT p.productId, p.productsQty, op.sel_productId, op.sel_productQty
        FROM products AS p LEFT JOIN orders_products AS op ON p.productId = op.sel_productId";
        $products_res = mysqli_query($mysqli, $products_sql)
            or die(mysqli_error($mysqli));


        while ($product_info = mysqli_fetch_array($products_res)) {
            $productQty = $product_info['productsQty'];
            $sel_Qty = $product_info['sel_productQty'];
            $productId = $product_info['productId'];
            $stockQty = $productQty - $sel_Qty;

            $updateproducts_sql = "UPDATE products
            SET productsQty = '" . $stockQty . "'
            WHERE productId = $productId;
            ";
            $updateproducts_res = mysqli_query($mysqli, $updateproducts_sql)
                or die(mysqli_error($mysqli));
        }
        $emptycart_sql = "DELETE FROM shoppertrack 
            WHERE sessionId = '" . $_COOKIE['PHPSESSID'] . "'";
        $emptycart_res = mysqli_query($mysqli, $emptycart_sql)
            or die;
    } else {
        echo "Error: " . $saveorder_sql . "<br>" . mysqli_error($mysqli);
    }
    header("Location: \RetroRecords/src/php/cart/farewell.php?ok=1&id=" . $ordersId);
} else {
    echo "ERROR";
}
// free result
mysqli_free_result($get_cart_res);
// mysqli_free_result($products_res);

mysqli_close($mysqli);
?>