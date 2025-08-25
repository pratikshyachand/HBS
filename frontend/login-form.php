<?php
    session_start();
    require "../backend/login.php";
   

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login and Signup Form</title>
    <link rel="stylesheet" href="css/signup.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/footer.css">
     <link rel="stylesheet" href="css/nav-bar.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <?php include "navbar.php"; ?>
    
    <div class="container">
       <div class="forms-container">
            <form action="" class="login-form" method="post">

                <h2 class="title">Log in</h2>
   

              
                 <div class="input-field">
                    <i class="fas fa-envelope"></i>
                    <input type="email" placeholder="Email Address" name="emailID" required>
                </div>
                <div class="input-field">
                    <i class="fas fa-lock" ></i>
                    <input type="password" placeholder="Password" name="pass" id="password" required>
                     <i class="fas fa-eye" id="eye"></i>
                </div>
                <p class="error" id="errorMsg">Passwords do not match!</p>
                <input type="submit" value="Login" class="btn" name="btn_login">
              
                <a href="forgot-password.php" class="forgot-password">Forgot password?</a>

                  <?php
               if (isset($_GET['error'])){
               echo "<div class='error-message'><span class='fa-solid fa-circle-info'></span>" . $_GET['error'] ."</div>";
               }
               if (isset($_GET['account_verified'])){
               if ($_GET['account_verified'] === 'successful'){
             echo "<div class='error-message'><span class='fa-solid fa-circle-check'></span>
             <b>Account verified successfully! </b> Please login to your account again. </div>";
             }
             }
             ?>
            </form>

       </div>
    

    
    <div class="panel left-panel">
        <div class="content">
            <h3>
                Don't have an account?
            </h3>
            <button class="btn transparent" id="sign-up-btn">Sign up</button>
        </div>
        <img src="img/log.svg" class="image" alt="">
        </div>

    
    </div>
    

     <?php include 'footer.php'; ?>

     <!-- <script>
  
</script> -->
<script >

    document.getElementById('sign-up-btn').addEventListener('click',() => {
    window.location.href = "signup.php";
});

    const eyeIcon= document.getElementById('eye');
    const passwordField= document.getElementById('password');

eyeIcon.addEventListener('click',() => {
    if(passwordField.type === "password" && passwordField.value)
    {
        passwordField.type = "text";
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash');

    }
    else{
        passwordField.type = "password";
        eyeIcon.classList.add('fa-eye');
        eyeIcon.classList.remove('fa-eye-slash');
    }
});
</script>
</body>
</html>