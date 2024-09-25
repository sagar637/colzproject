<?php
include 'connection.php';

$user_id = $_SESSION['user_id'];
$address = $_POST['address'];
$number = $_POST['number'];

$_SESSION['accountAddress'] = 'on';

$addressSet = "UPDATE `users` SET `$number` = '$address' WHERE `user_id` = '$user_id';";
$addressSetResult = $mysqli->query($addressSet);
$mysqli->close();
echo '<script type="text/JavaScript"> history.back();</script>';
?>