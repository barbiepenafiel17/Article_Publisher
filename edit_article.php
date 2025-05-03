<?php
include 'db.php'; // Make sure you have a working DB connection here

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $article_id = $_POST['article_id'];

    $query = "SELECT * FROM articles WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $article_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $article = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Article</title>
</head>
<body>
  <h2>Edit Article</h2>
  <form action="update_article.php" method="POST">
    <input type="hidden" name="article_id" value="<?= $article['id']; ?>">

    <label>Title:</label><br>
    <input type="text" name="title" value="<?= htmlspecialchars($article['title']); ?>" required><br><br>

    <label>Abstract:</label><br>
    <textarea name="abstract" required><?= htmlspecialchars($article['abstract']); ?></textarea><br><br>

    <label>Content:</label><br>
    <textarea name="content" rows="10" required><?= htmlspecialchars($article['content']); ?></textarea><br><br>

    <button type="submit">Update Article</button>
  </form>
</body>
</html>
