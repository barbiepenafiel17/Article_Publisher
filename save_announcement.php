<?php
$pdo = new PDO("mysql:host=localhost;dbname=dbclm_college", "root", ""); // Adjust credentials

$title = $_POST['title'];
$content = $_POST['content'];
$audience = isset($_POST['audience']) ? implode(",", $_POST['audience']) : "all";
$notify = isset($_POST['notify']) ? 1 : 0;
$action = $_POST['action'];
$status = $action === 'publish' ? 'published' : ($action === 'draft' ? 'draft' : 'cancelled');

$upload_dir = "uploads/";
$attachment_name = "";

if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
    $file_tmp = $_FILES['attachment']['tmp_name'];
    $file_name = basename($_FILES['attachment']['name']);
    $target_path = $upload_dir . uniqid() . "_" . $file_name;

    if (move_uploaded_file($file_tmp, $target_path)) {
        $attachment_name = $target_path;
    }
}

// Save the announcement
$stmt = $pdo->prepare("INSERT INTO announcements (title, content, audience, notify, status, created_at)
VALUES (?, ?, ?, ?, ?, NOW())");

$stmt->execute([
    $title,
    $content,
    $audience,
    $notify,
    $status
]);

// Delete old announcements, keep only the 3 latest
$pdo->exec("
    DELETE FROM announcements
    WHERE id NOT IN (
        SELECT id FROM (
            SELECT id FROM announcements ORDER BY created_at DESC LIMIT 3
        ) AS keep_ids
    )
");

// Redirect
header("Location: announcement.php");
exit;
?>
