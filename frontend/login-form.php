<?php

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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <?php include "navbar.php"; ?>
    
    <div class="container">
       <div class="forms-container">
            <form action="" class="login-form" method="post">
                <h2 class="title">Log in</h2>
<?php
    if (isset($_GET['error'])){
        echo "<div class='error-message'><span class='fa-solid fa-circle-info'></span> Invalide Log in credentials !</div>";
    }
?>   

              
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
<script src="pw_view.js"></script>
</body>
</html>