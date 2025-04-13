<?php
function getReviewCount($conn, $number) {
    $query = "
        SELECT COUNT(*) AS total_reviews
        FROM comments
        INNER JOIN numbers ON comments.number_id = numbers.id
        WHERE numbers.number = ?
    ";

    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("s", $number);
    $stmt->execute();
    $result = $stmt->get_result();

    $count = 0;
    if ($row = $result->fetch_assoc()) {
        $count = $row['total_reviews'];
    }

    $stmt->close();

    return $count;
}
?>
