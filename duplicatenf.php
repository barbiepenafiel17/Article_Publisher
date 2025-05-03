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
    <link rel="stylesheet" href="newsfeed.css">
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

<div class="layout"> 
  <aside class="sidebar">
    <ul>
      <li class="active">
        <img src="finalhome.png" alt="Home"> 
        <span>Home</span>
      </li>
      <li>
        <img src="finaluser.png" alt="Profile"> 
        <span ><a href="profile.php" style="color: black;text-decoration: none;">My Profile</a></span>
      </li>
      <li>
        <img src="finalsave.png" alt="Saved"> 
        <span>Saved Articles</span>
      </li>
    </ul>
    </aside>
    <!-- Institutes Card -->
    <div class="card">
  <h2 class="card-title">Institutes</h2>
  <ul class="checkbox-list">
    <li><input type="checkbox" class="institute-filter" value="All" checked> All Institutes</li>
    <li><input type="checkbox" class="institute-filter" value="Institute of Computing"> Institute of Computing</li>
    <li><input type="checkbox" class="institute-filter" value="Institute of Leadership Entrepreneurship, and Good Governance"> Institute of Leadership Entrepreneurship, and Good Governance</li>
    <li><input type="checkbox" class="institute-filter" value="Institute of Teacher Education"> Institute of Teacher Education</li>
    <li><input type="checkbox" class="institute-filter" value="Institute of Aquatic and Applied Sciences"> Institute of Aquatic and Applied Sciences</li>
  </ul>
</div>



    <!-- School Announcement Card -->
    <div class="card1">
      <h2 class="card-title">School Announcement</h2>
      <div class="announcement">
        <strong>Early Dismissal</strong>
        <p>This Friday, April 14th, school will dismiss at 12:30 PM for teacher professional development.</p>
      </div>
      <div class="announcement">
        <strong>Yearbook Orders</strong>
        <p>Last chance to order your yearbook! Deadline is April 20th.</p>
      </div>
      <div class="announcement">
        <strong>Summer Programs</strong>
        <p>Registration for summer enrichment programs opens next Monday.</p>
      </div>
    </div>


</div>

    <div class="main-content">
        

        <div class="post-box">
        <?php
// Example: $profile_picture is fetched from your database during login or session setup
// Let's add a fallback if user has no uploaded profile picture

if (!empty($profile_picture)) {
    $profile_picture = htmlspecialchars($profile_picture);
} else {
    // Default profile picture if none uploaded
    $profile_picture = 'default_profile.png'; // You can put a nice default image here
}
?>

<img src="<?php echo $profile_picture; ?>" alt="User" class="avatar">


    <form class="post-input" action="submit_article.php" method="POST">
        <input 
            type="text"
            class="post-input1" 
            id="articleInput" 
            name="title" 
            placeholder="What's on your mind? Want to publish your own article?" 
            required >
</form>

            <div class="center-button">
                <button class="publish-btn"><strong>PUBLISH ARTICLE</strong> ✎</button>

                <!-- Dropdown Article Form -->
                <div id="articleFormDropdown" class="form-dropdown hidden">
                    <div class="form-container">
                        <div class="form-header">
                            <button class="close-btn" onclick="document.getElementById('articleFormDropdown').classList.add('hidden')">✕</button>
                        </div>
                        <h2>Submit Your Article</h2>
                        <form action="submit_article.php" method="post" enctype="multipart/form-data">
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Article Title</label>
                                    <input type="text" name="title" required>
                                </div>
                            </div>
                            <div class="form-group full-width">
                                <label>Abstract</label>
                                <textarea name="abstract" rows="3"></textarea>
                            </div>
                            
                            <div class="form-group full-width">
                                <label>Featured Image</label>
                                <div class="image-upload">
                                    <div class="image-box">
                                        <p>📷<br>Drag and drop your image here, or click to browse</p>
                                        <small>Supported formats: JPG, PNG, GIF (Max size: 5MB)</small>
                                        <input type="file" name="featured_image" hidden id="featuredImageInput">
                                    </div>
                                    <button type="button" class="select-button" id="selectImageButton">Select Image</button>
                                </div>
                            </div>
                            <div class="form-group full-width toggle-section">
                                <label>Additional Options</label>
                                <div class="toggles">
                                    <div class="toggle-item">
                                        <label class="switch">
                                            <input type="checkbox" name="comments" checked>
                                            <span>💬 Allow comments</span>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="toggle-item">
                                        <label class="switch">
                                            <input type="checkbox" name="private">
                                            <span>🔒 Make article private</span>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="toggle-item">
                                        <label class="switch">
                                            <input type="checkbox" name="notifications" checked>
                                            <span>🔔 Email notifications for comments</span>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="button" class="draft-btn">Save as Draft</button>
                                <button type="submit" class="submit-btn">Submit for Review</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

        <div class="post-feed" id="postFeed">
<?php

/**
 * Nag add rako ug "u.profile_picture" sa inyong $articleQuery query
 */

$articleQuery = "SELECT a.*, u.full_name, u.profile_picture,
    (SELECT COUNT(*) FROM reactions r WHERE r.article_id = a.id AND r.reaction_type = 'like') AS likes,
    (SELECT COUNT(*) FROM comments c WHERE c.article_id = a.id) AS comments
