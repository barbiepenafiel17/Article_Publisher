<!DOCTYPE html> 
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Article Management Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet" />
  <link href="setting.css" rel="stylesheet" />
</head>
<body>

  <div class="sidebar">
    <h2>DBCLM COLLEGE</h2>
    <nav>
    <h2>DASHBOARD</h2>
      <a href="admin_dashboard.php">ARTICLES</a>
      <a href="user.php">USER</a>
      <a href="announcement.php">ANNOUNCEMENT</a>
      <a href="setting.php" class="active">SETTINGS</a>
    </nav>
    <div style="position: absolute; bottom: 20px;">
      <a href="logout.php">LOGOUT</a>
    </div>
  </div>

  <div class="content">
    <div class="topbar">
      <h1>Article Management Dashboard</h1>
    </div>

  <div class="main-content">
    <h1>Settings</h1>

    <form class="settings-form" method="POST" action="#">
      <div class="form-group">
        <label>Full Name</label>
        <input type="text" name="fullname" value="Admin User">
      </div>

      <div class="form-group">
        <label>Email Address</label>
        <input type="email" name="email" value="admin@dbclm.com">
      </div>

      <div class="form-group">
        <label>New Password</label>
        <input type="password" name="password" placeholder="Enter new password">
      </div>

      <div class="form-group">
        <label>Notification Settings</label>
        <label><input type="checkbox" checked> Email me on article submissions</label><br>
        <label><input type="checkbox"> Notify me of comment reports</label>
      </div>

      <div class="form-actions">
        <button type="submit" class="save">Save Changes</button>
        <button type="reset" class="reset">Reset</button>
      </div>
    </form>
  </div>
</body>
</html>
