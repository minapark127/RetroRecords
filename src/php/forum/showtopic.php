<?php
include 'include.php';
doDB();
//check for required info from the query string
if (!isset($_GET['topicId'])) {
    header("Location: showCategory.php");
    exit;
}
$safe_topicId = mysqli_real_escape_string($mysqli, $_GET['topicId']);
// $safe_categoryId = mysqli_real_escape_string($mysqli, $_GET['categoryId']);
$verify_topic_sql = "SELECT topicTitle, categoryId FROM topics
WHERE topicId = '" . $safe_topicId . "'";
$verify_topic_res = mysqli_query($mysqli, $verify_topic_sql)
    or die(mysqli_error($mysqli));
if (mysqli_num_rows($verify_topic_res) < 1) {
    //this topic does not exist
    $display_block = "<p><em>You have selected an invalid topic.<br/>
        Please <a href=\"showCategory.php\">try again</a>.</em></p>";
} else {
    //get the topic title
    while ($topicInfo = mysqli_fetch_array($verify_topic_res)) {
        $topicTitle = stripslashes($topicInfo['topicTitle']);
        $categoryId = stripslashes($topicInfo['categoryId']);
    }
    //gather the posts
    $get_posts_sql = "SELECT postId, postText,
        DATE_FORMAT(postTime,
        '%e %b %Y %r') AS fmt_postTime, postOwner
        FROM posts
        WHERE topicId = '" . $safe_topicId . "'
        ORDER BY postTime ASC";
    $get_posts_res = mysqli_query($mysqli, $get_posts_sql)
        or die(mysqli_error($mysqli));
    //create the display string
    $display_block = <<<END_OF_TEXT
        <h3>Showing posts for the topic - $topicTitle </h3>
        <table>
            <tr>
                <th>POST</th>
                <th>AUTHOR</th>
            </tr>
        END_OF_TEXT;
    while ($postsInfo = mysqli_fetch_array($get_posts_res)) {
        $postId = $postsInfo['postId'];
        $postText = nl2br(stripslashes($postsInfo['postText']));
        $postTime = $postsInfo['fmt_postTime'];
        $postOwner = stripslashes($postsInfo['postOwner']);
        //add to display
        $display_block .= <<<END_OF_TEXT
            <tr>
                <td>
                    <h2>RE: $topicTitle</h2>
                    <p>$postText</p>
                    <button>
                    <a href="replytopost.php?postId=$postId">
                        <i class="fas fa-reply"></i>&nbspREPLY TO POST
                    </a>
                    </button>
                </td>
                <td>
                    <p>Created by:<br/>
                    $postOwner</p>
                    <p>Created on:<br/>$postTime</p>
                </td>
            </tr>
    END_OF_TEXT;
    }
    mysqli_free_result($get_posts_res);
    mysqli_free_result($verify_topic_res);
    //close connection to MySQL
    mysqli_close($mysqli);
    //close up the table
    $display_block .= "</table>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="\RetroRecords/dist/css/styles.css" />
    <script src="https://kit.fontawesome.com/e6fa96586c.js"></script>
    <title><?php echo $topicTitle; ?> - Retro Records Newtown</title>
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
        <main class="php-showtopic">
            <h2><i class="far fa-comments"></i>&nbspForum</h2>

            <?php echo $display_block; ?>

            <div class="forum-showcategory-btn">
                <button>
                    <a href="index.php">
                        <i class="fas fa-list-ul"></i>
                        See category list
                    </a>
                </button>
                <button>
                    <a href="<?php echo 'showCategory.php?categoryId=' . $categoryId; ?>">
                        <i class="fas fa-caret-square-left"></i>
                        Go back to topic list
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