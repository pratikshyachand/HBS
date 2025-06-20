<?php
require '../backend/login.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forget Password</title>
    <link rel="stylesheet" href="css/otp.css">
</head>
<body>
    
  <div class="container">
    <h2>Forgot Your Password?</h2>
    <p>Enter your email and we'll send you a reset link.</p>
    
    <form action="" method="post">
      <input type="email" name="emailID" placeholder="Enter your email" required>
      <button type="submit" name="btn_forgot">Send Reset Link</button>
    </form>

    <a href="login-form.php" class="back-link">← Back to Login</a>
  </div>
</body>
</html>