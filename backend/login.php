<?php
    session_start();
    require "func.php";
    require __DIR__ . '/../vendor/autoload.php';
    

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    $errors = array();


    // user clicked login button
    if (isset($_POST['btn_login'])) {
        $email = trim($_POST['emailID']);
        $pass = trim($_POST['pass']);

    if (login($email, $pass) === 'owner'){
        header("Location: hostel_owner/business-info.html");
        exit();
    }
    else if (login($email, $pass) === 'seeker'){
        header("Location: index.php");
        exit();
    }
    // pasword and email donot match
    else {
        header("Location: login-form.php?error='invalid credientials'");
        exit();

    }

}

    //user clicked signup button
    if (isset($_POST['btn_signup']) ) {
        $fname = trim($_POST['first_name']);
        $lname = trim($_POST['last_name']);
        $email = trim($_POST['emailID']);
        $pass = trim($_POST['pass']);
        $cpass = trim($_POST['confirm_pass']);
        $role = $_POST['role'];

         if (empty($fname) || empty($lname) || empty($email) || empty($pass) || empty($cpass)) {
        $errors[] = "All fields are required";
        echo "empty";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
        echo "invalid email"; //remove
        } elseif ($pass!== $cpass) {
        $errors[] = "Passwords do not match.";//rem
        echo "pw not match";
        }
        else {
        // Password strength check
        $uppercase = preg_match('@[A-Z]@', $pass);
        $lowercase = preg_match('@[a-z]@', $pass);
        $number    = preg_match('@[0-9]@', $pass);
        $specialChars = preg_match('@[^\w]@', $pass);
        if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($pass) < 8) {
        $errors[] = "Password must be at least 8 characters long and include an uppercase letter, a lowercase letter, a number, and a special character.";
        echo "weak password";
        }
        }
        
        if(empty($errors))
        {
        try{
        $con = dbConnect();
        $stmt = $con->prepare("SELECT * FROM tbl_users WHERE email = ?");

            $stmt->bind_param("s", $email); // "s" means string
            $stmt->execute();
            $res = $stmt->get_result();

            if ($res->num_rows > 0) {
                $errors['email'] = "Email that you have entered is already linked to an account!";
                echo "more";//rem
            }

            $stmt->close();
        }
        
        catch (mysqli_sql_exception $e) {
           error_log("DB connection failed: " . $e->getMessage());
           die("Something went wrong.");
}
        }
    

        //verifying email
        if(empty($errors)){
        $encpass = password_hash($pass, PASSWORD_BCRYPT);
        $code = rand(111111, 999999);
        $status = 0;
        try{
        $con = dbConnect();
        $stmt = $con->prepare("INSERT INTO tbl_users (first_name, last_name, email, password, role, status, otp) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssii", $fname, $lname, $email, $encpass, $role, $status, $code);
        if (!$stmt->execute()) {
            die("Insert failed: " . $stmt->error);
           }
         else {
          $_SESSION['verification_source'] = 'signup';
          sendVerificationCode($email, $code);
      
        }
     $stmt->close();
  }
    catch (mysqli_sql_exception $e) 
    {
    error_log("DB connection failed: " . $e->getMessage());
    die("Something went wrong.");
    }
        
    }
    }

    //user clicked login button
    function login($email, $pass){

       if (empty($email) || empty($pass)) {
        $errors['login'] = "All fields are required";
       } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format";
       }

    if (empty($errors)) {
        try{
        $con = dbConnect();
        $stmt = $con->prepare("SELECT * FROM tbl_users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $fetch_data = $result->fetch_assoc();
           
            // Verify password
            if (password_verify($pass, $fetch_data['password'])) {
                if ($fetch_data['status'] === 1) {
                   
                    $_SESSION['email'] = $fetch_data['email'];
                    
                    header("Location: /index.php");
                    exit();
                } else {
                    $_SESSION['info'] = "It looks like you haven't verified your email yet - {$fetch_data['email']}";
                    header("Location: otp.php");
                    exit();
                }
            } else {
                $errors['login'] = "Incorrect email or password!";
                echo "incorrect credentials";
            }
        } else {
            $errors['login'] = "No account found with this email. Please sign up.";
            echo "no account";
        }

        $stmt->close();
    }
     catch (mysqli_sql_exception $e) 
    {
    error_log("DB connection failed: " . $e->getMessage());
    die("Something went wrong.");
    }

    }
}

    //user clicked verification code submit button
    if(isset($_POST['btn_otp_submit']))
    {   
        $_SESSION['info'] = " ";
        $input_otp = trim($_POST['otp_code']);
        if (empty($input_otp)) {
        $errors['login'] = "Please enter the code";
        echo "empty";
        }

        if(empty($errors)){
        try{
        $con = dbConnect();
        $stmt = $con->prepare("SELECT * FROM tbl_users where otp = ? ");
        $stmt->bind_param("i", $input_otp);
        if($stmt->execute())
        echo "fetch";

        $result = $stmt->get_result();

        if($result->num_rows > 0)
        {
            $fetch_data = $result->fetch_assoc();
            $fetch_code = $fetch_data['otp'];
            $fetch_email = $fetch_data['email'];

            $code = 0;
            $status = 1;
            
            $update_stmt = $con->prepare("UPDATE tbl_users set otp = ?, status = ? where otp = ?");
            $update_stmt->bind_param("iii",$code, $status, $fetch_code);
            $update_success = $update_stmt->execute();

            if($update_success)
            {
             $_SESSION['email'] = $fetch_email;
             // Redirect depending on source
             if (isset($_SESSION['verification_source']) && $_SESSION['verification_source'] === 'signup') {
                 unset($_SESSION['verification_source']);
                 header("Location: login-form.php");
             } else {
                 unset($_SESSION['verification_source']);
                 header("Location: resetpass.php");
             }
             exit();
            }
            else{
             $errors['otp-error'] = "Failed while updating code!";
            }
            $update_stmt->close();
        }
        else{
            $errors['otp-error'] = "You've entered incorrect code!";
            echo "incorrect";
        }
        $stmt->close();
    }
     catch (mysqli_sql_exception $e) 
    {
    error_log("DB connection failed: " . $e->getMessage());
    die("Something went wrong.");
    }
}

}

