<?php
session_start();
$user = null;
if (str_starts_with($_SERVER['PHP_SELF'], '/frontend/admin/'))
    $user = -1;
if (str_starts_with($_SERVER['PHP_SELF'], '/frontend/seeker/'))
    $user = 1;
if (str_starts_with($_SERVER['PHP_SELF'], '/frontend/owner/'))
    $user = 0;

if ($user === null){
    header("Location: /frontend/login-form.php?error=" . urlencode("You must be logged in to view this page."));
    exit();
}
if (!isset($_SESSION['logged_in'])){
    header("Location: /frontend/login-form.php?error=" . urlencode("You must be logged in to view this page."));
    exit();
}

if ($_SESSION['logged_in'] != $user){
// Set the HTTP status code to 403 Forbidden
    header("HTTP/1.0 403 Forbidden");

// (Optional) You can include a custom message in the body
    echo "<title>403 Forbidden</title>";

    echo "<h1>403 Forbidden</h1>";
    echo "<p>You do not have permission to access this resource.</p>";

    echo "<hr>";
    echo "<p>Web Server at HostelHub.com";
// Stop script execution to prevent further output
    exit();
}
