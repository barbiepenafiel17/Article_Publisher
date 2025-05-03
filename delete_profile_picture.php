<?php
include 'db_connect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Get current profile picture
$stmt = $conn->prepare("SELECT profile_picture FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($profile_picture);
$stmt->fetch();
$stmt->close();

// Delete file from server if not default
if (!empty($profile_picture) && file_exists($profile_picture)) {
    unlink($profile_picture);
}

// Set profile picture to NULL
$stmt = $conn->prepare("UPDATE users SET profile_picture = NULL WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->close();

header("Location: profile.php"); // Redirect back to profile
exit();
?>
