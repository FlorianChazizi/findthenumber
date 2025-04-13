<?php
$servername = "148.251.246.9";
$username = "exnet8_telesto";
$password = "Sqa1214WEQ";
$dbname = "exnet8_telesto";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>