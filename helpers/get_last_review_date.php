<?php
function getLastReviewDate($conn, $number) {
    $query = "
        SELECT comments.created_at 
        FROM comments
        INNER JOIN numbers ON comments.number_id = numbers.id
        WHERE numbers.number = ?
        ORDER BY comments.created_at DESC
        LIMIT 1
    ";

    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("s", $number);
    $stmt->execute();
    $result = $stmt->get_result();

    $lastReview = null;
    if ($row = $result->fetch_assoc()) {
        $lastReview = $row['created_at'];
    }

    $stmt->close();

    return $lastReview;
}
?>
