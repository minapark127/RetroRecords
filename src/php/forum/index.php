<?php
include 'include.php';
doDB();

$getCategories_sql = "SELECT categoryId, categoryTitle, categoryDesc
 FROM categories ORDER BY categoryId";
$getCategories_res = mysqli_query($mysqli, $getCategories_sql)
  or die(mysqli_error($mysqli));
if (mysqli_num_rows($getCategories_res) < 1) {
  //there are no topics, so say so
  $display_block = "'<p><em>No topics exist.</em></p>'";
} else {
  //create the display string
  $display_block = <<<END_OF_TEXT
    <table>
      <tr>
        <th>Categories</th>
        <th>Number of Topics</th> 
      </tr>
END_OF_TEXT;
  while ($categoriesInfo = mysqli_fetch_array($getCategories_res)) {
    $categoryId = $categoriesInfo['categoryId'];
    $categoryTitle = stripslashes($categoriesInfo['categoryTitle']);
    $categoryDesc = stripslashes($categoriesInfo['categoryDesc']);
    //get number of topics
    $getNumberTopic_sql = "SELECT COUNT(topicId) AS topicCount FROM
topics WHERE categoryId = '" . $categoryId . "'";
    $getNumberTopic_res = mysqli_query($mysqli, $getNumberTopic_sql)
      or die(mysqli_error($mysqli));
    while ($categoriesInfo = mysqli_fetch_array($getNumberTopic_res)) {
      $num_topics = $categoriesInfo['topicCount'];
    }
    //add to display
    $display_block .= <<<END_OF_TEXT
      <tr>
        <td>
          <h2><a href="showCategory.php?categoryId=$categoryId">
          ‣$categoryTitle</a>
          </h2>
          <h3>$categoryDesc</h3>
        </td>
        <td>$num_topics</td>
      </tr>
END_OF_TEXT;
  }
  //free results
  mysqli_free_result($getCategories_res);
  mysqli_free_result($getNumberTopic_res);
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
  <script>
    function getVote(int) {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("poll").innerHTML = this.responseText;
        }
      };
      xmlhttp.open("GET", "/RetroRecords/src/ajax/poll_vote.php?vote=" + int, true);
      xmlhttp.send();
    }
  </script>
  <title>Forum - Retro Records Newtown</title>
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
    <main class="php-forum">

      <div id="poll" class="callout">
        <div class="callout-header">Quick survey</div>
        <span class="closebtn">ⓧ</span>
        <div class=" callout-container">
          <h3>
            What do you think about newsletter service?
          </h3>
          <form>
            • Love it 👍:&nbsp
            <input type="radio" name="vote" value="0" onclick="getVote(this.value)" /><br />
            • Hate it 👎:&nbsp
            <input type="radio" name="vote" value="1" onclick="getVote(this.value)" />
          </form>
        </div>
      </div>


      <div class="forum-card">
        <h2>forum</h2>
        <h3>Welcome to Retro Records Forum</h3>
        <p>Endless conversations</p>
        <p>Post, comment, share your thoughts</p>
      </div>
      <div class="forum-table">
        <?php echo $display_block; ?>
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
  <script>
    const closebtn = document.querySelector(".closebtn");

    function calloutAdd() {
      closebtn.parentNode.classList.add("callout-hide");
    }
    closebtn.addEventListener("click", calloutAdd);
  </script>
  <script src="\RetroRecords/src/js/mobileMenu.js"></script>
</body>

</html>