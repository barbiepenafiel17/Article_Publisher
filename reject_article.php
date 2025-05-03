<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $article_id = $_POST['article_id'];
    $reason = $_POST['reason'];

    // Start a transaction to ensure data consistency
    $mysqli->begin_transaction();

    try {
        // Update the article's status to 'REJECTED' and store the rejection reason
        $query = "UPDATE articles SET status = 'REJECTED', feedback = ? WHERE id = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("si", $reason, $article_id);
        $stmt->execute();

        // Fetch the user_id of the author of the article
        $user_query = "SELECT user_id FROM articles WHERE id = ?";
        $user_stmt = $mysqli->prepare($user_query);
        $user_stmt->bind_param("i", $article_id);
        $user_stmt->execute();
        $user_result = $user_stmt->get_result();
        $user = $user_result->fetch_assoc();

        // Insert a notification for the user
        $notification_message = "Your article titled '{$row['title']}' has been rejected. Reason: {$reason}";
        $notification_query = "INSERT INTO notifications (user_id, message) VALUES (?, ?)";
        $notification_stmt = $mysqli->prepare($notification_query);
        $notification_stmt->bind_param("is", $user['user_id'], $notification_message);
        $notification_stmt->execute();

        // Commit the transaction
        $mysqli->commit();

        echo "Article has been rejected and notification sent.";
        header('Location: admin_dashboard.php'); // Redirect to the dashboard
    } catch (Exception $e) {
        // Rollback the transaction if anything goes wrong
        $mysqli->rollback();
        echo "Error rejecting article.";
    }
}
?>
