<!DOCTYPE html>
<html lang="en">
<head>
    <title>Forget Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 400px;
            margin: auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }

        input[type="email"],
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }

        input[type="email"]:focus,
        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #007bff;
            outline: none;
        }

        button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 4px;
            background-color: #007bff;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        .otp-section, .reset-password-section {
            display: none; /* Hide OTP and Reset Password sections by default */
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
        xhr.send('email=' + encodeURIComponent(email) + '&action=send_otp');
    } else {
        alert("Please enter your email.");
    }
});

// Step 2: Verify OTP
document.getElementById('verifyOtpBtn').addEventListener('click', function () {
    var otp = document.getElementById('otp').value;
    var email = document.getElementById('email').value; // Capture email for verification

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
        xhr.send('otp=' + encodeURIComponent(otp) + '&email=' + encodeURIComponent(email) + '&action=verify_otp');
    } else {
        alert("Please enter the OTP.");
    }
});

// Step 3: Reset Password
document.getElementById('resetPasswordBtn').addEventListener('click', function () {
    var new_password = document.getElementById('new_password').value;
    var email = document.getElementById('email').value; // Capture email for password reset

    if (new_password) {
        // AJAX Request to reset password
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'otpverify.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Show response from PHP
                alert(xhr.responseText);

                // Check if the password was successfully reset
                if (xhr.responseText.includes('Password reset successfully')) {
                    // Redirect to another page, e.g., login page
                    window.location.href = '/Online-Grocery-Store-Using-PHP/GardenRoots/index.php';
 // or any other URL
                }
            }
        };
        xhr.send('new_password=' + encodeURIComponent(new_password) + '&email=' + encodeURIComponent(email) + '&action=reset_password');
    } else {
        alert("Please enter a new password.");
    }
});
</script>

</body>
</html>
