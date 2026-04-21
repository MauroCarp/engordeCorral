<?php
try {
    // Try connecting with common default settings
    $host = 'localhost';
    $username = 'root'; 
    $password = '';
    
    $mysqli = new mysqli($host, $username, $password);
    
    if ($mysqli->connect_error) {
        die('Connection failed: ' . $mysqli->connect_error);
    }
    
    echo 'Connected successfully to MySQL server' . PHP_EOL;
    
    // Show databases to help identify which one contains insumos table
    $result = $mysqli->query('SHOW DATABASES');
    echo 'Available databases:' . PHP_EOL;
    while ($row = $result->fetch_array()) {
        echo '- ' . $row[0] . PHP_EOL;  
    }
    
    $mysqli->close();
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . PHP_EOL;
}
?>
