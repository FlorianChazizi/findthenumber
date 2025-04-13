<?php
function getDangerRate($conn, $number) {
    $rankWeights = [
        'useful' => 0,
        'safe' => 20,
        'neutral' => 40,
        'annoying' => 60,
        'dangerous' => 100,
    ];

    $query = "
        SELECT comments.rank
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

    $totalWeight = 0;
    $count = 0;

    while ($row = $result->fetch_assoc()) {
        $rank = $row['rank'];
        if (array_key_exists($rank, $rankWeights)) {
            $totalWeight += $rankWeights[$rank];
            $count++;
        }
    }

    $stmt->close();

    if ($count === 0) {
        return null;
    }

    return round($totalWeight / $count);
}
?>
