<?php

$numberId = $data['id'] ?? ''; // or use $data['id'] if available
$comments = [];

if ($numberId) {
    $stmt = $conn->prepare("SELECT comment, `rank`, created_at FROM comments WHERE number_id = ? ORDER BY created_at DESC");
    $stmt->bind_param("s", $numberId);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $comments[] = $row;
    }

    $stmt->close();
}
?>