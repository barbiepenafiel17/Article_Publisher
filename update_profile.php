<?php
session_start();
require 'db_connect.php'; // This pulls in the $pdo connection

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Validate and sanitize input
$full_name = isset($_POST['full_name']) ? trim($_POST['full_name']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

if (empty($full_name) || empty($email)) {
    echo "Name and email cannot be empty.";
    exit();
}

try {
    // Update full_name and email first
    $sql = "UPDATE users SET full_name = :full_name, email = :email WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':full_name' => $full_name,
        ':email' => $email,
        ':id' => $user_id
    ]);

    // Update password if it was filled
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "UPDATE users SET password = :password WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':password' => $hashed_password,
            ':id' => $user_id
        ]);
    }

    // Redirect after successful update
    header('Location: profile.php?update=success');
    exit();

} catch (PDOException $e) {
    echo "Error updating profile: " . $e->getMessage();
    exit();
}
?>
