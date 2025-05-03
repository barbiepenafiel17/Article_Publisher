<?php
$mysqli = new mysqli("localhost", "root", "", "dbclm_college");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$query = "SELECT COUNT(*) as count FROM articles WHERE status IN ('PENDING', 'SUBMITTED')";
$result = $mysqli->query($query);

if (!$result) {
    die("Query failed: " . $mysqli->error);
}

$count = $result->fetch_assoc()['count'];

echo $count;
?>
