<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

$servername = "localhost";
$username = "your_user";
$password = "your_password";
$dbname = "pos_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed: " . $conn->connect_error]);
    exit;
}

$bq = $_GET['barcodes'];

$sql = "SELECT barcode, p_name, price FROM products WHERE barcode = ? OR p_name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $bq, $bq);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if ($product) {
    echo json_encode($product);
} else {
    echo json_encode([]);
}

$stmt->close();
$conn->close();
?>
