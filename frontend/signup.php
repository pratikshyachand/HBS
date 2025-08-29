<?php

    require_once "../backend/login.php";


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Form</title>
    <link rel="stylesheet" href="css/signup.css">
    <link rel="stylesheet" href="css/footer.css">
     <link rel="stylesheet" href="css/nav-bar.css">
             <link rel="stylesheet" href="css/popup.css">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <?php include "navbar.php"; ?>
    <div class="container">
        <div class="panel">
            <img src="img/signup.svg" class="image" alt="">
        </div>
       
            
            <form action="" class="signup-form" method="post" autocomplete="off" id="signupForm">
                <h2 class="title">Sign Up as Hostel Seeker</h2>
                <div class="input-field">
                    <i class="fas fa-user"></i>
                    <input type="text"  placeholder="First Name" name="first_name" required>
                </div>
                <div class="input-field">  
                    <i class="fas fa-user"></i>
                    <input type="text" placeholder="Last Name" name="last_name"  required>
                </div>
                 <div class="input-field">
                    <i class="fas fa-envelope"></i>
                    <input type="email" placeholder="Email Address" name="emailID" required>
                </div>
                <!-- <div class="input-field">
    <i class="fas fa-phone"></i>
 <input type="tel" placeholder="Phone number" pattern="[0-9]{10}"  maxlength="10" name="contact" required>
</div> -->
                <div class="input-field">
                    <i class="fas fa-lock"></i>
                    <input type="password" placeholder="Password" name="pass" id="password"  required>
                    <i class="fas fa-eye" id="eye"></i>
                    <p id="alert1" class="required_length">password must be at least 8 characters long</p>
                </div>
                <div class="input-field">
                    <i class="fas fa-lock"></i>
                    <input type="password" placeholder="Confirm Password" name="confirm_pass" id="cpassword" required disabled>
                    <p id="alert2" class="not_matched"><i class="fa-solid fa-circle-info"></i>
               passwords do not match </p>
                </div>

                <input type="hidden" name="role" value="seeker" >

                <input type="submit" value="Sign Up" class="btn" name="btn_signup" id="sign-up-btn" disabled>
                <label class="terms">
                 <input type="checkbox" name="subscribe" value="yes" id="termsCheckbox">
                 I agree to the Terms of Use and Privacy Policy
               </label> 
               <p class="error" id="termsError">
               You must agree to the Terms of Use and Privacy Policy.
               </p>
                <span>Already have an account?<a href="login-form.php" class="have-acc"> Log In</a>
            </form>
        
       </div>
    
    
    
    
    <?php include 'footer.php'; ?>

    <!-- popup message -->
        <?php if (!empty($popup_message)): ?>
<div class="popup-message popup" id="popup">
    <span class="popup-close" onclick="this.parentElement.style.display='none'">×</span>
    <?php foreach ($popup_message as $msg): ?>
        <p><?php echo htmlspecialchars($msg); ?></p>
    <?php endforeach; ?>
</div>

<script>
    document.getElementById('popup').style.display = 'block';
</script>
<?php endif; ?>

    </div>

    <script src="pw_view.js"></script>
    <script>
    document.getElementById("signupForm").addEventListener("submit", function (e) {
    const termsCheckbox = document.getElementById("termsCheckbox");
    const termsError = document.getElementById("termsError");
    // Terms checkbox check
    if (!termsCheckbox.checked) {
        termsError.style.display = "block";
        e.preventDefault();
        return;
    }
    });
    </script>
</body>
</html>