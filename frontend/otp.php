<?php
    session_start();
    require "../backend/login.php";
    if(isset($_GET['user']))
      {
        $email = $_GET['user'];
      }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email</title>
    <link rel="stylesheet" href="css/otp.css">
      <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    
  <div class="container">
    <i class="fas fa-envelope"></i>
    <h1>Verify Your Email</h1> 
    <p>Please enter the verification code sent to <?php echo $email; ?></p>
    <form action="" method="post">
    <input type="text" placeholder="Enter verification code" name="otp_code" required/>
    <button name="btn_otp_submit">Submit</button>
    </form>
    <div class="resend">
      Didn’t receive the code? <a href="/backend/verification_code.php?user=<?php echo $email; ?>">Resend OTP</a>
    </div>
</div>
</body>
</html>