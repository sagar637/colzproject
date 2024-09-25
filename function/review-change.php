<?php
include 'connection.php';

$op = $_POST['op'];
$user_id = $_SESSION['user_id'];

if($op=='add'){ 
    $review = $_POST['reviewDesc'];
    $rating = $_POST['rating'];
    $addReview = "INSERT INTO `review` (`review_id`, `user_id`, `rating`, `review`) VALUES (NULL, '$user_id', '$rating', '$review');";
    $addReviewResult = $mysqli->query($addReview);
}
else if($op=='remove'){
    $removeReview = "DELETE FROM review WHERE `user_id` = '$user_id';";
    $removeReviewResult = $mysqli->query($removeReview);
}
$mysqli->close();
echo '<script type="text/JavaScript"> history.back();</script>';
?>