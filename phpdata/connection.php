<?php
$servername = "localhost";
$dbname = "pos_system"; // The name of your database
$db_username = "your_user"; // Your MySQL username
$db_password = "your_password"; // Your MySQL password

// Create connection
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    error_log("Database connection failed: " . $conn->connect_error);
    echo json_encode(["status" => "error", "message" => "Database connection failed"]);
    exit;
}

// Debug: Check if connection is successful
error_log("Database connection established");