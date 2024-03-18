<?php
$host = 'postgres';
$port = '5432';
$dbname = 'your_database';
$user = 'your_username';
$password = 'your_password';

$dsn = "pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password";

try {
    $pdo = new PDO($dsn);
    echo "Connected to PostgreSQL successfully!";
} catch (PDOException $e) {
    echo "Failed to connect to PostgreSQL: " . $e->getMessage();
}
