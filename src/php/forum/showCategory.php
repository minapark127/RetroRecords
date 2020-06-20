<?php
include 'include.php';
doDB();
//check for required info from the query string
if (!isset($_GET['categoryId'])) {
    header("Location: index.php");
    exit;
}
//create safe values for use
$safe_categoryId = mysqli_real_escape_string($mysqli, $_GET['categoryId']);
//verify the category exists
$verify_category_sql = "SELECT categoryTitle FROM categories
WHERE categoryId = '" . $safe_categoryId . "'";
$verify_category_res = mysqli_query($mysqli, $verify_category_sql)
    or die(mysqli_error($mysqli));
if (mysqli_num_rows($verify_category_res) < 1) {
    //this category does not exist
    $display_block = "<p><em>You have selected an invalid topic.<br/>
    Please <a href=\"index.php\">try again</a>.</em></p>";
} else {
    //get the category title
    while ($categoriesInfo = mysqli_fetch_array($verify_category_res)) {
        $categoryTitle = stripslashes($categoriesInfo['categoryTitle']);
    }
    //gather the topics
    $getTopic_sql = "SELECT topicId, topicTitle, topicOwner,
    DATE_FORMAT(topicTime, '%e %b %Y %r') AS fmt_topicTime
    FROM topics WHERE categoryId = '" . $safe_categoryId . "'
     ORDER BY topicId";
    $getTopic_res = mysqli_query($mysqli, $getTopic_sql)
        or die(mysqli_error($mysqli));
    //create the display string
    $display_block = <<<END_OF_TEXT
    <div class="forum-showcategory-info">
        <h2><i class="fas fa-compact-disc"></i>&nbsp$categoryTitle</h2>
        <h3>Showing topics for the $categoryTitle </h3>
    </div>
    <table>
        <tr>
        <th>Topics</th>
        <th>Number of Comments</th>
        </tr>
    END_OF_TEXT;
    while ($topicsInfo = mysqli_fetch_array($getTopic_res)) {
        $topicId = $topicsInfo['topicId'];
        $topicTitle = nl2br(stripslashes($topicsInfo['topicTitle']));
        $topicTime = $topicsInfo['fmt_topicTime'];
        $topicOwner = stripslashes($topicsInfo['topicOwner']);
        //get number of topics
        $get_num_posts_sql = "SELECT COUNT(postId) AS post_count FROM
         posts WHERE topicId = '" . $topicId . "'";
        $get_num_posts_res = mysqli_query($mysqli, $get_num_posts_sql)
            or die(mysqli_error($mysqli));
        while ($postInfo = mysqli_fetch_array($get_num_posts_res)) {
            $num_posts = $postInfo['post_count'];
        }
        //add to display
        $display_block .= <<<END_OF_TEXT
        <tr>
        <td>
            <h2><a href="showtopic.php?topicId=$topicId">
            •$topicTitle</a></h2>
            <p>Created on:<br/>$topicTime</p>
            <p>Created by:<br/>$topicOwner</p>
        </td>
        <td>$num_posts</td>
        </tr>
END_OF_TEXT;
    }
    //free results
    mysqli_free_result($getTopic_res);
    mysqli_free_result($verify_category_res);
    //close connection to MySQL
    mysqli_close($mysqli);
    //close up the table
    $display_block .= "</table>";
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="\RetroRecords/dist/css/styles.css" />
    <script src="https://kit.fontawesome.com/e6fa96586c.js"></script>
    <title><?php echo $categoryTitle; ?> - Retro Records Newtown</title>
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
                <li><a href="\RetroRecords/src/php/cart/seestore.php?categoryId=1">Shop</a></li>
                <li id="currentPage"><a href="\RetroRecords/src/php/forum/index.php">Forum</a></li>
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

        <main class="php-forum-showcategory">
            <?php echo $display_block; ?>
            <div class="forum-showcategory-btn">
                <button class="forum-btn-add">
                    <a href="addtopic.html">
                        <i class="fas fa-plus-square"></i>
                        Add topic
                    </a>
                </button>
                <button class="forum-btn-back">
                    <a href="\RetroRecords/src/php/forum/index.php">
                        <i class="fas fa-caret-square-left"></i>
                        Go Back to Category list
                    </a>
                </button>
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