<?php
session_start();

include('../db_config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM admins WHERE username = ? LIMIT 1"; // Assuming you have a 'users' table with a 'username' column

    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("s", $username); // "s" means the parameter is a string

        $stmt->execute();

        $result = $stmt->get_result();

        $user = $result->fetch_assoc();

        // If user is found and password matches
        if ($user && $password === $user['password']) {
            // Set session variable and redirect to the dashboard
            $_SESSION['user_id'] = $user['id']; // Example, you can store other user details in the session
            $_SESSION['username'] = $user['username']; // Store username in session
            header("Location: ../dashboard.php");
            exit; // Ensure the script stops here after redirection
        } else {
            header("Location: ../login.php?error=Invalid username or password.");
            exit; // Ensure the script stops here after redirection
        }
    } else {
        die("Error preparing statement: " . $conn->error);
    }
}
?>
