<?php 
include 'db_connect.php';
session_start();

// Admin credentials (use secure storage in production)
$admin_email = "admin@dblcmcollege.com";
$admin_password = "admin123"; // Tip: hash this in real apps

$loginError = ""; // Error message to be shown on the page

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    // Admin Login
    if ($email === $admin_email && $password === $admin_password) {
        $_SESSION["role"] = "Admin";
        $_SESSION["email"] = $email;
        $_SESSION["full_name"] = "Administrator";
        echo "<script>alert('Logged in as Admin!'); window.location.href='admin_dashboard.php';</script>";
        exit();
    }
    $query = "SELECT id, full_name, email, profile_picture FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['full_name'] = $user['full_name'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['profile_picture'] = $user['profile_picture'];
    // User login from DB
    $stmt = $conn->prepare("SELECT id, full_name, role, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $full_name, $role, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION["user_id"] = $id;
            $_SESSION["full_name"] = $full_name ?? "User";
            $_SESSION["role"] = $role;

            if ($role === "Student" || $role === "Teacher") {
                echo "<script>alert('Logged in as $role!'); window.location.href='newsfeed.php';</script>";
                exit();
            } else {
                $loginError = "Invalid user role detected.";
            }
        } else {
            $loginError = "Incorrect password.";
        }
    } else {
        $loginError = "No account found with that email.";
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - DBCLM College</title>
    <link rel="stylesheet" href="login.css">
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
        <img src="bell.jpg" alt="Notifications" class="icon-bell">
        <span class="user-label">
            <?php echo isset($_SESSION['full_name']) ? htmlspecialchars($_SESSION['full_name']) : 'Guest'; ?>
        </span>
    </div>
</header>

<div class="login-container">
    <form method="post" action="">
        <img src="FinalLogo.jpg" alt="DBCLM College" class="loginlogo">
        <h2>Sign in to Your Account</h2>

        <?php if (!empty($loginError)): ?>
            <p style="color: red;"><?php echo $loginError; ?></p>
        <?php endif; ?>

        <input type="email" name="email" placeholder="Enter your email" required>
        <input type="password" name="password" placeholder="Password" id="passwordInput" required>

        <label>
            <input type="checkbox" onclick="togglePassword()"> Show Password
        </label>

        <label><input type="checkbox" name="remember"> Remember me</label>

        <button type="submit">Sign In</button>

        <div class="footer-links">
            <a href="#">Forgot password?</a><br>
            <a href="signup.php">Don't have an account? Sign up</a>
        </div>
    </form>
</div>

<script>
    function togglePassword() {
        const passwordField = document.getElementById('passwordInput');
        passwordField.type = passwordField.type === "password" ? "text" : "password";
    }
</script>

</body>
</html>
