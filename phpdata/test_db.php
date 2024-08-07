<?php
// test_db.php

$servername = "localhost";
$username = "root"; // replace with your MySQL username
$password = ""; // replace with your MySQL password (empty in this case)
$dbname = "pos_system"; // the name of your database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully<br>";

$sql = "SELECT * FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"]. " - Name: " . $row["fullname"]. " - Username: " . $row["username"]. " - Role: " . $row["role"]. "<br>";
    }
} else {
    echo "0 results";
}
$conn->close();
?>
