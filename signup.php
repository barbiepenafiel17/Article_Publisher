<?php
include 'db_connect.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetch and sanitize user input
    $role = $_POST["role"];
    $full_name = ucwords($_POST["full_name"]);  // Capitalize the first letter of each word in the full name
    $email = $_POST["email"];
    $password = $_POST["password"];
    
    // Limit password to 10 characters
    if (strlen($password) > 10) {
        echo "<script>alert('Password must be 10 characters or less.'); window.history.back();</script>";
        exit();
    }

    $password = password_hash($password, PASSWORD_DEFAULT); // Hash password after limiting length
    $institute = $_POST["institute"];

    // Validate that the role is either 'Student' or 'Teacher'
    $valid_roles = ['Student', 'Teacher'];
    if (!in_array($role, $valid_roles)) {
        echo "<script>alert('Invalid role selected.'); window.history.back();</script>";
        exit();
    }

    // Allow only @dbclm.com email addresses
    if (!preg_match("/^[a-zA-Z0-9._%+-]+@dbclm\.com$/", $email)) {
        echo "<script>alert('Only @dbclm.com emails are allowed.'); window.history.back();</script>";
        exit();
    }

    // Insert user data into the database
    $stmt = $conn->prepare("INSERT INTO users (role, full_name, email, password, institute) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $role, $full_name, $email, $password, $institute);

    if ($stmt->execute()) {
        echo "<script>alert('Account created successfully!'); window.location.href='login.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Signup - DBCLM College</title>
    <link rel="stylesheet" href="signup.css">
    
</head>
<body>
    <nav class="navbar">
        <div class="logo">DBCLM COLLEGE</div>
        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">Latest</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Contact</a></li>
            <li><a href="login.php">Login</a></li>
        </ul>
    </nav>

    <div class="signup-container">
        <div class="form-card">
            <a href="login.php" class="back-link">← Back to Login</a>
            <h2>Create Your Account</h2>
            <form method="POST">
                <div class="role-select-buttons">
                    <input type="hidden" name="role" id="selectedRole" required>
                    <div class="role-btn" onclick="selectRole(this, 'Student')">Student</div>
                    <div class="role-btn" onclick="selectRole(this, 'Teacher')">Teacher</div>
                </div>

                <input type="text" name="full_name" placeholder="Enter your full name" required>
                <input type="email" name="email" placeholder="Enter your DBCLM email (e.g. you@dbclm.com)" required>
                <input type="password" name="password" placeholder="Create a strong password (max 10 characters)" required>
                <input type="password" placeholder="Confirm your password" required>
                <select name="institute" required>
                    <option value="">Select Institute</option>
                    <option value="IC">Institute of Computing</option>
                    <option value="ITed">Institute of Teacher Education</option>
                    <option value="IC">Institute of Leadership, Entrepreneurship, and Good Governance</option>
                    <option value="ITed">Institute of Aquatic and Applied Sciences</option>
                </select>
                <button type="submit">Create Account</button>
                <p class="signin-link">Already have an account? <a href="login.php">Sign In</a></p>
            </form>
        </div>
    </div>

    <footer>
        <div class="footer-links">
            <div>
                <p>Keeping the community informed and connected.</p>
            </div>
            <div>
                <h4>Quick Links</h4>
                <p>Home</p><p>Latest</p><p>About</p><p>Contact Us</p>
            </div>
            <div>
                <h4>Categories</h4>
                <p>Academics</p><p>Sports</p><p>Arts and Culture</p><p>Faculty Spotlight</p>
            </div>
        </div>
    </footer>

    <script>
        function selectRole(btn, role) {
            document.querySelectorAll('.role-btn').forEach(el => el.classList.remove('selected'));
            btn.classList.add('selected');
            document.getElementById('selectedRole').value = role;
        }
    </script>
</body>
</html>
