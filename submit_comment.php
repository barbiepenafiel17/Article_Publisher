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
$comment_text = trim($_POST['comment'] ?? '');

if (!$article_id || $comment_text === '') {
    echo json_encode(['error' => 'Invalid input']);
    exit;
}

// Insert comment
$stmt = $conn->prepare("INSERT INTO comments (user_id, article_id, comment) VALUES (?, ?, ?)");
$stmt->bind_param("iis", $user_id, $article_id, $comment_text);
$stmt->execute();

// Optional: get user's name
$stmt = $conn->prepare("SELECT full_name FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($full_name);
$stmt->fetch();

$comment_html = "<strong>" . htmlspecialchars($full_name) . ":</strong> " . htmlspecialchars($comment_text);

echo json_encode(['comment_html' => $comment_html]);
