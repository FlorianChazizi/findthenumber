<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../db_config.php';


header('Content-Type: application/json');

$query = "SELECT number, views, 
          (SELECT COUNT(*) FROM comments WHERE comments.number_id = numbers.id) as comments 
          FROM numbers 
          ORDER BY last_time_viewed DESC 
          LIMIT 10";

$result = $conn->query($query);

if (!$result) {
    echo json_encode(['error' => $conn->error]);
    exit;
}

$numbers = [];
while ($row = $result->fetch_assoc()) {
    $numbers[] = $row;
}

echo json_encode(['numbers' => $numbers]);
$conn->close();
exit;
?>
