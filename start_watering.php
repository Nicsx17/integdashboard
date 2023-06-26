<?php
$dsn = "mysql:host=localhost;dbname=dbstatusled;charset=utf8mb4";
$username = "root";
$password = "";

$duration = $_POST['duration'];

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Code to start watering for the specified duration

    echo "Watering started";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>