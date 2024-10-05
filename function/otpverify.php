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
        $checkEmail = "SELECT * FROM `users` WHERE `email`=?";
        $stmt = $mysqli->prepare($checkEmail);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            // Generate OTP
            $otp = random_int(100000, 999999);

            // Set OTP expiration time (10 minutes)
            $otp_expiration = date("Y-m-d H:i:s", strtotime('+10 minutes'));

            // Update the user with OTP and expiration
            $updateOtp = "UPDATE `users` SET `otp`=?, `otp_expiration`=? WHERE `email`=?";
            $stmt = $mysqli->prepare($updateOtp);
            $stmt->bind_param("sss", $otp, $otp_expiration, $email);
            $stmt->execute();

            // Send OTP via email using PHPMailer
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->CharSet = "utf-8";
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = 'tls';
                $mail->Host = 'smtp.gmail.com';
                $mail->Port = 587;
                $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );
                $mail->isHTML(true);

                // SMTP credentials
                $mail->Username = 'shivarajsedhai77@gmail.com'; // SMTP username
                $mail->Password = 'hght lvdo zeur irdw'; // SMTP password

                // Email content
                $mail->setFrom('shivarajsedhai77@gmail.com', 'Sona Shrestha');
                $mail->Subject = 'Your OTP Code';
                $mail->Body = "Your OTP code is $otp";
                $mail->addAddress($email);

                $mail->send();
                echo "An OTP has been sent to your email.";
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            echo "No account found with this email.";
        }
    }

    // Step 2: Verify OTP
    else if ($action == 'verify_otp') {
        $otp = $_POST['otp'];
        $email = $_POST['email']; // Ensure email is passed in the form

        // Check if the OTP is valid and not expired
        $checkOtp = "SELECT * FROM `users` WHERE `otp`=? AND `email`=?";
        $stmt = $mysqli->prepare($checkOtp);
        $stmt->bind_param("ss", $otp, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            // OTP verified successfully, respond with success
            echo 'verified';
        } else {
            echo "Invalid or expired OTP.";
        }
    }

    // Step 3: Reset Password
    else if ($action == 'reset_password') {
        $new_password = $_POST['new_password'];
        $email = $_POST['email']; 
    
        echo "New Password for Reset: " . htmlspecialchars($new_password) . "<br>";
        echo "Email for Reset: " . htmlspecialchars($email) . "<br>";
    
        // Hash the new password for security using PASSWORD_DEFAULT
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        echo "Hashed New Password: " . htmlspecialchars($hashed_password) . "<br>";
    
        // Update password in the database
        $updatePassword = "UPDATE `users` SET `password`=?, `otp`=NULL, `otp_expiration`=NULL WHERE `email`=?";
        $stmt = $mysqli->prepare($updatePassword);
        
        if (!$stmt) {
            echo 'Prepare failed: (' . $mysqli->errno . ') ' . $mysqli->error;
            exit();
        }
    
        $stmt->bind_param("ss", $hashed_password, $email);
        
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Password reset successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to reset password. Error: ' . $stmt->error]);
        }
        exit();
    }
    
}

$mysqli->close();
ob_end_flush();
?>