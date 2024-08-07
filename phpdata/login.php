<?php
include "headers.php";

// Get the JSON input
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Debug: Log the received data
error_log("Received data: " . print_r($data, true));

// Check for JSON errors
if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(["status" => "error", "message" => "Invalid JSON input"]);
    exit;
}

// Validate input
if (!isset($data['username']) || !isset($data['password'])) {
    echo json_encode(["status" => "error", "message" => "Username and password are required"]);
    exit;
}

$username = trim($data['username']); // trim whitespace
$password = trim($data['password']); // trim whitespace

include "connection.php";

// Prepare and execute the query
$stmt = $conn->prepare("SELECT id, fullname, role, password FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($id, $fullname, $role, $stored_password);
$stmt->fetch();

// Debug: Log the fetched data
error_log("Fetched data: ID - $id, Fullname - $fullname, Role - $role, Password - $stored_password");

// Verify the password
if ($id && $password === $stored_password) {
    error_log("Login successful");
    echo json_encode([
        "status" => "success",
        "message" => "Login successful",
        "fullname" => $fullname,
        "role" => $role,
        "id" => $id
    ]);
} else {
    error_log("Login failed: Invalid username or password");
    echo json_encode(["status" => "error", "message" => "Invalid username or password"]);
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
