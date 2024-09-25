<?php
include 'connection.php';

$id = $_POST['id'];
$user_id = $_SESSION['user_id'];
$email = $_POST['email'];

$track = "SELECT * FROM `order` INNER JOIN `users` ON `order`.`user_id`=`users`.`user_id` WHERE `order_set`='$id' AND `users`.`user_id`='$user_id' AND `email`='$email'";
$trackResult = $mysqli->query($track);

if(mysqli_num_rows($trackResult) != 0){
    while($rows=$trackResult->fetch_assoc()){
        $_SESSION['trackReport'] = 'status of order #'.$id.' : '.$rows['status'];
    }
}
else{
    $_SESSION['trackOrderError'] = "on";
    echo '<script type="text/JavaScript">history.back();</script>';
}
$_SESSION['accountTrack'] = 'on';
echo '<script type="text/JavaScript">history.back();</script>';
$mysqli->close();
?>