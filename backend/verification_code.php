<?php

session_start();
    require "func.php";
    require __DIR__ . '/../vendor/autoload.php';
    

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;


if (isset($_GET['user'])){
    $email = $_GET['user'];
}
sendVerificationCode($email);
function sendVerificationCode($email)
{
//generating code
        $encpass = password_hash($pass, PASSWORD_BCRYPT);
        $code = rand(111111, 999999);
        $status = 0;
        /*UPDATE QUERY TO UPDATE TOKEN ONLY*/
        try{
        $con = dbConnect();
        $stmt = $con->prepare("INSERT INTO tbl_users (first_name, last_name, email, password, role, status, otp) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssii", $fname, $lname, $email, $encpass, $role, $status, $code);
        if (!$stmt->execute()) {
            die("Insert failed: " . $stmt->error);
           }
     $stmt->close();
  }
    catch (mysqli_sql_exception $e) 
    {
    error_log("DB connection failed: " . $e->getMessage());
    die("Something went wrong.");
    }
    }

    $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';  // Gmail SMTP server
            $mail->SMTPAuth   = true;
            $mail->Username   = '';  
            $mail->Password   = '';    // Gmail app password
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
           header("Location: /frontend/otp.php?user=$email");
           exit();
       } 
       catch (Exception $e) {
           die("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
       }