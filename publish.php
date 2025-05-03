<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>DBCLM College</title>
  <link rel="stylesheet" href="publish.css">
</head>
<body>

<header class="navbar">
    <div class="logo">
      <img src="images/LOGO.jpg" alt="DBCLM Logo">
    </div>
    <nav class="nav-links">
      <a href="#">Home</a>
      <a href="#">Latest</a>
      <a href="#">About</a>
      <a href="#">Contact</a>
    </nav>
  <div class="navbar-right">
    <img src="images/bell.png" alt="Notifications" class="icon-bell">
    <span class="user-label">USER</span>
  </div>
  </header>
  
  <section class="featured-article">
    <div class="text-section">
      <span class="tag">Featured Article</span>
      <h1>Celebrating Unity and Talent:<br>Highlights from This Year’s School Events</h1>
      <div class="author-info">
        <img src="images/GirlFace.jpg" alt="Author Image" class="author-img">
        <div>
          <p class="author-name">Maria Isabel Lama</p>
          <p class="meta">April 9, 2025 • 8 mins read</p>
        </div>
      </div>
      <p class="description">
        Every school year brings opportunities for students to learn beyond the classroom, and this year was no exception.
        A wide range of events were held throughout the academic year, showcasing student talents, promoting camaraderie,
        and strengthening the school spirit.
      </p>
      <a href="#" class="read-more">Read More →</a>
    </div>
    <div class="image-section">
      <div class="placeholder-img"></div>
    </div>
  </section>

  <section class="submit-section">
    <div class="submit-content">
      <h2>Share Your Knowledge with the Community</h2>
      <p>
        Have insights or research to share? Submit your article to our platform and 
        reach educators and students across the institution.
      </p>
      <a href="#" class="submit-btn">
        ✍️ Submit Your Article
      </a>
    </div>
  </section>

  <div class="form-container">
    <h2>Submit Your Article</h2>
    <form action="#" method="post" enctype="multipart/form-data">
      <div class="form-row">
        <div class="form-group">
          <label>Article Title</label>
          <input type="text" name="title" required>
        </div>
        <div class="form-group">
          <label>Institutes</label>
          <input type="text" name="institute">
        </div>
      </div>

      <div class="form-group full-width">
        <label>Abstract</label>
        <textarea name="abstract" rows="3"></textarea>
      </div>

      <div class="form-group full-width">
        <label>Content</label>
        <textarea name="content" rows="10" required></textarea>
      </div>

      <div class="form-group full-width">
        <label>Featured Image</label>
        <div class="image-upload">
          <div class="image-box">
            <p>📷<br>Drag and drop your image here, or click to browse</p>
            <small>Supported formats: JPG, PNG, GIF (Max size: 5MB)</small>
            <input type="file" name="featured_image" hidden>
          </div>
          <button type="button" class="select-button">Select Image</button>
        </div>
      </div>

      <div class="form-group full-width toggle-section">
        <label>Additional Option</label>
        <div class="toggles">
          <div class="toggle-item">
            <span>💬 Allow comments</span>
            <label class="switch">
              <input type="checkbox" name="comments" checked>
              <span class="slider round"></span>
            </label>
          </div>
          <div class="toggle-item">
            <span>🔒 Make article private</span>
            <label class="switch">
              <input type="checkbox" name="private">
              <span class="slider round"></span>
            </label>
          </div>
          <div class="toggle-item">
            <span>🔔 Email notifications for comments</span>
            <label class="switch">
              <input type="checkbox" name="notifications" checked>
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

</body>
</html>