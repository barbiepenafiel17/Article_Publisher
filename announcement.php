<!DOCTYPE html> 
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Article Management Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet" />
  <link href="announcement.css" rel="stylesheet" />
</head>
<body>

  <div class="sidebar">
    <h2>DBCLM COLLEGE</h2>
    <nav>
      <h2>DASHBOARD</h2>
      <a href="admin_dashboard.php">ARTICLES</a>
      <a href="user.php">USER</a>
      <a href="announcement.php" class="active">ANNOUNCEMENT</a>
      <a href="setting.php">SETTINGS</a>
    </nav>
    <div style="position: absolute; bottom: 20px;">
      <a href="logout.php">LOGOUT</a>
    </div>
  </div>

  <div class="content" style="width: 100%; margin:20px">
    <div class="topbar">
      <h1>Article Management Dashboard</h1>
    </div>

    <div class="container" style="width: 100%; margin:20px">
      <div class="announcement-box" >
        <h2>Create New Announcement</h2>

        <?php
// Connect to your database
$pdo = new PDO("mysql:host=localhost;dbname=dbclm_college", "root", ""); // Change credentials as needed
?>

<form action="save_announcement.php" method="POST" enctype="multipart/form-data">
  <div class="announcement-form">
    <label>Title</label>
    <input type="text" name="title" required placeholder="Enter announcement title" />

    <label>Content</label>
    <textarea name="content" required placeholder="Write your announcement content here..."></textarea>

    <label>Target Audience</label>
    <div class="checkbox-group">
      <label><input type="checkbox" name="audience[]" value="students" /> Students</label>
      <label><input type="checkbox" name="audience[]" value="teacher" /> Teacher</label>
    </div>

    <div class="notify">
      <label><input type="checkbox" name="notify" value="1" /> Send notification to users</label>
    </div>

    <div class="actions">
      <button type="submit" name="action" value="cancel">Cancel</button>
      <button type="submit" name="action" value="publish">Publish</button>
    </div>
  </div>
</form>
      </div>
    </div>
  </div>

</body>
</html>
