<?php 
include 'db_final.php'; 
session_start();

// Redirect to login if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id']; // ✅ assign before checking

if (!is_numeric($user_id)) {
    die("Invalid user ID.");
}

// Fetch user's full name
$query = "SELECT full_name FROM users WHERE id = ?";
$stmt = $conn->prepare($query);

if (!$stmt) {
    die("Error preparing the statement: " . $conn->error);
}

$stmt->bind_param("i", $user_id);

if (!$stmt->execute()) {
    die("Error executing the query: " . $stmt->error);
}

$stmt->bind_result($full_name);
$stmt->fetch();
$stmt->close();

// If user not found, destroy session
if (empty($full_name)) {
    session_destroy();
    header("Location: login.php");
    exit();
}
?>
<?php if (isset($_GET['update']) && $_GET['update'] == 'success'): ?>
<div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 10px;">
    Profile updated successfully!
</div>
<?php if (isset($_GET['update']) && $_GET['update'] == 'error_empty'): ?>
<div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 10px;">
    Name and Email cannot be empty. Please fill out all fields.
</div>
<?php endif; ?>

<?php endif; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DBCLM College</title>
    <link rel="stylesheet" href="profile.css">
</head>
<body>

<header class="navbar">
    <div class="logo">
        <img src="FinalLogo.jpg" alt="DBCLM Logo">
    </div>
    <nav class="nav-links">
        <a href="newsfeed.php">Home</a>
        <a href="#">Latest</a>
        <a href="#">About</a>
        <a href="#">Contact</a>
    </nav>
    <div class="navbar-right">
<?php
// ✅ Start session only if it's not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$conn = new mysqli("localhost", "root", "", "dbclm_college");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch unread notifications
// Fetch only the latest unread notification
$notifQuery = "SELECT * FROM notifications WHERE user_id = ? AND is_read = 0 ORDER BY created_at DESC LIMIT 1";
$notifStmt = $conn->prepare($notifQuery);
$notifStmt->bind_param("i", $user_id);
$notifStmt->execute();
$notifResult = $notifStmt->get_result();
$notifCount = $notifResult->num_rows;

?>

<div class="notification-wrapper" style="position: relative;">
    <img src="bell.jpg" alt="Notifications" class="icon-bell" id="notif-bell" style="cursor:pointer;">

    <?php if ($notifCount > 0): ?>
        <span class="notif-badge" style="position:absolute; top:0; right:0; background:red; color:white; padding:2px 6px; border-radius:50%; font-size:12px;"><?php echo $notifCount; ?></span>
    <?php endif; ?>

    <div class="notif-dropdown hidden" id="notif-dropdown" style="display: none; position:absolute; top:30px; right:0; background:white; border:1px solid #ccc; width:250px; max-height:300px; overflow-y:auto; box-shadow:0 0 5px rgba(0,0,0,0.2); z-index:100;">
        <?php
        if ($notifCount > 0) {
            while ($notif = $notifResult->fetch_assoc()) {
                echo '<div class="notif-item" style="padding:10px; border-bottom:1px solid #eee;">' .
                        htmlspecialchars($notif['message']) .
                        '<br><small style="color:gray;">' . date('M d, Y H:i', strtotime($notif['created_at'])) . '</small>' .
                     '</div>';
            }
        } else {
            echo '<div class="notif-item" style="padding:10px;">No new notifications</div>';
        }
        ?>
    </div>
</div>
<?php $notifStmt->close(); ?>

        <span class="user-label"><?php echo htmlspecialchars($full_name); ?></span>
    </div>
</header>

<div class="layout"> 
  <aside class="sidebar">
    <ul>
      <li>
        <img src="finalhome.png" alt="Home"> 
        <span><a href="newsfeed.php" style="color: black;text-decoration: none;">Home</a></span>
      </li>
      <li class="active">
        <img src="finaluser.png" alt="Profile"> 
        <span>My Profile</span>
      </li>
      <li>
        <img src="finalsave.png" alt="Saved"> 
        <span>Saved Articles</span>
      </li>
    </ul>
    </aside>
  
</div>
<div class="main-content" >
<?php
// Fetch full user info
$query = "SELECT full_name, email, password, profile_picture FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($full_name, $email, $password, $profile_picture);
$stmt->fetch();
$stmt->close();

// Default profile picture if none
if (empty($profile_picture)) {
    $profile_picture = 'default-profile.png'; // Put a default profile pic in your project
}
?>

<div class="profile-container"> 
    <div class="profile-picture-section">
        <img src="<?php echo htmlspecialchars($profile_picture); ?>" alt="Profile Picture" class="p0">
        <div class="p1">
            <form id="uploadForm" action="upload_profile_picture.php" method="POST" enctype="multipart/form-data" style="display: inline;">
                <input type="file" name="profile_picture" id="profileInput" style="display: none;" onchange="document.getElementById('uploadForm').submit();">
                <button type="button" onclick="document.getElementById('profileInput').click();" style="background-color: #4e8ef7; color: white; padding: 8px 12px; border: none; border-radius: 20px; margin-right: 5px;">Change Picture</button>
            </form>
            <form id="deleteForm" action="delete_profile_picture.php" method="POST" style="display: inline;">
                <button type="submit" style="background-color: transparent; color: black; padding: 8px 12px; border: 1px solid #ccc; border-radius: 20px;">Delete Picture</button>
            </form>
        </div>
    </div>

    <div class="personal-info-section">
        <h2 class="p2">Personal Information 
            <button class="edit-button p2">✏️ Edit</button>
        </h2>
        <p><strong>Name:</strong><br><?php echo htmlspecialchars($full_name); ?></p>
        <p><strong>Email:</strong><br><?php echo htmlspecialchars($email); ?></p>
        <p><strong>Password:</strong><br><?php echo str_repeat('•', 12); ?></p>
    </div>
