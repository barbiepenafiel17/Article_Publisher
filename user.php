<?php 
include 'db.php'; 

$user_stats_query = "
    SELECT 
        COUNT(*) AS total, 
        SUM(role = 'student') AS student,
        SUM(role = 'teacher') AS teacher
    FROM users
";

$user_stats_result = $mysqli->query($user_stats_query);

if ($user_stats_result && $user_stats_result->num_rows > 0) {
    $user_stats = $user_stats_result->fetch_assoc();
} else {
    // Fallback values in case of error or empty result
    $user_stats = [
        'total' => 0,
        'student' => 0,
        'teacher' => 0
    ];
}

// === Fetch latest 5 articles with author info ===
$articles_query = "
    SELECT 
        articles.*, 
        users.full_name AS author_name, 
        users.email AS author_email, 
        users.role AS author_role 
    FROM articles 
    JOIN users ON articles.user_id = users.id 
    ORDER BY articles.created_at DESC 
    LIMIT 5
";

$articles_result = $mysqli->query($articles_query);
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Article Management Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <link href="user.css" rel="stylesheet">
</head>
<body>
  <div class="sidebar">
  <h2>DBCLM COLLEGE</h2>
    <nav>
    <h2>DASHBOARD</h2>
      <a href="admin_dashboard.php">ARTICLES</a>
      <a href="user.php" class="active">USER</a>
      <a href="announcement.php">ANNOUNCEMENT</a>
      <a href="setting.php">SETTINGS</a>
    </nav>
    <div style="position: absolute; bottom: 20px;">
      <a href="logout.php">LOGOUT</a>
    </div>
  </div>

  <div class="content">
    <div class="topbar">
      <h1>Article Management Dashboard</h1>
      <div><strong>LP</strong></div>
    </div>

    <div class="stats"> 
  <div class="stat-card">
    <p>Total Users</p>
    <h2><?= $user_stats['total'] ?? 0; ?></h2>
  </div>
  <div class="stat-card">
    <p>Students</p>
    <h2><?= $user_stats['student'] ?? 0; ?></h2>
  </div>
  <div class="stat-card">
    <p>Teachers</p>
    <h2><?= $user_stats['teacher'] ?? 0; ?></h2>
  </div>
  <div class="stat-card">
    <p>New Users (Last 7 Days)</p>
    <h2><?= $user_stats['new_users'] ?? 0; ?></h2>
  </div>
</div>

    <div class="filters">
      <input type="text" placeholder="Search articles by title, author or content">
      <select><option>All Institutes</option></select>
      <select><option>All Status</option></select>
      <button>Apply Filter</button>
    </div>

    <table>
      <thead>
        <tr>
          <th>NAME</th>
          <th>EMAIL</th>
          <th>ROLE</th>
          <th>DATE</th>
          <th>STATUS</th>
          <th>ACTION</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $articles_result->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['author_name']) ?></td>
          <td>
            <?= htmlspecialchars($row['author_email']) ?><br>
            
          </td>
          <td>
  <span class="role <?= strtolower($row['author_role']) ?>">
    <?= strtoupper($row['author_role']) ?>
  </span>
</td>
<td><?= date('M j, Y', strtotime($row['created_at'])) ?></td>
<td>
  <span class="status <?= strtolower($row['status']) ?>">
    <?= ucfirst($row['status']) ?>
  </span>
</td>


          <td class="actions">
           
              <!-- Edit Button -->
<form action="edit_article.php" method="POST" style="display:inline;">
  <input type="hidden" name="article_id" value="<?= $row['id']; ?>">
  <button type="submit" class="accept-btn">Edit</button>
</form>

<!-- Delete Button triggers modal -->
<button type="button" onclick="openModal(<?= $row['id']; ?>)" class="reject-btn">Delete</button>


<!-- View Button -->
<form action="view_article.php" method="GET" style="display:inline;">
  <input type="hidden" name="article_id" value="<?= $row['id']; ?>">
  <button type="submit" class="view-btn">View</button>
</form>

              
            
            
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>

  <!-- Optional Reject Modal -->
  <div id="rejectModal" style="display: none;">
  <form action="delete_article.php" method="POST">
    <input type="hidden" name="article_id" id="modalArticleId">
    <p style="display: flex; align-items: center; gap: 8px;">
      <span class="status delete-icon"></span>
      Are you sure you want to delete this article?
    </p>
    <button type="submit" class="reject-btn">Confirm Delete</button>
    <button type="button" onclick="closeModal()">Cancel</button>
  </form>
</div>


<script>
function openModal(articleId) {
  const modal = document.getElementById('rejectModal');
  if (modal) {
    modal.style.display = 'flex'; // use flex for better centering if styled that way
    const input = document.getElementById('modalArticleId');
    if (input) {
      input.value = articleId;
    }
  }
}

function closeModal() {
  const modal = document.getElementById('rejectModal');
  if (modal) {
    modal.style.display = 'none';
  }
}

// Optional: Close modal when clicking outside of it
window.addEventListener('click', function(event) {
  const modal = document.getElementById('rejectModal');
  if (modal && event.target === modal) {
    closeModal();
  }
});
</script>


</body>
</html>
