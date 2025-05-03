<?php
session_start();
require 'db_connect.php'; // adjust if your DB connection is elsewhere

$user_id = $_SESSION['user_id'];
$article_id = $_POST['article_id'];

$sql = "INSERT INTO article_reports (user_id, article_id) VALUES (?, ?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("ii", $user_id, $article_id);
$stmt->execute();
$stmt->close();

echo "Article reported successfully.";
?>
