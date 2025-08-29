<?php
session_start();
require_once 'func.php';

if (!isset($_SESSION['user_id'])) {
    die('Unauthorized');
}

$con = dbConnect();
$user_id = $_SESSION['user_id'];
$hostel_id = (int)$_POST['hostel_id'];
$rating = (int)$_POST['rating'];
$comment = trim($_POST['comment']);

$stmt = $con->prepare("INSERT INTO tbl_reviews (hostel_id, user_id, rating, comment, created_at) VALUES (?, ?, ?, ?, NOW())");
$stmt->bind_param("iiis", $hostel_id, $user_id, $rating, $comment);
$stmt->execute();
$stmt->close();
$con->close();

// Redirect back to hostel page
header("Location: " . $_SERVER['HTTP_REFERER']);
exit;
?>
