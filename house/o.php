<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'c:\xampp\htdocs\house\PHPMailer\PHPMailer.php';
require 'c:\xampp\htdocs\house\phpmailer\Exception.php';
require 'c:\xampp\htdocs\house\phpmailer\SMTP.php';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";
$otp_validity_duration = 60; // OTP validity duration in seconds (e.g., 5 minutes)

if (isset($_POST['reset'])) {
    sendotp();
} elseif (isset($_POST['ok'])) {
    verifyotp();
}

function sendotp() {
    try {
        $recipient_email = $_POST['email'];
        $otp = mt_rand(100000, 999999);
        $otp_generation_time = time();

        $mail = new PHPMailer(true);

        // SMTP settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = '22bmiit009@gmail.com'; //enter email address
        $mail->Password = 'lcebozebvastggsl'; // Enter email password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Sender and recipient
        $mail->setFrom('22bmiit009@gmail.com', 'House');
        $mail->addAddress($recipient_email);

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'OTP for registration';
        $mail->Body = 'Your OTP is: ' . $otp;

        // Send email
        $mail->send();

        $_SESSION['otp'] = $otp;
        $_SESSION['email'] = $recipient_email;
        $_SESSION['otp_generation_time'] = $otp_generation_time;
        echo 'OTP has been sent to your email.';
    } catch (Exception $e) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    }
}

function verifyotp() {
    $user_otp = $_POST['verify'];
    $session_otp = $_SESSION['otp'];
    $otp_generation_time = $_SESSION['otp_generation_time'];
    $current_time = time();

    if (($current_time - $otp_generation_time) > $GLOBALS['otp_validity_duration']) {
        echo 'OTP has expired. A new OTP has been sent to your email.';
        sendotp();
    } elseif ($user_otp == $session_otp) {
        echo 'OTP verification successful!';
    } else {
        echo 'OTP verification failed. A new OTP has been sent to your email.';
        sendotp();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Send Email</title>
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="main">
    <section class="sign-in">
        <div class="container">
            <div class="signin-content">
                <div class="signin-image">
                    <figure><img src="images/signin-image.jpg" alt="sign up image"></figure>
                </div>
                <div class="signin-form">
                    <h2 class="form-title">Password Verification</h2>
                    <form method="POST" class="register-form" id="reset-form" action="#">
                        <table>
                            <tr>
                                <td><label for="email">Enter Email</label></td>
                                <td><input type="email" name="email" id="email" placeholder="Your Email"></td>
                            </tr>
                            <tr>
                                <td><input type="submit" name="reset" id="reset-password" class="form-submit" value="Generate OTP"/></td>
                            </tr>
                        </table>
                        <table>
                            <tr>
                                <td>Enter your OTP</td>
                                <td><input type="text" name="verify" maxlength="6" minlength="6"></td>
                                <div class="timer" id="timer">1:00</div>
                                <td><input type="submit" name="ok" id="ok" value="verify"></td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="your_other_scripts.js"></script>
<script>
                // Countdown timer for 1 minute
                var timeLeft = 60;
                var timer = setInterval(function() {
                    var minutes = Math.floor(timeLeft / 60);
                    var seconds = timeLeft % 60;
                    seconds = seconds < 10 ? '0' + seconds : seconds;
                    document.getElementById('timer').textContent = minutes + ':' + seconds;
                    if (timeLeft <= 0) {
                        clearInterval(timer);
                        document.getElementById('timer').textContent = '0:00';
                        // Handle OTP expiration
                        alert('Your OTP has expired. Please request a new one.');
                        
                    }
                    timeLeft--;
                }, 1000);
            </script>
</body>
</html>