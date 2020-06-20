<?php
//connect to db
$mysqli = mysqli_connect('localhost', 'root', '000000', 'cart_test');
$display_block = '';

//show categories first

$get_cats_sql = 'SELECT categoryId, categoryTitle, categoryDesc 
                FROM categories ORDER BY categoryId';

$get_cats_res = mysqli_query($mysqli, $get_cats_sql)
    or die(mysqli_error($mysqli));

if (mysqli_num_rows($get_cats_res) < 1) {
    $display_block = '<p><em>Sorry, no categories to browse.</em></p>';
} else {
    while ($categories = mysqli_fetch_array($get_cats_res)) {
        $categoryId  = $categories['categoryId'];
        $categoryTitle = strtoupper(stripslashes($categories['categoryTitle']));
        $categoryDesc = stripslashes($categories['categoryDesc']);


        $display_block .= "<div class=\"category-flex\">
        <h3>▪️<a href=\"" . $_SERVER['PHP_SELF'] .
            "?categoryId=" . $categoryId . "\">" . $categoryTitle . "</a></h3>
            <p>&nbsp&nbsp-"
            . $categoryDesc . "</p></div>";

        if (isset($_GET['categoryId']) && ($_GET['categoryId'] == $categoryId)) {
            //create safe value for use
            $safe_categoryId = mysqli_real_escape_string(
                $mysqli,
                $_GET['categoryId']
            );
            //get items
            $get_products_sql = "SELECT productId, productTitle, productPrice
                         FROM products 
                         WHERE categoryId = '" . $categoryId . "' ORDER BY productTitle";
            $get_products_res = mysqli_query($mysqli, $get_products_sql)
                or die(mysqli_error($mysqli));

            if (mysqli_num_rows($get_products_res) < 1) {
                $display_block = '<p><em>Sorry, no products in this category.</em></p>';
            } else {
                $display_block .= '<ul>';
                while ($products = mysqli_fetch_array($get_products_res)) {
                    $productId  = $products['productId'];
                    $productTitle = stripslashes($products['productTitle']);
                    $productPrice = $products['productPrice'];

                    $display_block .= "<li>🎵<a 
                    href=\"showproduct.php?productId=" .
                        $productId . "\">" . $productTitle . "</a>
                    -\$" . $productPrice . "</li>";
                }
                $display_block .= '</ul>';
            }
            //free result
            mysqli_free_result($get_products_res);
        }
    }
}

//free results
mysqli_free_result($get_cats_res);
//close connection to MySQL
mysqli_close($mysqli);
?>

<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="\RetroRecords/dist/css/styles.css" />
    <script src="https://kit.fontawesome.com/e6fa96586c.js"></script>
    <title>Shop - Retro Records Newtown</title>
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
        <main class="php-seestore">
            <div class="seestore-categoryInfo">
                <h2>shop</h2>
                <h3>Welcome to Retro Records Store</h3>
                <p>Select a category below to see our products</p>
                <p><a href="tel:0295191234">Call us</a> or
                    <a href="contact.html">send online message</a> for any enquiry</p>
                <a href="contact.html">
                    <div>contact us</div>
                </a>
            </div>
            <div class="seestore-categories">
                <div class="seestore-categories-info">
                    <div>
                        <h2>Categories</h2>
                        <p>👉🏻 Select a category to see our products</p>
                        <p>👉🏻 Click a product for product details</p>
                    </div>
                    <a href="showcart.php"><button><i class="fas fa-shopping-cart"></i>&nbspView Cart</button></a>
                </div>
                <div class="seestore-categories-category">
                    <div>
                        <?php echo $display_block; ?>
                    </div>
                    <section></section>
                </div>
            </div>
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