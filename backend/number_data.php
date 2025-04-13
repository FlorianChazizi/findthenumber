<?php

if (!isset($_GET['number'])) {
    die("Number not specified.");
}

$number = $_GET['number'];
$currentTimestamp = date('Y-m-d H:i:s');

// Update views and last_time_viewed
$stmt = $conn->prepare("UPDATE numbers SET views = views + 1, last_time_viewed = ? WHERE number = ?");
$stmt->bind_param("si", $currentTimestamp, $number);
$stmt->execute();
$stmt->close();

// Fetch number details
$stmt = $conn->prepare("SELECT * FROM numbers WHERE number = ?");
$stmt->bind_param("i", $number);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
$stmt->close();

if (!$data) {
    die("Number not found.");
}

?>