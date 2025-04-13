<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../db_config.php';


header('Content-Type: application/json');

$query = "SELECT numbers.number, 
                 (SELECT COUNT(*) FROM comments WHERE comments.number_id = numbers.id) AS comments
          FROM numbers
          ORDER BY numbers.created_at DESC 
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
