<?php
// Set database credentials
$db_connection = env('DB_CONNECTION');
$host = env('DB_HOST');
$dbname = env('DB_DATABASE');
$username = env('DB_USERNAME');
$password = env('DB_PASSWORD');

// Create a new PDO instance
try {
     $db = new PDO("{$db_connection}:host={$host};dbname={$dbname}", $username, $password);
     // Set PDO error mode to exceptions
     $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     
     // echo "Connected successfully";
} catch (PDOException $e) {
     die(print_r($e->getMessage()));
}
