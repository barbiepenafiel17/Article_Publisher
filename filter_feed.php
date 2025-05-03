<?php
// Connect to your DB
$conn = new mysqli("localhost", "root", "", "dbclm_college");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents("php://input"), true);
$institutes = $data['institutes'] ?? [];

if (in_array("All", $institutes) || empty($institutes)) {
    $sql = "SELECT * FROM user WHERE status = 'approved' ORDER BY created_at DESC";
} else {
    $placeholders = implode(',', array_fill(0, count($institutes), '?'));
    $sql = "SELECT * FROM user WHERE institute IN ($placeholders) AND status = 'approved' ORDER BY created_at DESC";
}

$stmt = $conn->prepare($sql);

if (!in_array("All", $institutes) && !empty($institutes)) {
    $types = str_repeat('s', count($institutes));
    $stmt->bind_param($types, ...$institutes);
}

$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    echo "<div class='article-card'>";
    echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
    echo "<p><strong>Institute:</strong> " . htmlspecialchars($row['institute']) . "</p>";
    echo "<p>" . nl2br(htmlspecialchars($row['abstract'])) . "</p>";
    echo "</div>";
}

$conn->close();
?>
