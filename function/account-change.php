<?php
include 'connection.php';

$user_id = $_SESSION['user_id'];
$passcheck = $_POST['passcheck'];
$comma = true;
$check = "SELECT * FROM `users` WHERE `user_id` = '$user_id' and `password` = '$passcheck'";
$checkResult = $mysqli->query($check);
$_SESSION['accountUpdate'] = 'on';

if(mysqli_num_rows($checkResult) == 1){
    $update = "UPDATE `users` SET";

    if($_POST['username']!=''){
        $username = $_POST['username'];
        $checkUsername = "SELECT * FROM `users` WHERE `username`='$username'";
        $checkUsernameResult = $mysqli->query($checkUsername);
        if(mysqli_num_rows($checkUsernameResult) == 1){
            $_SESSION['updateUsernameSame'] = 'on';
            echo '<script type="text/JavaScript">history.back();</script>';
        }

        if($comma){
            $update.=" `username`= '$username'";
        }
        else{
            $update.=" , `username`= '$username'";
        }
        $comma = false;
    }
    if($_POST['pass']!=''){
        $pass = $_POST['pass'];
        if($comma){
            $update.=" `password`= '$pass'";
        }
        else{
            $update.=" , `password`= '$pass'";
        }
        $comma = false;
    }
    if($_POST['email']!=''){
        $email = $_POST['email'];
        $checkEmail = "SELECT * FROM `users` WHERE `email`='$email'";
        $checkEmailResult = $mysqli->query($checkEmail);
        if(mysqli_num_rows($checkEmailResult) == 1){
            $_SESSION['updateEmailSame'] = 'on';
            echo '<script type="text/JavaScript">history.back();</script>';
        }

        if($comma){
            $update.=" `email`= '$email'";
        }
        else{
            $update.=" , `email`= '$email'";
        }
        $comma = false;
    }
    if($_POST['phone']!=''){
        $phone = $_POST['phone'];
        if($comma){
            $update.=" `phone`= '$phone'";
        }
        else{
            $update.=" , `phone`= '$phone'";
        }
        $comma = false;

    }
    if($_FILES['profile']['name']!=''){
        $profile = $_FILES['profile']['name'];
        if($comma){
            $update.=" `profile_pic`= '$profile'";
        }
        else{
            $update.=" , `profile_pic`= '$profile'";
        }
        $comma = false;
    }
    $update.=" WHERE `user_id`='$user_id';";
    if($update=="UPDATE `users` SET WHERE `user_id`='$user_id';"){
        $_SESSION['updateFieldsEmpty'] = 'on';
        echo '<script type="text/JavaScript">history.back();</script>';
    }
    else{
        $updateResult = $mysqli->query($update);
        echo '<script type="text/JavaScript">history.back();</script>';
    }
}
else{
    $_SESSION['updatePassWrong'] = 'on';
    echo '<script type="text/JavaScript">history.back();</script>';
}
$mysqli->close();
?>