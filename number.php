<?php
include 'db_config.php';

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

<!DOCTYPE html>
<html>
<head>
    <title>Number <?php echo htmlspecialchars($number); ?></title>
    <link rel="stylesheet" href="styles/number.css">

</head>
<body>
    <h1>Number: <?php echo htmlspecialchars($data['number']); ?></h1>
    <p><strong>Views:</strong> <?php echo $data['views']; ?></p>
    <p><strong>Created At:</strong> <?php echo $data['created_at']; ?></p>
    <p><strong>Updated At:</strong> <?php echo $data['updated_at']; ?></p>
    <p><strong>Last Time Viewed:</strong> <?php echo $data['last_time_viewed']; ?></p>
    <p><strong>Last Review:</strong> <?php echo $data['last_review'] ?: 'Never'; ?></p>
    <a href="index.php">← Back</a>
</body>
</html>

<?php $conn->close(); ?>
