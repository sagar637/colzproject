<?php
include 'connection.php';

$user = $_POST['username'];
$pass = $_POST['password'];
$op = $_POST['op'];

$checkLogin = "SELECT * FROM `users` WHERE `username`='$user';"; // Note: Removed password from query
$checkLoginResult = $mysqli->query($checkLogin);

$checkRegister = "SELECT * FROM `users` WHERE `username`='$user'";
$checkRegisterResult = $mysqli->query($checkRegister);

if ($op == 'login') {
    if (mysqli_num_rows($checkLoginResult) == 1) {
        $row = $checkLoginResult->fetch_assoc();
        // Verify the password
        if (password_verify($pass, $row['password'])) {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['orderReport'] = 'off';
            $_SESSION['trackReport'] = 'off';
            $_SESSION['accountAddress'] = 'off';
            $_SESSION['accountCredits'] = 'off';
            $_SESSION['accountTrack'] = 'off';
            $_SESSION['accountOrders'] = 'off';
            $_SESSION['accountUpdate'] = 'off';
            header('Location:../index.php');
        } else {
            $_SESSION['login'] = 'on';
            echo '<script type="text/JavaScript">history.back();</script>';
        }
    } else {
        $_SESSION['login'] = 'on';
        echo '<script type="text/JavaScript">history.back();</script>';
    }
} else if ($op == 'register') {
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    if (mysqli_num_rows($checkRegisterResult) == 1) {
        $_SESSION['register'] = 'on';
        echo '<script type="text/JavaScript">history.back();</script>';
    } else {
        // Hash the password before storing it
        $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);
        
        $register = "INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `phone`, `profile_pic`, `add1`, `add2`, `add3`) VALUES (NULL, '$user', '$hashedPassword', '$email', '$phone', 'default.png', NULL, NULL, NULL);";
        $registerResult = $mysqli->query($register);

        if ($registerResult) {
            // Fetch the newly registered user ID
            $idRegister = "SELECT * FROM `users` WHERE `username`='$user';";
            $idRegisterResult = $mysqli->query($idRegister);

            while ($rows = $idRegisterResult->fetch_assoc()) {
                $_SESSION['user_id'] = $rows['user_id'];
            }
            $_SESSION['orderReport'] = 'off';
            $_SESSION['trackReport'] = 'off';
            $_SESSION['accountAddress'] = 'off';
            $_SESSION['accountCredits'] = 'off';
            $_SESSION['accountTrack'] = 'off';
            $_SESSION['accountOrders'] = 'off';
            $_SESSION['accountUpdate'] = 'off';
            header('Location:../index.php');
        } else {
            // Handle registration error
            echo '<script type="text/JavaScript">alert("Registration failed. Please try again."); history.back();</script>';
        }
    }
}

$mysqli->close();
?>
