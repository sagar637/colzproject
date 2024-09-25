<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forget Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
            width: 300px;
        }

        .container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        .form-group button {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .form-group button:hover {
            background-color: #0056b3;
        }

        .otp-section, .reset-password-section {
            display: none;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Forget Password</h2>

    <!-- Step 1: Enter Email Section -->
    <div class="form-group email-section">
        <label for="email">Enter your registered email:</label>
        <input type="email" id="email" name="email" required>
        <button id="sendOtpBtn">Send OTP</button>
    </div>

    <!-- Step 2: Enter OTP Section -->
    <div class="form-group otp-section">
        <label for="otp">Enter OTP sent to your email:</label>
        <input type="text" id="otp" name="otp" required>
        <button id="verifyOtpBtn">Verify OTP</button>
    </div>

    <!-- Step 3: Reset Password Section -->
    <div class="form-group reset-password-section">
        <label for="new_password">Enter New Password:</label>
        <input type="password" id="new_password" name="new_password" required>
        <button id="resetPasswordBtn">Reset Password</button>
    </div>
</div>

<script>
// Step 1: Send OTP
document.getElementById('sendOtpBtn').addEventListener('click', function () {
    var email = document.getElementById('email').value;

    if (email) {
        // AJAX Request to send OTP
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'otpverify.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                alert(xhr.responseText); // Show response from PHP
                document.querySelector('.email-section').style.display = 'none';
                document.querySelector('.otp-section').style.display = 'block';
            }
        };
        xhr.send('email=' + email + '&action=send_otp');
    }
});

// Step 2: Verify OTP
document.getElementById('verifyOtpBtn').addEventListener('click', function () {
    var otp = document.getElementById('otp').value;

    if (otp) {
        // AJAX Request to verify OTP
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'otpverify.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                if (xhr.responseText == 'verified') {
                    alert('OTP verified successfully!');
                    document.querySelector('.otp-section').style.display = 'none';
                    document.querySelector('.reset-password-section').style.display = 'block';
                } else {
                    alert('Invalid OTP. Please try again.');
                }
            }
        };
        xhr.send('otp=' + otp + '&action=verify_otp');
    }
});

// Step 3: Reset Password
document.getElementById('resetPasswordBtn').addEventListener('click', function () {
    var new_password = document.getElementById('new_password').value;

    if (new_password) {
        // AJAX Request to reset password
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'otpverify.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                alert(xhr.responseText); // Show response from PHP
            }
        };
        xhr.send('new_password=' + new_password + '&action=reset_password');
    }
});
</script>

</body>
</html>
