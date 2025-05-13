<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <style>
    body {
      font-family: sans-serif;
      background: #f0f0f0;
      padding: 20px;
    }
    .dashboard {
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      max-width: 800px;
      margin: auto;
    }
  </style>
</head>
<body>
  <div class="dashboard">
    <h1>Welcome, <?= htmlspecialchars($_SESSION['username']) ?></h1>
    <p>This is your admin dashboard.</p>
    <ul>
      <li><a href="/manage-numbers.php">Manage Numbers</a></li>
      <li><a href="/manage-comments.php">Moderate Comments</a></li>
      <li><a href="/logout.php">Logout</a></li>
    </ul>
  </div>
</body>
</html>
