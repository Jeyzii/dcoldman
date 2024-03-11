<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .otp-container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
        }

        h2 {
            color: #333333;
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #555555;
        }

        input {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            margin-bottom: 20px;
            border: 1px solid #cccccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #ff800f;
            color: #ffffff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #011064;
        }

        p {
            color: #777777;
            margin-top: 10px;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .error-message {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="otp-container">
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
            echo '<p class="error-message">' . $_SESSION["error_message"] . '</p>';
            unset($_SESSION["error_message"]);
        }
        ?>

        <p>Didn't receive the OTP? <a href="resend_otp.php">Resend OTP</a></p>
    </div>
</body>
</html>
