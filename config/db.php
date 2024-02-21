<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "job";  // เพิ่มนี้เข้ามา

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);  // เพิ่ม $dbname ในนี้

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

ini_set('memory_limit', '256M');
?>