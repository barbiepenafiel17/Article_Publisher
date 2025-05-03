<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbclm_college";

// Create MySQLi connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check MySQLi connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create PDO connection
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
