<?php
session_start();
include 'db_connect.php'; // ← make sure this points to your database connection file

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and sanitize inputs
    $articleId = isset($_POST['article_id']) ? intval($_POST['article_id']) : 0;
    $commentText = isset($_POST['comment_text']) ? trim($_POST['comment_text']) : '';

    // You must know the current user's ID (owner of comment)
    // Example: assume user_id is stored in session
    $userId = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;

    if ($articleId > 0 && $userId > 0 && !empty($commentText)) {
        // Prepare SQL Insert
        $stmt = $conn->prepare("INSERT INTO comments (article_id, user_id, comment_text, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("iis", $articleId, $userId, $commentText);

        if ($stmt->execute()) {
            // Success, redirect back
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        } else {
            echo "Error saving comment.";
        }

        $stmt->close();
    } else {
        echo "Invalid input.";
    }
} else {
    echo "Invalid request.";
}
?>
