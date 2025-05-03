<?php 
include 'db.php';

// Fetch article stats
$stats_query = "
    SELECT 
        COUNT(*) AS total, 
        SUM(status IN ('PENDING', 'SUBMITTED')) AS pending,
        SUM(status = 'APPROVED') AS approved,
        SUM(status = 'REJECTED') AS rejected
    FROM articles";
$stats_result = $mysqli->query($stats_query);
$stats = $stats_result->fetch_assoc();

// Fetch latest articles (limit 5)
$articles_query = "
    SELECT 
        articles.*, 
        users.full_name AS author_name, 
        users.email AS author_email, 
        users.institute AS author_institute 
    FROM articles 
    JOIN users ON articles.user_id = users.id 
    ORDER BY articles.created_at DESC 
    LIMIT 5";
$articles_result = $mysqli->query($articles_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Article Management Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <link href="ad.css" rel="stylesheet">
</head>
<body>
  <div class="sidebar">
  <h2>DBCLM COLLEGE</h2>
    <nav>
    <h2>DASHBOARD</h2>
      <a href="admin_dashboard.php" class="active">ARTICLES</a>
      <a href="user.php">USER</a>
      <a href="announcement.php">ANOUNCEMENT</a>
      <a href="setting.php">SETTINGS</a>
    </nav>
    <div style="position: absolute; bottom: 20px;">
      <a href="logout.php">LOGOUT</a>
    </div>
  </div>

  <div class="content">
    <div class="topbar">
      <h1>Article Management Dashboard</h1>
    </div>

    <div class="stats">
      <div class="stat-card"><p>Total Submission</p><h2><?= $stats['total'] ?></h2></div>
      <div class="stat-card"><p>Pending Reviews</p><h2 id="pendingCount"><?= $stats['pending'] ?></h2></div>
      <div class="stat-card"><p>Approved Articles</p><h2><?= $stats['approved'] ?></h2></div>
      <div class="stat-card"><p>Rejected Articles</p><h2><?= $stats['rejected'] ?></h2></div>
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
          <th>Article</th>
          <th>Author</th>
          <th>Institutes</th>
          <th>Date</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $articles_result->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['title']) ?></td>
          <td>
            <?= htmlspecialchars($row['author_name']) ?><br>
            <a href="mailto:<?= htmlspecialchars($row['author_email']) ?>"><?= htmlspecialchars($row['author_email']) ?></a>
          </td>
          <td><?= htmlspecialchars($row['author_institute']) ?></td>
          <td><?= date('M j, Y', strtotime($row['created_at'])) ?></td>
          <td>
            <span class="status <?= strtolower($row['status']) ?>"><?= strtoupper($row['status']) ?></span>
          </td>
          <td class="actions">
              <form action="approve_article.php" method="POST" style="display:inline;">
                <input type="hidden" name="article_id" value="<?= $row['id']; ?>">
                <button type="submit" class="accept-btn">Approve</button>
              </form>
              <form action="reject_article.php" method="POST" style="display:inline;">
                <input type="hidden" name="article_id" value="<?= $row['id']; ?>">
                <button type="button" onclick="openModal(<?= $row['id']; ?>)" class="reject-btn">Reject</button>
              </form>
              <button class="view-btn">View</button>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>

  <!-- Modal for Rejecting Article -->
  <div id="rejectModal" class="modal" style="display:none;">
    <div class="modal-content">
      <span onclick="closeModal()" class="close">&times;</span>
      <h2>Reject Article</h2>
      <form action="reject_article.php" method="POST">
        <input type="hidden" id="articleId" name="article_id">
        <label for="reason">Reason for Rejection:</label>
        <textarea id="reason" name="reason" rows="4" required></textarea>
        <button type="submit" class="reject-btn">Reject Article</button>
      </form>
    </div>
  </div>

  <script>
    function openModal(articleId) {
      const modal = document.getElementById('rejectModal');
      document.getElementById('articleId').value = articleId;
      modal.style.display = 'block';
    }

    function closeModal() {
      const modal = document.getElementById('rejectModal');
      modal.style.display = 'none';
    }
  </script>
</body>
</html>
