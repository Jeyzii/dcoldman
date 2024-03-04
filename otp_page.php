<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
</head>
<body>
    <div style="text-align: center; margin-top: 50px;">
        <h2>Enter OTP</h2>
        <p>Please check your email for the OTP and enter it below:</p>

        <!-- Form for OTP entry -->
        <form action="backend/auth/otp_verification.php" method="post">
            <label for="otp">OTP:</label>
            <input type="text" id="otp" name="otp" maxlength="6" required>
            <br><br>
            <input type="submit" value="Verify OTP">
        </form>

        <!-- Display error messages, if any -->
        <?php
        session_start();
        if (isset($_SESSION["error_message"])) {
            echo '<p style="color: red;">' . $_SESSION["error_message"] . '</p>';
            unset($_SESSION["error_message"]);
        }
        ?>

        <p>Didn't receive the OTP? <a href="resend_otp.php">Resend OTP</a></p>
    </div>
</body>
</html>
