<?php
$servername = "localhost";
$db_username = "root"; // replace with your MySQL username
$db_password = ""; // replace with your MySQL password (empty in this case)
$dbname = "pos_system"; // the name of your database

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
