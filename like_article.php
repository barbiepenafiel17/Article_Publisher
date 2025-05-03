<?php
session_start();
header('Content-Type: application/json');

include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit;
}

$user_id = $_SESSION['user_id'];
$article_id = isset($_POST['article_id']) ? intval($_POST['article_id']) : 0;

if (!$article_id) {
    echo json_encode(['error' => 'Invalid article ID']);
    exit;
}

// Check if already liked
$stmt = $conn->prepare("SELECT id FROM reactions WHERE user_id = ? AND article_id = ?");
$stmt->bind_param("ii", $user_id, $article_id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    // Already liked, remove like
    $stmt = $conn->prepare("DELETE FROM reactions WHERE user_id = ? AND article_id = ?");
    $stmt->bind_param("ii", $user_id, $article_id);
    $stmt->execute();
} else {
    // Insert like
    $stmt = $conn->prepare("INSERT INTO reactions (user_id, article_id, reaction_type) VALUES (?, ?, 'like')");
    $stmt->bind_param("ii", $user_id, $article_id);
    $stmt->execute();
}

// Count updated likes
$stmt = $conn->prepare("SELECT COUNT(*) FROM reactions WHERE article_id = ? AND reaction_type = 'like'");
$stmt->bind_param("i", $article_id);
$stmt->execute();
$stmt->bind_result($like_count);
$stmt->fetch();

echo json_encode(['likes' => $like_count]);
