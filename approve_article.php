<?php
include 'db_connect.php'; // Ensure db.php creates $conn properly

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure the article ID is present in the POST data
    if (isset($_POST['article_id']) && is_numeric($_POST['article_id'])) {
        $article_id = $_POST['article_id'];

        // Prepare the statement to approve the article
        $update_stmt = $conn->prepare("UPDATE articles SET status = 'APPROVED' WHERE id = ?");
        if (!$update_stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $update_stmt->bind_param("i", $article_id);

        if ($update_stmt->execute()) {
            // Fetch the article details to get the author's ID and title
            $select_stmt = $conn->prepare("SELECT title, user_id FROM articles WHERE id = ?");
            $select_stmt->bind_param("i", $article_id);
            $select_stmt->execute();
            $result = $select_stmt->get_result();

            if ($result->num_rows > 0) {
                $article = $result->fetch_assoc();
                $author_id = $article['user_id'];
                $article_title = htmlspecialchars($article['title']); // Clean for safety

                // Prepare the notification message
                $message = "🎉 Your article titled '{$article_title}' has been approved!";

                // Insert notification into the database
                $notif_stmt = $conn->prepare("INSERT INTO notifications (user_id, message, is_read, created_at) VALUES (?, ?, 0, NOW())");
                $notif_stmt->bind_param("is", $author_id, $message);

                // Execute and check if notification insertion is successful
                if ($notif_stmt->execute()) {
                    // Notification was successfully added
                } else {
                    // Log or handle notification error
                    die("Notification insertion failed: " . $notif_stmt->error);
                }

                $notif_stmt->close();
            } else {
                // Handle case where no article is found with the given ID
                die("Article not found.");
            }

            $select_stmt->close();
        } else {
            // Handle failure of article approval update
            die("Article approval failed: " . $update_stmt->error);
        }

        $update_stmt->close();
        $conn->close();

        // Redirect back to admin dashboard with success indicator
        header("Location: admin_dashboard.php?approved=1");
        exit();
    } else {
        // Handle invalid or missing article ID
        die("Invalid article ID.");
    }
} else {
    // Handle incorrect request method (not POST)
    die("Invalid request method.");
}
?>
