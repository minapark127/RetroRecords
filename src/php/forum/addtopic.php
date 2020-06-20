<?php
include 'include.php';
doDB();
if ((!$_POST['topicOwner']) || (!$_POST['topicTitle']) ||
    (!$_POST['postText']) || (!$_POST['categoryId'])
) {
    header("Location: addtopic.html");
    exit;
}
$clean_topicOwner = mysqli_real_escape_string(
    $mysqli,
    $_POST['topicOwner']
);
$clean_topicTitle = mysqli_real_escape_string(
    $mysqli,
    $_POST['topicTitle']
);
$clean_postText = mysqli_real_escape_string(
    $mysqli,
    $_POST['postText']
);

$clean_categoryId = mysqli_real_escape_string(
    $mysqli,
    $_POST['categoryId']
);

// create and issue the first query
$add_topic_sql = "INSERT INTO topics
(topicTitle, topicTime, topicOwner, categoryId)
VALUES ('" . $clean_topicTitle . "', now(),
'" . $clean_topicOwner . "', '" . $clean_categoryId . "')";
$add_topic_res = mysqli_query($mysqli, $add_topic_sql)
    or die(mysqli_error($mysqli));
//get the id of the last query
$topicId = mysqli_insert_id($mysqli);
//create and issue the second query
$add_post_sql = "INSERT INTO posts
    (topicId, postText, postTime, postOwner)
    VALUES ('" . $topicId . "', '" . $clean_postText . "',
    now(), '" . $clean_topicOwner . "')";
$add_post_res = mysqli_query($mysqli, $add_post_sql)
    or die(mysqli_error($mysqli));
//close connection to MySQL
mysqli_close($mysqli);
//create nice message for user
// $display_block = "<p>The <strong>" . $_POST["topic_title"] . "</strong>
// topic has been created.</p>";
// header("Location: topiclist.php");
header("Location: showCategory.php?categoryId=$clean_categoryId");

exit;
