<?php
session_start();
require 'db_connection.php';

$userId = $_SESSION['user_id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'clear' && $userId) {
    $stmt = $conn->prepare("UPDATE notifications SET seen = 1 WHERE user_id = ? AND seen = 0");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->close();
}
?>