FROM articles a
JOIN users u ON a.user_id = u.id
WHERE a.status = 'approved'
ORDER BY a.created_at DESC";
$profile_picture_path = !empty($profile_picture) ? htmlspecialchars($profile_picture) : 'default-profile.png';
$result = $conn->query($articleQuery);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $articleId = $row['id'];
        echo '<div class="post-card" data-article-id="' . $articleId . '">';
        echo '<div class="dropdown" style="display: inline-block; position: relative;">
    <button class="dot-btn">...</button>
    <div class="dropdown-content" style="display: none; position: absolute; top: 0; left: 100%; background: white; box-shadow: 0 2px 5px rgba(0,0,0,0.2); z-index: 1;">
        <!-- Delete -->
        <form method="POST" action="delete_article.php" onsubmit="return confirm(\'Delete this article?\');">
            <input type="hidden" name="article_id" value="' . $articleId . '">
            <button type="submit" style="color: red; background: none; border: none; padding: 10px; width: 100%; text-align: left;">Delete</button>
        </form>

        <!-- Hide -->
        <form method="POST" action="hide_article.php">
            <input type="hidden" name="article_id" value="' . $articleId . '">
            <button type="submit" style="background: none; border: none; padding: 10px; width: 100%; text-align: left;">Hide</button>
        </form>

        <!-- Report -->
        <form method="POST" action="report_article.php" onsubmit="return confirm(\'Report this article to admin?\');">
            <input type="hidden" name="article_id" value="' . $articleId . '">
            <button type="submit" style="background: none; border: none; padding: 10px; width: 100%; text-align: left;">Report</button>
        </form>
    </div>
</div>
';

        echo '  <div class="post-header">';
        // Then here I added the uploads/profile_pictures/ for the path of each user profile
        echo '<img class="avatar" src="' . 'uploads/profile_pictures/' . $row['profile_picture'] . '" alt="User">';
        echo '    <div>';
        echo '      <strong>' . htmlspecialchars($row['full_name']) . '</strong><br>';
        echo '      <span class="post-date">' . date("F j, Y | g:i A", strtotime($row['created_at'])) . '</span>';
        echo '    </div>';
        echo '  </div>';
        echo '  <div class="post-title"><strong>' . htmlspecialchars($row['title']) . '</strong></div>';
        echo '  <div class="post-content">' . nl2br(htmlspecialchars($row['abstract'])) . '</div>';

        if (!empty($row['featured_image'])) {
            echo '<div class="post-image"><img src="' . htmlspecialchars($row['featured_image']) . '" alt="Article Image" class="responsive-img"></div>';
        }

        echo '  <div class="post-actions">';
        echo '    <button class="like-btn" data-article-id="' . $articleId . '">👍 <span class="like-count" id="like-count-' . $articleId . '">' . $row['likes'] . '</span></button>';
        echo '    <button class="comment-btn">💬 <span class="comment-count" id="comment-count-' . $articleId . '">' . $row['comments'] . '</span></button>';
        echo '  </div>';

        echo '  <div class="post-comments">';
        
        // Fetch comments
        $commentQuery = "SELECT c.*, u.full_name AS commenter_name 
                         FROM comments c 
                         JOIN users u ON c.user_id = u.id 
                         WHERE c.article_id = $articleId 
                         ORDER BY c.created_at ASC";
        $commentResult = $conn->query($commentQuery);

        echo '    <div class="comment-list" id="comments-' . $articleId . '">';
        if ($commentResult && $commentResult->num_rows > 0) {
            while ($comment = $commentResult->fetch_assoc()) {
                echo '<div class="comment">';
                echo '  <div class="comment-text">';
                echo '    <strong>' . htmlspecialchars($comment['commenter_name']) . ':</strong> ' . htmlspecialchars($comment['comment_text']);
                echo '  </div>';
                
                // If the article owner replied
                if (!empty($comment['reply_text'])) {
                    echo '<div class="reply-text">';
                    echo '  <em>Owner replied:</em> ' . htmlspecialchars($comment['reply_text']);
                    echo '</div>';
                }
                echo '</div>';
            }
        } else {
            echo '<p class="no-comments">No comments yet.</p>';
        }
        echo '    </div>'; // close comment-list

        // Comment input box
        echo '    <form method="POST" action="post_comment.php" class="comment-form">';
        echo '      <input type="hidden" name="article_id" value="' . $articleId . '">';
        echo '      <input class="comment-box" type="text" name="comment_text" placeholder="Write a comment..." required>';
        echo '      <button type="submit">Post</button>';
        echo '    </form>';

        echo '  </div>'; // close post-comments
        echo '</div>'; // close post-card
    }
} else {
    echo "<p>No approved articles available yet.</p>";
}
?>
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
<script>
document.querySelectorAll('.institute-filter').forEach(checkbox => {
  checkbox.addEventListener('change', function () {
    const selected = Array.from(document.querySelectorAll('.institute-filter:checked'))
                          .map(cb => cb.value);

    fetch('filter_feed.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({ institutes: selected })
    })
    .then(response => response.text())
    .then(data => {
      document.getElementById('feed-container').innerHTML = data;
    });
  });
});
</script>


</body>
</html>
