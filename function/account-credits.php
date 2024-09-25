<?php
include 'connection.php';

$user_id = $_SESSION['user_id'];
$creditsAdd = $_SESSION['creds_value'];

$creds = "SELECT * FROM `users` WHERE `user_id`='$user_id';";
$credsResult = $mysqli->query($creds);
$credits = 0;

while($rows=$credsResult->fetch_assoc()){
    $credits = $rows['credits'] + $creditsAdd;
}

$_SESSION['accountCredits'] = 'on';
$update = "UPDATE `users` SET `credits`='$credits' WHERE `user_id`='$user_id'";
$updateResult = $mysqli->query($update);

header("Location:../account.php");
?>