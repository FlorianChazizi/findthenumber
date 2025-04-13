<?php

$query = "SELECT number, views, 
          (SELECT COUNT(*) FROM comments WHERE comments.number_id = numbers.id) as comments 
          FROM numbers 
          ORDER BY views DESC 
          LIMIT 10";

$result = $conn->query($query);

$numbers = [];
while ($row = $result->fetch_assoc()) {
    $numbers[] = $row;
}

header('Content-Type: application/json');
echo json_encode(['numbers' => $numbers]);
$conn->close();
?>
