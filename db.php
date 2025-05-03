<?php
$mysqli = new mysqli("localhost", "root", "", "dbclm_college");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

?>
