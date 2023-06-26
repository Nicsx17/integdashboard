<?php
$dsn = "mysql:host=localhost;dbname=dbstatusled;charset=utf8mb4";
$username = "root";
$password = "";

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query("SELECT moisture_level FROM sensor_data ORDER BY ID DESC LIMIT 1");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        echo $result['Soil_Moisture'];
    } else {
        echo "No data available";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>