<?php
include 'include.php';
doDB();
//check to see if we're showing the form or adding the post
if (!$_POST) {
    // showing the form; check for required item in query string
    if (!isset($_GET['postId'])) {
        header("Location: index.php");
        exit;
    }

    $safe_postId = mysqli_real_escape_string($mysqli, $_GET['postId']);

    $verify_sql = "SELECT topics.topicId, topics.topicTitle 
                FROM posts LEFT JOIN topics 
                ON posts.topicId = topics.topicId 
                WHERE posts.postId = $safe_postId";
    $verify_res = mysqli_query($mysqli, $verify_sql)
        or die(mysqli_error($mysqli));
    if (mysqli_num_rows($verify_res) < 1) {
        //this post or topic does not exist
        header("Location: index.php");
        exit;
    } else {
        while ($topicInfo = mysqli_fetch_array($verify_res)) {
            $topicId = $topicInfo['topicId'];
            $topicTitle = stripslashes($topicInfo['topicTitle']);
        }
?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0" />
            <link rel="stylesheet" href="\RetroRecords/dist/css/styles.css" />
            <script src="https://kit.fontawesome.com/e6fa96586c.js"></script>
            <title>Reply on - <?php echo $topicTitle; ?></title>
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

                <main class="php-replytopost">
                    <h2><i class="fas fa-envelope-open-text"></i>&nbspReply</h2>
                    <h3>Write a reply on - <?php echo $topicTitle; ?></h3>

                    <div class="replytopost-grid">
                        <form class="replytopost-grid-form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <h3>Write your reply</h3>
                            <label for="postOwner">Your Email Address:</label>
                            <p><input type="email" id="postOwner" name="postOwner" size="40" maxlength="150" required="required">
                            </p>
                            <label for="postText">Post Text:</label>
                            <p><textarea id="postText" name="postText" rows="8" cols="40" required="required"></textarea>
                            </p>

                            <input type="hidden" name="topicId" value="<?php echo $topicId; ?>">
                            <button type="submit" name="submit" value="submit">Add Post</button>
                        </form>
                        <figure></figure>
                    </div>

                    <div class="forum-showcategory-btn">
                        <button>
                            <a href="<?php echo 'showtopic.php?topicId=' . $topicId; ?>">
                                <i class="fas fa-caret-square-left"></i>
                                Go back to the post
                            </a>
                        </button>
                        <button>
                            <a href="index.php">
                                <i class="fas fa-list-ul"></i>
                                See category list
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
<?php
    }
    //free result
    mysqli_free_result($verify_res);
    //close connection to MySQL
    mysqli_close($mysqli);
} else if ($_POST) {
    //check for required items from form
    if ((!$_POST['topicId']) || (!$_POST['postText']) ||
        (!$_POST['postOwner'])
    ) {
        header("Location: showtopic.php");
        exit;
    }
    //create safe values for use
    $safe_topicId = mysqli_real_escape_string($mysqli, $_POST['topicId']);
    $safe_postText = mysqli_real_escape_string($mysqli, $_POST['postText']);
    $safe_postOwner = mysqli_real_escape_string($mysqli, $_POST['postOwner']);
    //add the post
    $add_post_sql = "INSERT INTO posts (topicId,postText,
postTime,postOwner) VALUES
('" . $safe_topicId . "', '" . $safe_postText . "',
now(),'" . $safe_postOwner . "')";
    $add_post_res = mysqli_query($mysqli, $add_post_sql)
        or die(mysqli_error($mysqli));
    //close connection to MySQL
    mysqli_close($mysqli);
    //redirect user to topic
    header("Location: showtopic.php?topicId=" . $_POST['topicId']);
    exit;
}
?>