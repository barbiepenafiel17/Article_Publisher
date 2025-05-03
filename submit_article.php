<?php    
session_start();
$conn = new mysqli("localhost", "root", "", "dbclm_college");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $upload_path = NULL; 

   
    if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] === 0) {
        $upload_dir = 'uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $file_name = basename($_FILES['featured_image']['name']);
        $file_tmp = $_FILES['featured_image']['tmp_name'];
        $file_size = $_FILES['featured_image']['size'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($file_ext, $allowed_types)) {
            if ($file_size <= 5 * 1024 * 1024) {
                $new_file_name = uniqid('img_', true) . '.' . $file_ext;
                $upload_path = $upload_dir . $new_file_name;

                if (!move_uploaded_file($file_tmp, $upload_path)) {// If move fails, fallback to NULL
                }
            }
        }
    }

    // Form data (safe to do here, with or without an image)
    $title = $_POST['title'];
    $institute = $_POST['institute'];
    $abstract = $_POST['abstract'];
    $content = $_POST['content'];
    $comments_enabled = isset($_POST['comments']) ? 1 : 0;
    $private = isset($_POST['private']) ? 1 : 0;
    $notifications = isset($_POST['notifications']) ? 1 : 0;

    // SQL insert (allow featured_image to be NULL)
    $stmt = $conn->prepare("INSERT INTO articles (title, institute, abstract, content, featured_image, comments_enabled, private, notifications, user_id, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'PENDING')");

    if ($stmt === false) {
        die("❌ MySQL prepare error: " . $conn->error);
    }

    $stmt->bind_param("sssssiiii", $title, $institute, $abstract, $content, $upload_path, $comments_enabled, $private, $notifications, $user_id);

    if ($stmt->execute()) {
        header("Location: newsfeed.php?submitted=1");
        exit();
    } else {
        echo "❌ Error executing statement: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
