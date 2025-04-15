<?php
include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize inputs
    $comment = trim($_POST['comment'] ?? '');
    $rank = $_POST['rank'] ?? '';
    $number_id = trim($_POST['id'] ?? '');

    if ($comment && $rank && $number_id) {
        // Fixed: wrapped `rank` in backticks
        $stmt = $conn->prepare("INSERT INTO comments (number_id, comment, created_at, `rank`) VALUES (?, ?, NOW(), ?)");
        $stmt->bind_param("sss", $number_id, $comment, $rank);

        if ($stmt->execute()) {
            header("Location: " . $_SERVER['REQUEST_URI']);
            exit;
        } else {
            echo "<script>console.error('❌ DB Error: " . addslashes($stmt->error) . "');</script>";
        }

        $stmt->close();
    } else {
        echo "<script>console.warn('⚠️ Missing comment, rank, or number ID');</script>";
    }
}
?>
