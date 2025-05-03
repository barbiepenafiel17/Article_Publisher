<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $article_id = $_POST['article_id'];
    $title = $_POST['title'];
    $abstract = $_POST['abstract'];
    $content = $_POST['content'];

    $query = "UPDATE articles SET title = ?, abstract = ?, content = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssi", $title, $abstract, $content, $article_id);

    if ($stmt->execute()) {
        echo "Article updated successfully. <a href='admin_dashboard.php'>Back to Dashboard</a>";
    } else {
        echo "Error updating article.";
    }
}
?>
