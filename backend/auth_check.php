<?php
session_start();

// If user not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../frontend/login-form.php");
    exit();
}
?>