//sending verification code to user's email
function sendVerificationCode($email, $code)
{
    $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';  // Gmail SMTP server
            $mail->SMTPAuth   = true;
            $mail->Username   = 'glaty1917@gmail.com';  
            $mail->Password   = 'clzipdidxfwoihcr';    // Gmail app password
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            //Recipients
            $mail->setFrom('glaty1917@gmail.com', 'Glaty');
            $mail->addAddress($email);

            //Content
            $mail->isHTML(true);
            $mail->Subject = 'HostelHub.com - Please Confirm Email Address';
            $mail->Body    = "Your verification code is $code";

           $mail->send();
           echo 'Message has been sent';
           $info = "Please enter the verification code sent to your email - $email";
           $_SESSION['info'] = $info;
           $_SESSION['email'] = $email;
           header("Location: otp.php");
           exit();
       } 
       catch (Exception $e) {
           die("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
       }
}

//user clicked send reset link button
    
    if(isset($_POST['btn_forgot']))
    {
        $email = trim($_POST['emailID']);
        $code = rand(111111, 999999);
       if (empty($email) ){
        $errors['login'] = "Please enter your email address";
       } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format";
       }

      if (empty($errors)) {
        try{
        $con = dbConnect();
        $stmt = $con->prepare("SELECT * FROM tbl_users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            try{
            $_SESSION['verification_source'] = 'forgot';
            $insert_code = $con->prepare("UPDATE tbl_users set otp = ? where email = ?");
            $insert_code->bind_param("is",$code,$email);
            $insert_code->execute();
            sendVerificationCode($email, $code);
            }
             catch (mysqli_sql_exception $e) 
            {
             error_log("DB connection failed: " . $e->getMessage());
             die("Something went wrong.");
            }
            $insert_code->close();
        } 
        else {
            $errors['login'] = "No account found with this email. Please sign up.";
            echo "no account";
        }

        $stmt->close();
    }
     catch (mysqli_sql_exception $e) 
    {
    error_log("DB connection failed: " . $e->getMessage());
    die("Something went wrong.");
    }

    }
}
    
