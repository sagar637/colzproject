<?php
ob_start();
include 'connection.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer classes with correct paths
require 'C:/xampp/htdocs/Online-Grocery-Store-Using-PHP/GardenRoots/PHPMailer/src/Exception.php';
require 'C:/xampp/htdocs/Online-Grocery-Store-Using-PHP/GardenRoots/PHPMailer/src/PHPMailer.php';
require 'C:/xampp/htdocs/Online-Grocery-Store-Using-PHP/GardenRoots/PHPMailer/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];

    // Step 1: Send OTP
    if ($action == 'send_otp') {
        $email = $_POST['email'];

        // Check if the email exists
        $checkEmail = "SELECT * FROM `users` WHERE `email`='$email'";
        $result = $mysqli->query($checkEmail);

        if (mysqli_num_rows($result) == 1) {
            // Generate OTP
            $otp = random_int(100000, 999999);

            // Set OTP expiration time (10 minutes)
            $otp_expiration = date("Y-m-d H:i:s", strtotime('+10 minutes'));

            // Update the user with OTP and expiration
            $updateOtp = "UPDATE `users` SET `otp`='$otp', `otp_expiration`='$otp_expiration' WHERE `email`='$email'";
            $mysqli->query($updateOtp);

            // Send OTP via email using PHPMailer
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP(); // Set mailer to use SMTP
                $mail->CharSet = "utf-8"; // Set charset to utf8
                $mail->SMTPAuth = true; // Enable SMTP authentication
                $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
                $mail->Host = 'smtp.gmail.com'; // Specify main and backup SMTP servers
                $mail->Port = 587; // TCP port to connect to
                $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );
                $mail->isHTML(true); // Set email format to HTML

                // SMTP credentials
                $mail->Username = 'shivarajsedhai77@gmail.com'; // SMTP username
                $mail->Password = 'hght lvdo zeur irdw'; // SMTP password

                // Email content
                $mail->setFrom('shivarajsedhai77@gmail.com', 'Sona Shrestha');
                $mail->Subject = 'Your OTP Code';
                $mail->Body = "Your OTP code is $otp";
                $mail->addAddress($email);

                // Enable SMTP debugging
                // $mail->SMTPDebug = 2;

                $mail->send();
                echo "An OTP has been sent to your email.";
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            echo "No account found with this email.";
        }

    // Step 2: Verify OTP
    } else if ($action == 'verify_otp') {
        $otp = $_POST['otp'];

        // Check if the OTP is valid and not expired
        $checkOtp = "SELECT * FROM `users` WHERE `otp`='$otp'";
        $result = $mysqli->query($checkOtp);

        if (mysqli_num_rows($result) == 1) {
            echo "verified";
        } else {
            echo "Invalid or expired OTP.";
        }

    // Step 3: Reset Password
    } else if ($action == 'reset_password') {
        $new_password = $_POST['new_password'];
        $email = $_POST['email']; // Ensure email is passed in the form

        // Hash the new password for security
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

        // Update password in the database
        $updatePassword = "UPDATE `users` SET `password`='$hashed_password', `otp`=NULL, `otp_expiration`=NULL WHERE `email`='$email'";
        if ($mysqli->query($updatePassword)) {
            header("Location: http://localhost/Online-Grocery-Store-Using-PHP/GardenRoots/index.php");
            exit();
        } else {
            echo "Failed to reset password.";
        }
    }
}

$mysqli->close();
ob_end_flush(); 
?>
