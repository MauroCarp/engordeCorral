<?php
try {
    // Connect to MySQL
    $host = 'localhost';
    $username = 'root'; 
    $password = '';
    $database = 'engordecorral'; // Most likely database based on the context
    
    $mysqli = new mysqli($host, $username, $password, $database);
    
    if ($mysqli->connect_error) {
        die('Connection failed: ' . $mysqli->connect_error);
    }
    
    echo 'Connected successfully to MySQL database: ' . $database . PHP_EOL;
    echo '=================================================' . PHP_EOL;
    
    // First, check if the insumos table exists
    $result = $mysqli->query("SHOW TABLES LIKE 'insumos'");
    if ($result->num_rows > 0) {
        echo 'Table "insumos" found!' . PHP_EOL . PHP_EOL;
        
        // Show table structure using DESCRIBE
        echo 'Table structure using DESCRIBE insumos:' . PHP_EOL;
        echo '========================================' . PHP_EOL;
        $result = $mysqli->query('DESCRIBE insumos');
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                printf("Field: %-20s Type: %-20s Null: %-5s Key: %-5s Default: %-10s Extra: %s\n", 
                       $row['Field'], $row['Type'], $row['Null'], $row['Key'], 
                       $row['Default'] ?? 'NULL', $row['Extra']);
            }
        }
        
        echo PHP_EOL . 'Alternative view using SHOW COLUMNS FROM insumos:' . PHP_EOL;
        echo '=================================================' . PHP_EOL;
        $result = $mysqli->query('SHOW COLUMNS FROM insumos');
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                printf("Field: %-20s Type: %-20s Null: %-5s Key: %-5s Default: %-10s Extra: %s\n", 
                       $row['Field'], $row['Type'], $row['Null'], $row['Key'], 
                       $row['Default'] ?? 'NULL', $row['Extra']);
            }
        }
        
    } else {
        echo 'Table "insumos" not found in database "' . $database . '"' . PHP_EOL;
        echo 'Available tables in this database:' . PHP_EOL;
        $result = $mysqli->query('SHOW TABLES');
        while ($row = $result->fetch_array()) {
            echo '- ' . $row[0] . PHP_EOL;
        }
    }
    
    $mysqli->close();
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . PHP_EOL;
}
?>
