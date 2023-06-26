<?php
// Database configuration
$host = '127.0.0.1';
$dbName = 'dbstatusled';
$username = 'root';
$password = '';

// Connect to the database
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbName", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Get soil moisture level from the sensor
function getMoistureLevel() {
    // Implement your code here to communicate with the sensor and retrieve the moisture level
    $port = '/dev/ttyACM0'; // Replace with the appropriate serial port
    $baudRate = 9600;
    $serial = fopen($port, 'r+');
    if (!$serial) {
        die('Unable to open serial port.');
    }
    // Wait for the microcontroller to initialize
    sleep(2);
    // Read the moisture level from the microcontroller
    fwrite($serial, "READ\n"); // Send a command to read the moisture level
    // Read the response from the microcontroller
    $response = trim(fgets($serial));
    // Close the serial connection
    fclose($serial);
    // Output the moisture level
    echo "Moisture Level: $response";
    // This may involve reading from a serial port, using a GPIO library, or calling an API

    // For example, if you have an API that provides the moisture level:
    $apiEndpoint = 'https://your-api-endpoint.com/moisture';
    $response = file_get_contents($apiEndpoint);
    $data = json_decode($response, true);

    // Assuming the API response contains the moisture level value
    if (isset($data['moisture_level'])) {
        return $data['moisture_level'];
    }
    // Return a default value or handle errors as needed
    return null;
}

// Usage example
$moistureLevel = getMoistureLevel();
if ($moistureLevel !== null) {
    echo "Moisture level: " . $moistureLevel;
} else {
    echo "Unable to retrieve moisture level.";
}

// Check the moisture level and control watering accordingly
if ($moistureLevel > 0.6) {
    // Soil is wet, stop watering the plants
    echo "Soil is wet. Stop watering the plants.";
    // Code to stop watering the plants automatically

    // Simulated moisture value (replace this with the actual sensor reading)
    $moistureLevel = 75; // Assume 75% moisture

    // Threshold moisture level at which watering should stop
    $threshold = 70; // Adjust this value as per your requirement

    // Check if the soil is too wet
    if ($moistureLevel > $threshold) {
        // Stop watering
        stopWatering();
    } else {
        // Continue watering
        continueWatering();
    }   

    // Function to stop watering
    function stopWatering()
    {
        // Code to stop the watering mechanism
        echo "Stop watering the plants!";
    }   

    // Function to continue watering
    function continueWatering()
    {
        // Code to continue watering the plants
        echo "Continue watering the plants!";
    }
}

    // Update the database with the watering status
    $query = "UPDATE sensor_data SET watering_status = 'OFF' WHERE ID = 1";
    $pdo->exec($query);
    if ($moistureLevel < 0.3) {
        // Soil is too dry, water the plants
        echo "Soil is too dry. Watering the plants.";
        // Code to water the plants (e.g., turn on the water pump)

        // Update the database with the watering status
        $query = "UPDATE sensor_data SET watering_status = 'ON' WHERE ID = 1";
        $pdo->exec($query);
    } else {
    // Soil moisture level is within the desired range
    echo "Soil moisture level is optimal.";
    // Code to handle the optimal moisture level case
    
    // Update the database with the watering status
    $query = "UPDATE sensor_data SET watering_status = 'OPTIMAL' WHERE ID = 1";
    $pdo->exec($query);
}

// Close the database connection
$pdo = null;
?>