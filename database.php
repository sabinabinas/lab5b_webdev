<?php
// Database connection settings
$host = "localhost";       
$username = "root";        
$password = "";            
$dbname = "lab_5b";        

// Establish connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Return connection if needed elsewhere
return $conn;
?>
