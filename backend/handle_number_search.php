<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $number = $_POST['number'];
    $currentTimestamp = date('Y-m-d H:i:s');
    $stmt = $conn->prepare("INSERT INTO numbers (number, views, last_time_viewed, last_review) VALUES (?, 0, ?, ?)");
    $stmt->bind_param("iss", $number, $currentTimestamp, $currentTimestamp);
    $stmt->execute();
    $stmt->close();

    header("Location: number.php?number=" . urlencode($number));
}
?>