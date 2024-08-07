<?php
include "headers.php";

// Get the JSON input
$input = file_get_contents('php://input');
$data = json_decode($input, true);

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

$username = trim($data['username']);
$password = trim($data['password']);

include "connection.php";

// Prepare and execute the query
$stmt = $conn->prepare("SELECT id, fullname, role, password FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($id, $fullname, $role, $stored_password);
$stmt->fetch();

// Verify the password
if ($id && $password === $stored_password) {
    echo json_encode([
        "status" => "success",
        "message" => "Login successful",
        "fullname" => $fullname,
        "role" => $role,
        "id" => $id
    ]);
} else {
    echo json_encode(["status" => "error", "message" => "Invalid username or password"]);
}

$stmt->close();
$conn->close();
?>
