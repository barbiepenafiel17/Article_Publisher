<?php
header('Content-Type: application/json');
include 'db_connect.php';

$data = json_decode(file_get_contents("php://input"), true);
$institutes = $data['institutes'] ?? [];
$sort = $data['sort'] ?? 'newest'; // Default sorting option

$query = "
    SELECT a.*, u.full_name, u.profile_picture, u.institute,
        (SELECT COUNT(*) FROM reactions WHERE article_id = a.id AND reaction_type = 'like') AS likes,
        (SELECT COUNT(*) FROM comments WHERE article_id = a.id) AS comments
    FROM articles a
    JOIN users u ON a.user_id = u.id
    WHERE a.status = 'approved'
";

// Filter by institute based on the user's institute field
if (!in_array("All", $institutes) && !empty($institutes)) {
    $placeholders = implode(',', array_fill(0, count($institutes), '?'));
    $query .= " AND u.institute IN ($placeholders)";
}

// Add sorting options
switch ($sort) {
    case 'oldest':
        $query .= " ORDER BY a.created_at ASC";
        break;
    case 'most_likes':
        $query .= " ORDER BY likes DESC, a.created_at DESC";
        break;
    case 'most_comments':
        $query .= " ORDER BY comments DESC, a.created_at DESC";
        break;
    case 'newest':
    default:
        $query .= " ORDER BY a.created_at DESC";
        break;
}

$query .= " LIMIT 6";

$stmt = $pdo->prepare($query);

if (!in_array("All", $institutes) && !empty($institutes)) {
    $stmt->execute($institutes);
} else {
    $stmt->execute();
}

$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($articles);
?>