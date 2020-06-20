<?php
session_start();
//connect to db
$mysqli = mysqli_connect('localhost', 'root', '000000', 'cart_test');

$display_block = '';

//create safe values for use
$safe_productId = mysqli_real_escape_string($mysqli, $_GET["productId"]);

//validate product
$get_product_sql = 'SELECT c.categoryId as categoryId, c.categoryTitle, p.productTitle,
                    p.productPrice, p.productDesc, p.productImg FROM products
                    AS p LEFT JOIN categories AS c on c.categoryId = p.categoryId
                    WHERE p.productId = "' . $safe_productId . '"';

$get_product_res = mysqli_query($mysqli, $get_product_sql)
    or die(mysqli_error($mysqli));

if (mysqli_num_rows($get_product_res) < 1) {
    //invalid product
    $display_block .= "<p><em>Invalid product selection.</em></p>";
} else { //valid product, get info
    while ($productInfo = mysqli_fetch_array($get_product_res)) {
        $categoryId = $productInfo['categoryId'];
        $categoryTitle = strtoupper(stripslashes($productInfo['categoryTitle']));
        $productTitle = stripslashes($productInfo['productTitle']);
        $productPrice = $productInfo['productPrice'];
        $productDesc = stripslashes($productInfo['productDesc']);
        $productImg = $productInfo['productImg'];
    }

    //make breadcrumb trail & display of item
    $display_block .= <<<END_OF_TEXT
    <div class="showproduct-viewing">
    <div>
        <h1><i class="fas fa-gifts"></i>&nbspProduct Detail</h1>
        <span>Current product</span>
        <p>►<a href="seestore.php?categoryId=$categoryId"><span>$categoryTitle</span></a> &gt;
            $productTitle</p>
            </div>
            <a href="showcart.php"><button><i class="fas fa-shopping-cart"></i>&nbspView Cart</button></a>
    </div>
    <div class="showproduct-product">
        <img class="showproduct-product-img" src="\RetroRecords/src/images/$productImg" alt="$productTitle"/>
        <div class="showproduct-product-info">
            <h2>$productTitle</h2>
            <p>Description: <span>$productDesc</span></p>
            
            <p>Price: \$$productPrice</p>
            <form method="post" action="addtocart.php">
 END_OF_TEXT;

    // //free result
    // mysqli_free_result($get_product_res);
    $display_block .= "
            <p><label for=\"sel_productQty\">Select Quantity: </label>
            <select id=\"sel_productQty\" name=\"sel_productQty\">";

    for ($i = 1; $i < 11; $i++) {
        $display_block .= "<option value=\"" . $i . "\">" . $i . "</option>";
    }

    $display_block .= <<<END_OF_TEXT
            </select></p>
            <input type="hidden" name="sel_productId" value="$_GET[productId]"/>
            <button type="submit" name="submit" value="submit">
                Add to Cart</button>
            </form>
        </div>
    </div>
    <p class="back"><a href="seestore.php?categoryId=$categoryId">🔙&nbspBack to categories</a></p>
    END_OF_TEXT;

    //free result
    mysqli_free_result($get_product_res);
}
//close conn
mysqli_close($mysqli);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="\RetroRecords/dist/css/styles.css" />
    <script src="https://kit.fontawesome.com/e6fa96586c.js"></script>
    <title>Product Detail - Retro Records Newtown</title>
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
        <main class="php-showproduct">
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