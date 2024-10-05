<?php

include 'connection.php';

// Custom hash function
function custom_hash($password)
{
    $salt = '123asaaks@#$';
    $hashed = '';
    for ($i = 0; $i < strlen($password); $i++) {
        $hashed .= dechex(ord($password[$i]) + ord($salt[$i % strlen($salt)]));
    }
    return $hashed;
}

$user = $_POST['username'];
$pass = custom_hash($_POST['password']);
$op = $_POST['op'];

// Prepare a statement to avoid SQL injection
$stmt = $mysqli->prepare("SELECT * FROM `users` WHERE `username` = ?");
$stmt->bind_param("s", $user);
$stmt->execute();
$checkLoginResult = $stmt->get_result();

if ($op == 'login') {
    $stmt = $mysqli->prepare("SELECT * FROM `users` WHERE `username` = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $checkLoginResult = $stmt->get_result();
    
    // Debugging: Check what username is being searched
    echo "Username: " . $user . "<br>";
    
    // Debugging: Check if the query returned any rows
    echo "Number of rows returned: " . $checkLoginResult->num_rows . "<br>";
    
    if ($checkLoginResult->num_rows == 1) {
        $row = $checkLoginResult->fetch_assoc(); // Fetch the user's data
        echo "Hash from database: " . $row['password'] . "<br>"; // Debugging
        
        // Verify the entered password with the hashed password from the database
        if (password_verify($pass, $row['password'])) { 
            echo "Entered password: " . $pass . "<br>"; // Debugging
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
            exit();
        } else {
            // Password is incorrect
            $_SESSION['login'] = 'on';
            echo '<script type="text/javascript">alert("Incorrect password."); history.back();</script>';
            exit();
        }
    } else {
        // Username not found
        $_SESSION['login'] = 'on';
        echo '<script type="text/javascript">alert("Incorrect username."); history.back();</script>';
        exit();
    }
    
} else if ($op == 'register') {
    // Registration logic
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Check if the username already exists
    $stmt = $mysqli->prepare("SELECT * FROM `users` WHERE `username` = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $checkRegisterResult = $stmt->get_result();

    if ($checkRegisterResult->num_rows == 1) {
        // Username already exists
        $_SESSION['register'] = 'on';
        echo '<script type="text/javascript">alert("Username already exists."); history.back();</script>';
    } else {
        // Use PHP's built-in password hashing function
        $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);  // Replace custom hash

        // Insert new user into the database with hashed password
        $register = "INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `phone`, `profile_pic`, `add1`, `add2`, `add3`) 
                     VALUES (NULL, ?, ?, ?, ?, 'default.png', NULL, NULL, NULL)";
        $stmt = $mysqli->prepare($register);

        if (!$stmt) {
            echo 'Prepare failed: (' . $mysqli->errno . ') ' . $mysqli->error;
            exit();
        }

        $stmt->bind_param("ssss", $user, $hashedPassword, $email, $phone);
        $registerResult = $stmt->execute();

        if ($registerResult) {
            $idRegister = "SELECT * FROM `users` WHERE `username` = ?";
            $stmt = $mysqli->prepare($idRegister);
            $stmt->bind_param("s", $user);
            $stmt->execute();
            $idRegisterResult = $stmt->get_result();

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
            header('Location: ../index.php');
        } else {
            echo '<script type="text/javascript">alert("Registration failed: ' . $stmt->error . '"); history.back();</script>';
            exit();
        }
    }
}


$mysqli->close();
?>