</div>

<!-- Modal Popup for Edit Profile -->
<div id="editProfileModal" class="modal">
  <div class="modal-content">

    <span class="close">&times;</span>

    <!-- Popup content -->
    <div class="popup-profile"> 
    <div class="popup-profile-picture">
        <img src="<?php echo htmlspecialchars($profile_picture); ?>" alt="Profile Picture" class="popup-img">
        
        <div class="popup-picture-buttons" style="margin-top: 10px; display: flex; gap: 10px; justify-content: center;">
            <form id="popupUploadForm" action="upload_profile_picture.php" method="POST" enctype="multipart/form-data">
                <input type="file" name="profile_picture" id="popupProfileInput" style="display: none;" onchange="document.getElementById('popupUploadForm').submit();">
                <button type="button" onclick="document.getElementById('popupProfileInput').click();" class="popup-change-btn">Change</button>
            </form>

            <form id="popupDeleteForm" action="delete_profile_picture.php" method="POST">
                <button type="submit" class="popup-delete-btn">Delete</button>
            </form>
        </div>
    </div>

    <div class="popup-info-form" style="margin-top: 20px;">
        <form action="update_profile.php" method="POST">
            <div class="popup-form-group">
                <label for="full_name">Name:</label><br>
                <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($full_name); ?>" required>
            </div>

            <div class="popup-form-group" style="margin-top: 15px;">
                <label for="email">Email:</label><br>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>

            <div class="popup-form-group" style="margin-top: 15px;">
                <label for="password">Password:</label><br>
                <div style="position: relative;">
                    <input type="password" id="password" name="password" placeholder="Enter new password" style="padding-right: 30px;">
                    <span onclick="togglePassword()" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;">👁️</span>
                </div>
            </div>

            <div style="margin-top: 20px; text-align: center;">
                <button type="submit" class="popup-save-btn">Save Changes</button>
            </div>
        </form>
    </div>
</div>



</div>
<footer class="site-footer">
    <div class="footer-container">
        <div class="footer-about">
            <p>Keeping the community<br>informed and connected.</p>
        </div>
        <div class="footer-links">
            <h4>Quick Links</h4>
            <ul>
                <li>Home</li>
                <li>Latest</li>
                <li>About</li>
                <li>Contact us</li>
            </ul>
        </div>
        <div class="footer-links">
            <h4>Categories</h4>
            <ul>
                <li>Academics</li>
                <li>Sports</li>
                <li>Arts and Culture</li>
                <li>Faculty Spotlight</li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <p>© 2025 Speechforge. All rights reserved.</p>
    </div>
</footer>    

        <script>document.addEventListener('DOMContentLoaded', function () {
    const bell = document.getElementById('notif-bell');
    const dropdown = document.getElementById('notif-dropdown');

    bell.addEventListener('click', function () {
        dropdown.classList.toggle('hidden');

        // If visible, mark all notifications as read via AJAX
        if (!dropdown.classList.contains('hidden')) {
            fetch('mark_notifications_read.php', {
                method: 'POST'
            })
            .then(response => response.text())
            .then(() => {
                const badge = document.querySelector('.notif-badge');
                if (badge) {
                    badge.style.display = 'none'; // Hide the unread notification count
                }
            });
        }
    });

    // Optional: close when clicking outside
    document.addEventListener('click', function (e) {
        if (!dropdown.contains(e.target) && e.target !== bell) {
            dropdown.classList.add('hidden');
        }
    });
});
</script>
<script>
    document.getElementById('notif-bell').addEventListener('click', function () {
        const dropdown = document.getElementById('notif-dropdown');
        const badge = document.querySelector('.notif-badge');

        // Toggle the dropdown
        dropdown.style.display = (dropdown.style.display === 'none' || dropdown.style.display === '') ? 'block' : 'none';

        // Hide the badge (but keep the notifications visible)
        if (dropdown.style.display === 'block' && badge) {
            badge.style.display = 'none';

            // Optionally tell the server the notifications were "seen"
            fetch('clear_notifications.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'action=clear'
            });
        }
    });

    // Hide dropdown when clicking outside
    window.addEventListener('click', function(e) {
        if (!document.querySelector('.notification-wrapper').contains(e.target)) {
            document.getElementById('notif-dropdown').style.display = 'none';
        }
    });
</script>
<script>
const articleInput = document.getElementById('articleInput');
articleInput.addEventListener('keypress', (e) => {
    if (e.key === 'Enter') {
        e.preventDefault();
        articleInput.closest('form').submit();
    }
});
</script>
<script>
var modal = document.getElementById("editProfileModal");
var btn = document.querySelector(".edit-button");
var span = document.getElementsByClassName("close")[0];

btn.onclick = function() {
  modal.style.display = "block";
}

span.onclick = function() {
  modal.style.display = "none";
}

window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>
<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
    } else {
        passwordInput.type = "password";
    }
}
</script>
</body>
</html>