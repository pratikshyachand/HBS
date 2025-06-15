<?php

    require "../backend/login.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Ip as Hostel Owner</title>
    <link rel="stylesheet" href="signup-as-owner.css">
    <link rel="stylesheet" href="css/nav-bar.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <?php include "navbar.php"; ?>
    
   <div class="container">
       
        <div class="login-signup">
            <form action="" class="login-form" method="post">
                <h2 class="title">Sign Up as Hostel Owner</h2>
                <div class="input-field">
                    <input type="text" name="first-name"  placeholder="First Name">
                </div>
                <div class="input-field">  
                    <input type="last-name" placeholder="Last Name">
                </div>
                 <div class="input-field">
                    <input type="text" placeholder="Email">
                </div>
                <div class="input-field">
                    <input type="password" name="pass" placeholder="Password">
                </div>
                <div class="input-field">
                    <input type="confirm-password" placeholder="Confirm Password">
                </div>
                <input type="submit" value="Sign Up" class="btn" name="signup">
                <label class="terms">
                 <input type="checkbox" name="subscribe" value="yes">
                 I agree to the Terms of Use and Privacy Policy
               </label> 
                <a href="login-signup.php" class="have-acc">Already have an account? Log In</a>
            </form>
        
       </div>
    
    <div class="panel left-panel">
        <img src="img/owner-login.svg" class="image" alt="">
    </div>
    </div>
    
</body>
</html>