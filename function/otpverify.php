<?php
include 'connection.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer classes
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
                // Server settings
                // $mail = new PHPMailer(true);
                // $mail->isSMTP();
                $mail->Host = 'localhost'; // Local SMTP server
                $mail->Port = 1025; // Default MailHog port
                // $mail->SMTPAuth = false; 
                // $mail->Username = 'sagarsedhai5@gmail.com';  // SMTP username
                // $mail->Password = '9867157782@Ss';   // SMTP password (use app-specific password for Gmail if 2FA is enabled)
                // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                // $mail->Port = 587;

                // // Recipients
                // $mail->setFrom('sagarsedhai5@gmail.com', 'Sagar Sedhai');
                // $mail->addAddress($email);  // Add recipient

                // // Content
                // $mail->isHTML(true);
                // $mail->Subject = "Your OTP Code";
                // $mail->Body = "Your OTP code is: <b>$otp</b>. This OTP is valid for 10 minutes.";

                // $mail->send();
                $mail = new PHPMailer(true);

                $mail->isSMTP();// Set mailer to use SMTP
                $mail->CharSet = "utf-8";// set charset to utf8
                $mail->SMTPAuth = true;// Enable SMTP authentication
                $mail->SMTPSecure = 'tls';// Enable TLS encryption, `ssl` also accepted

                $mail->Host = 'smtp.gmail.com';// Specify main and backup SMTP servers
                $mail->Port = 587;// TCP port to connect to
                $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );
                $mail->isHTML(true);// Set email format to HTML

                $mail->Username = 'shivarajsedhai77@gmail.com';// SMTP username
                $mail->Password = '9867157782@Ss';// SMTP password

                $mail->setFrom('shivarajsedhai77@gmail.com', 'shivarajsedhai77@gmail.com');//Your application NAME and EMAIL
                $mail->Subject = 'Test';//Message subject
                $mail->MsgHTML('HTML code');// Message body
                $mail->addAddress('sagarsedhai06@gmail.com', 'Sagar Sedhai');// Target email


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
        $checkOtp = "SELECT * FROM `users` WHERE `otp`='$otp' AND `otp_expiration` >= NOW()";
        $result = $mysqli->query($checkOtp);

        if (mysqli_num_rows($result) == 1) {
            echo "verified";
        } else {
            echo "Invalid or expired OTP.";
        }

        // Step 3: Reset Password
    } else if ($action == 'reset_password') {
        $new_password = $_POST['new_password'];

        // Hash the new password for security
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

        // Update password in the database
        $email = $_POST['email']; // Should be passed in session or retrieved securely
        $updatePassword = "UPDATE `users` SET `password`='$hashed_password', `otp`=NULL, `otp_expiration`=NULL WHERE `email`='$email'";
        if ($mysqli->query($updatePassword)) {
            echo "Password reset successfully.";
        } else {
            echo "Failed to reset password.";
        }
    }
}

$mysqli->close();
?>