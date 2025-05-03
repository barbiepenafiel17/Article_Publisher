<?php
session_start();

// Include your database connection
$conn = new mysqli("localhost", "root", "", "dbclm_college");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (!isset($_SESSION['user_id']) || !isset($_POST['article_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_role = $_SESSION['role'];
$article_id = $_POST['article_id'];

// Check if the article belongs to user or user is admin
$check_stmt = $conn->prepare("SELECT user_id FROM articles WHERE id = ?");
$check_stmt->bind_param("i", $article_id);
$check_stmt->execute();
$result = $check_stmt->get_result();

if ($result->num_rows > 0) {
    $article = $result->fetch_assoc();
    if ($article['user_id'] == $user_id || $user_role === 'admin') {
        // Soft delete: set status to 'DELETED'
        $update_stmt = $conn->prepare("UPDATE articles SET status = 'DELETED' WHERE id = ?");
        $update_stmt->bind_param("i", $article_id);
        if ($update_stmt->execute()) {
            header("Location: newsfeed.php?deleted=1");
            exit();
        } else {
            echo "❌ Error deleting article.";
        }
        $update_stmt->close();
    } else {
        echo "❌ You don't have permission to delete this article.";
    }
} else {
    echo "❌ Article not found.";
}

$check_stmt->close();
$conn->close();
?>
