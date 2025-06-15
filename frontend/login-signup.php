<?php

    require "../backend/login.php";

    if (isset($_POST['login'])) {
        $uname = $_POST['uname'];
        $pass = $_POST['pass'];

    if (login($uname, $pass)){
        header("Location: hostel_owner/business-info.html");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login and Signup Form</title>
    <link rel="stylesheet" href="login-signup.css">
    <link rel="stylesheet" href="css/nav-bar.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <?php include "navbar.php"; ?>
    
    <div class="container">
       <div class="forms-container">
        <div class="login-signup">
            <form action="" class="login-form" method="post">
                <h2 class="title">Log in</h2>
                <div class="input-field">
                    <div class="icon">
                    <img src="img/user.png" alt="User Icon" width="22" height="22">
                    </div>

                    <input type="text" name="uname"  placeholder="Username">
                    
                </div>
                <div class="input-field">
                    <div class="icon"><img src="img/padlock.png" alt="Password Icon" width="22" height="22">
                    </div>  
                    <input type="password" name="pass" placeholder="Password">
                </div>
                <input type="submit" value="Login" class="btn" name="login">
                <a href="#" class="forgot-password">Forgot password?</a>
            </form>

            <form action="" class="sign-up-form" method="post">
                <h2 class="title">Sign up as Seeker</h2>
                <div class="field">
                    <input type="text" placeholder="First Name">
                    
                </div>
                 <div class="field">
                    <input type="text" placeholder="Last Name">
                    
                </div>
                <div class="field">
                    <input type="text" placeholder="Email">
                </div>
                <div class="field">
                    <input type="password" placeholder="Password">
                </div>
                
                <div class="field"> 
                    <input type="password" placeholder="Confirm Password">
                </div>
                
                <input type="submit" value="Sign up" class="btn">
               <label class="terms">
                 <input type="checkbox" name="subscribe" value="yes">
                 I agree to the Terms of Use and Privacy Policy
               </label>            
            </form>
        </div>
       </div>
    

    <div class="panels-container">
    <div class="panel left-panel">
        <div class="content">
            <h3>
                Don't have an account?
            </h3>
            <button class="btn transparent" id="sign-up-btn">Sign up</button>
        </div>
        <img src="img/log.svg" class="image" alt="">
    </div>

    <div class="panel right-panel">
        <div class="content">
            <h3>
                Already have an account?
            </h3>
            <button class="btn transparent" id="log-in-btn">Login</button>
            </div>
        <img src="img/undraw_online-ad_t56y.svg" class="image" alt="">
    </div>
    </div>
    </div>
     <script src="slider-for-login.js"></script>
</body>
</html>