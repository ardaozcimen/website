<?php
$host = 'localhost';
$dbname = 'konyatup';
$username = 'root';
$password = '';

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    echo "Connected to MySQL successfully\n";
    
    // Check if blogs table exists
    $stmt = $db->query("SELECT count(*) FROM blogs");
    echo "Blogs count: " . $stmt->fetchColumn() . "\n";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
