<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="/frontend/css/otp.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


</head>
<body>
    
<div class="container">
  <h1>Reset your password</h1>
    <form action="" method="post">
    
    <div class="input-field">
      <i class="fas fa-lock"></i>
      <input type="password" placeholder="Password" name="pass" id="password"  required>
      <i class="fas fa-eye" id="eye"></i>
    </div>
    <div class="input-field">
        <i class="fas fa-lock"></i>
        <input type="password" placeholder="Confirm Password" name="confirm_pass" id="cpassword" required>
    </div>
    <button name="btn_otp_submit">Submit</button>
    </form>
    <div class="resend">
      Didn’t receive the code? <a href="#">Resend OTP</a>
    </div>
</div>


<script src="pw_view.js"></script>

</body>
</html>