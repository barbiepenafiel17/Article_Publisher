<?php 
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'db_connect.php'; // PDO connection ($pdo)

$user_id = $_SESSION['user_id'];
if (!is_numeric($user_id)) {
    die("Invalid user ID.");
}

// Fetch user info
$stmt = $pdo->prepare("SELECT full_name, profile_picture FROM users WHERE id = :id");
$stmt->execute(['id' => $user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    session_destroy();
    header("Location: login.php");
    exit();
}

$full_name = htmlspecialchars($user['full_name']);
$profile_picture = !empty($user['profile_picture']) ? 'uploads/profile_pictures/' . htmlspecialchars($user['profile_picture']) : 'uploads/profile_pictures/default_profile.png';

// Fetch latest unread notification
$notifStmt = $pdo->prepare("SELECT * FROM notifications WHERE user_id = :user_id AND is_read = 0 ORDER BY created_at DESC LIMIT 1");
$notifStmt->execute(['user_id' => $user_id]);
$unreadNotifications = $notifStmt->fetchAll(PDO::FETCH_ASSOC);
$notifCount = count($unreadNotifications);

// Fetch articles
$articleStmt = $pdo->query("
    SELECT a.*, u.full_name, u.profile_picture,
        (SELECT COUNT(*) FROM reactions WHERE article_id = a.id AND reaction_type = 'like') AS likes,
        (SELECT COUNT(*) FROM comments WHERE article_id = a.id) AS comments
    FROM articles a
    JOIN users u ON a.user_id = u.id
    WHERE a.status = 'approved'
    ORDER BY a.created_at DESC
");
$articles = $articleStmt->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>DBCLM College</title>
  <link rel="stylesheet" href="aboutus.css">
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
        <a href="contactus.php">Contact</a>
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
$profile_picture = !empty($profile_picture) ? '' . htmlspecialchars($profile_picture) : 'default-profile.png';
?>

<div class="notification-wrapper" style="position: relative;">
    <img src="bell.jpg" alt="Notifications" class="icon-bell" id="notif-bell" style="cursor:pointer;">

    <?php if ($notifCount > 0): ?>
    <span class="notif-badge"> <?php echo $notifCount; ?> </span>
<?php endif; ?>

<div class="notif-dropdown" id="notif-dropdown" style="display:none;">
    <?php
    if ($notifCount > 0) {
        foreach ($unreadNotifications as $notif) {
            echo '<div class="notif-item">' .
                    htmlspecialchars($notif['message']) .
                    '<br><small>' . date('M d, Y H:i', strtotime($notif['created_at'])) . '</small>' .
                 '</div>';
        }
    } else {
        echo '<div class="notif-item">No new notifications</div>';
    }
    ?>
</div>

    </div>
</div>
<?php $notifStmt->close(); ?>

        <span class="user-label"><?php echo htmlspecialchars($full_name); ?></span>
    </div>
</header>

  <!-- Hero Section -->
  <section class="hero">
    <h1>From thought to page—your platform for meaningful publishing.</h1>
    <p>To curate and share thoughtful, high-quality articles that inform, inspire, and engage readers across diverse topics and perspectives.</p>
    <div class="hero-images">
      <img src="https://via.placeholder.com/150" alt="Image 1">
      <img src="https://via.placeholder.com/150" alt="Image 2">
      <img src="https://via.placeholder.com/150" alt="Image 3">
    </div>
    <div class="caption-box">
      <h3>What we believe in</h3>
      <p>We believe empowering creators to share their voice helps communities grow, bridging gaps and promoting meaningful dialogue.</p>
    </div>
  </section>

  <!-- Features Section -->
  <section class="features">
    <h2>The Foundation of our Success</h2>
    <p>Clarity and Consistency</p>
    <div class="feature-cards">
      <div class="card">
        <div>🛠️</div>
        <h4>Real-Time System Updates</h4>
      </div>
      <div class="card">
        <div>🤝</div>
        <h4>Seamless Collaboration</h4>
      </div>
      <div class="card">
        <div>📄</div>
        <h4>Article Workflow</h4>
      </div>
    </div>
  </section>

  <!-- Team Section -->
  <section class="team">
    <h2>Meet our team of creators, designers and problem solvers</h2>
    <p>Get to know the people who lead</p>
    <div class="team-grid">
      <div class="member">
        <div class="avatar"></div>
        <p>Barbie Penafiel</p>
      </div>
      <div class="member">
        <div class="avatar"></div>
        <p>Donna Meg Eran</p>
      </div>
      <div class="member">
        <div class="avatar"></div>
        <p>Chenybabes Dalogdog</p>
      </div>
    </div>
  </section>

  <!-- Call to Action -->
  <section class="cta">
    <h2>Join our team, the one with the master touch</h2>
    <p>We believe in helping talents to reach their fullest potential and creating opportunities for their growth and success.</p>
    <a href="#">See open positions →</a>
  </section>

  <!-- Footer -->
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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
// Toggle publish form
const publishBtn = document.querySelector('.publish-btn');
const dropdownForm = document.getElementById('articleFormDropdown');
const selectImageButton = document.getElementById('selectImageButton');
const featuredImageInput = document.getElementById('featuredImageInput');

publishBtn.addEventListener('click', () => {
    dropdownForm.classList.toggle('hidden');
});

selectImageButton.addEventListener('click', () => {
    featuredImageInput.click();
});

featuredImageInput.addEventListener('change', (event) => {
    const fileName = event.target.files[0] ? event.target.files[0].name : 'No file chosen';
    selectImageButton.textContent = `Selected: ${fileName}`;
});

// Likes and comments handling
$(document).ready(function() {
  $('.like-btn').click(function() {
    const articleId = $(this).data('article-id');
    const likeBtn = $(this);

    $.post('like_article.php', { article_id: articleId }, function(response) {
        if (response.likes !== undefined) {
            $('#like-count-' + articleId).text(response.likes);
        }
    }, 'json');
});

$('.comment-box').keypress(function(e) {
    if (e.which === 13) {
        const articleId = $(this).data('article-id');
        const commentText = $(this).val();
        const commentList = $('#comments-' + articleId);

        if (commentText.trim() !== '') {
            $.post('submit_comment.php', {
                article_id: articleId,
                comment: commentText
            }, function(response) {
                if (response.comment_html) {
                    commentList.append('<div class="comment">' + response.comment_html + '</div>');

                    // Increment comment count in UI
                    let countEl = $('#comment-count-' + articleId);
                    countEl.text(parseInt(countEl.text()) + 1);
                }
            }, 'json');
            $(this).val('');
        }
    }
});
});

</script>
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
    const dropdowns = document.querySelectorAll(".dropdown");
    dropdowns.forEach(dropdown => {
        const button = dropdown.querySelector(".dot-btn");
        const content = dropdown.querySelector(".dropdown-content");

        button.addEventListener("click", function(e) {
            e.stopPropagation();
            document.querySelectorAll(".dropdown-content").forEach(c => {
                if (c !== content) c.style.display = "none";
            });
            content.style.display = content.style.display === "block" ? "none" : "block";
        });

        document.addEventListener("click", function() {
            content.style.display = "none";
        });
    });
</script>
 
</body>
</html>
