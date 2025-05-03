<?php
session_start();
require 'db_connect.php'; // your database connection

$user_id = $_SESSION['user_id']; // or however you track users
if (isset($_FILES['profile_picture'])) {
    $fileName = $_FILES['profile_picture']['name'];
    $fileTmp = $_FILES['profile_picture']['tmp_name'];
    $fileDestination = 'uploads/profile_pictures/' . $fileName;
    
    move_uploaded_file($fileTmp, $fileDestination);

    // Update the user's profile_picture in the database
    $query = "UPDATE users SET profile_picture = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('si', $fileName, $user_id);
    $stmt->execute();

    // Update the session variable so other pages can see it
    $_SESSION['profile_picture'] = $fileName;

    header("Location: profile.php?upload=success");
    exit();
}
?>
