<?php
    session_start();
    session_unset();
    session_destroy();
    header('Location:  /frontend/login-form.php');
    exit();