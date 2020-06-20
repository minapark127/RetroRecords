<?php
session_start();

if (isset($_POST["submit"])) {
    //connect to database
    $mysqli = mysqli_connect("localhost", "root", "000000", "cart_test");
    //create safe values for use
    // $safe_trackId = mysqli_real_escape_string(
    //     $mysqli,
    //     $_POST["trackId"]
    // );

    $display_block = "";

    //check for cart products based on user session id
    $get_cart_sql = "SELECT st.trackId, p.productTitle, p.productPrice,
                    st.sel_productQty 
                    FROM shoppertrack AS st LEFT JOIN products AS p ON p.productId = st.sel_productId 
                    WHERE sessionId = '" . $_COOKIE['PHPSESSID'] . "'";

    $get_cart_res = mysqli_query($mysqli, $get_cart_sql)
        or die(mysqli_error($mysqli));
    $display_block .= <<<END_OF_TEXT
    <div class="checkout-info">
    <h1><i class="far fa-credit-card"></i>&nbspCheckout</h1>
    <div class="checkout-table">
        <table>
        <caption>Your Orders</caption>
        <tr>
            <th>Title</th>
            <th>Price</th>
            <th>Qty</th>
            <th>Total Price</th>
            
        </tr>
    END_OF_TEXT;

    $sum_arr = array();
    while ($cart_info = mysqli_fetch_array($get_cart_res)) {
        $trackId = $cart_info['trackId'];
        $productTitle = stripslashes($cart_info['productTitle']);
        $productPrice = $cart_info['productPrice'];
        $productQty = $cart_info['sel_productQty'];
        $total_price = sprintf("%.02f", $productPrice * $productQty);

        array_push($sum_arr, $productPrice * $productQty);
        $display_block .= <<<END_OF_TEXT
            <tr>
            <td>$productTitle <br></td>
            <td>\$ $productPrice <br></td>
            <td>$productQty <br></td>
            <td>\$ $total_price</td>
            
    </tr>
    
    END_OF_TEXT;
    }
    $sum_total = sprintf("%.02f", array_sum($sum_arr));
    $display_block .= "
    <tr class=\"noborder\">
    <th colspan=\"3\">total</th>
    <th colspan=\"1\">$" . $sum_total . "</th>
    <tr>
    </table>
    <div class=\"checkout-btn\">
        <a href=\"showcart.php\"><button>Go back to Cart</button></a>
        <a href=\"seestore.php\"><button>Continue shopping</button></a>
    </div>
    </div>
    </div>
    
    <h2><i class=\"fas fa-user-edit\"></i>&nbspYour detail</h2>
    <div class=\"checkout-grid\">
    <figure></figure>
    <div class=\"checkout-grid-form\">
    <form method=\"post\" action=\"saveorderdetail.php\">
        <h3>Order Detail</h3>
        <label for=\"orderName\">Name: </label>
        <input type=\"text\" id=\"orderName\" name=\"orderName\" required><br>
        <label for=\"orderAddress\">Address: </label>
        <input type=\"text\" id=\"orderAddress\" name=\"orderAddress\" required><br>
        <label for=\"orderCity\">Suburb: </label>
        <input type=\"text\" id=\"orderCity\" name=\"orderCity\" required><br>
        <label for=\"orderState\">State: </label>
        <input type=\"text\" id=\"orderState\" name=\"orderState\" required><br>
        <label for=\"orderPostcode\">Postcode: </label>
        <input type=\"text\" id=\"orderPostcode\" name=\"orderPostcode\" required><br>
        <label for=\"orderTel\">mobile: </label>
        <input type=\"text\" id=\"orderTel\" name=\"orderTel\" required><br>
        <label for=\"orderEmail\">email: </label>
        <input type=\"text\" id=\"orderEmail\" name=\"orderEmail\" required><br>
        <input type=\"hidden\" name=\"productTotal\" value=\"" . $sum_total . "\">
        <button type=\"submit\" name=\"submit\" value=\"submit\">submit</button>
        </form>
    </div>
    </div>
    ";
}
//free result
mysqli_free_result($get_cart_res);

//close conn to MySQL
mysqli_close($mysqli);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="\RetroRecords/dist/css/styles.css" />
    <script src="https://kit.fontawesome.com/e6fa96586c.js"></script>
    <title>Checkout - Retro Records Newtown</title>
</head>

<body>
    <div id="wrapper">
        <header>
            <div class="header__logo">
                <a href="\RetroRecords/index.html">
                    <h2>⏂</h2>
                    <h1>Retro<br />Records<br />Newtown</h1>
                </a>
            </div>

            <ul class="header__nav">
                <li><a href="\RetroRecords/index.html">Home</a></li>
                <li><a href="\RetroRecords/retro.html">Retro Records</a></li>
                <li><a href="\RetroRecords/rare.html">Rare LPs</a></li>
                <li id="currentPage"><a href="\RetroRecords/src/php/cart/seestore.php?categoryId=1">Shop</a></li>
                <li><a href="\RetroRecords/src/php/forum/index.php">Forum</a></li>
                <li><a href="\RetroRecords/contact.html">Contact Us</a></li>
            </ul>

            <div class="header__nav__mobile">
                <div class="dropdown">
                    <button class="dropbtn">
                        <i class="fas fa-bars"></i>
                    </button>

                    <ul class="dropdown-content">
                        <li><a href="\RetroRecords/index.html">Home</a></li>
                        <li><a href="\RetroRecords/retro.html">Retro Records</a></li>
                        <li><a href="\RetroRecords/rare.html">Rare LPs</a></li>
                        <li><a href="\RetroRecords/src/php/cart/seestore.php?categoryId=1">Shop</a></li>
                        <li><a href="\RetroRecords/src/php/forum/index.php">Forum</a></li>
                        <li><a href="\RetroRecords/contact.html">Contact Us</a></li>
                    </ul>
                </div>
            </div>
        </header>
        <main class="php-checkout">
            <?php echo $display_block; ?>
        </main>
    </div>
    <footer>
        <ul>
            <li class="footer__title">support</li>
            <li>&copy; All rights reserved 2020</li>
            <li><a href="\RetroRecords/src/copyright.docx">legals</a></li>
        </ul>
        <ul class="footer__border">
            <li class="footer__title">Follow us at</li>
            <li>
                <a href="https://www.facebook.com/retrorecordsnewtown"><i class="fab fa-facebook"></i></a>
            </li>
            <li>
                <a href="https://www.instagram.com/retrorecordsnewtown"><i class="fab fa-instagram"></i></a>
            </li>
        </ul>
        <ul>
            <li><a href="\RetroRecords/index.html">⏂</a></li>
            <li class="footer__title">
                <a href="\RetroRecords/index.html">Retro Records Newtown</a>
            </li>
            <li>
                <a href="https://www.google.com/maps?ll=-33.896321,151.179809&z=19&t=m&hl=en&gl=AU&mapclient=embed&q=283+King+St+Newtown+NSW+2042">282 King St. Newtown NSW 2042</a>
            </li>
            <li><a href="tel:0295191234">02 9519 1234</a></li>
            <li>
                <a href="mailto:info@retrorecordsnewtown.com.au ">info@retrorecordsnewtown.com.au
                </a>
            </li>
        </ul>
    </footer>
    <script src="\RetroRecords/src/js/mobileMenu.js"></script>
</body>

</html>