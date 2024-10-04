<?php
include 'connection.php';

$user = $_POST['username'];
$pass = $_POST['password'];
$op = $_POST['op'];

// Prepare a statement to avoid SQL injection
$stmt = $mysqli->prepare("SELECT * FROM `users` WHERE `username` = ?");
$stmt->bind_param("s", $user);
$stmt->execute();
$checkLoginResult = $stmt->get_result();

if ($op == 'login') {
    if ($checkLoginResult->num_rows == 1) {
        $row = $checkLoginResult->fetch_assoc(); // Fetch the user's data

        // Verify the entered password with the hashed password from the database
        if (password_verify($pass, $row['password'])) { // Compare the entered password with the hash
            // Password is correct, log the user in
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['orderReport'] = 'off';
            $_SESSION['trackReport'] = 'off';
            $_SESSION['accountAddress'] = 'off';
            $_SESSION['accountCredits'] = 'off';
            $_SESSION['accountTrack'] = 'off';
            $_SESSION['accountOrders'] = 'off';
            $_SESSION['accountUpdate'] = 'off';
            header('Location: ../index.php');
            exit(); // Ensure no further code is executed after redirection
        } else {
            // Password is incorrect
            $_SESSION['login'] = 'on';
            echo '<script type="text/javascript">alert("Incorrect password."); history.back();</script>';
            exit(); // Ensure no further code is executed after alert
        }
    } else {
        // Username not found
        $_SESSION['login'] = 'on';
        echo '<script type="text/javascript">alert("Incorrect username."); history.back();</script>';
        exit(); // Ensure no further code is executed after alert
    }

} else if ($op == 'register') {
    // Registration Logic
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    if (mysqli_num_rows($checkRegisterResult) == 1) {
        // Username already exists
        $_SESSION['register'] = 'on';
        echo '<script type="text/JavaScript">history.back();</script>';
    } else {
        // Hash the password
        $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);

        // Insert new user into database with hashed password
        $register = "INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `phone`, `profile_pic`, `add1`, `add2`, `add3`) 
                     VALUES (NULL, '$user', '$hashedPassword', '$email', '$phone', 'default.png', NULL, NULL, NULL);";
        $registerResult = $mysqli->query($register);

        if ($registerResult) {
            // Fetch the newly registered user's ID
            $idRegister = "SELECT * FROM `users` WHERE `username`='$user';";
            $idRegisterResult = $mysqli->query($idRegister);

            while ($rows = $idRegisterResult->fetch_assoc()) {
                $_SESSION['user_id'] = $rows['user_id'];
            }

            // Set session variables for the newly registered user
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
