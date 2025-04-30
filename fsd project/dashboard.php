<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Finance Tracker</title>
</head>
<body>
    <h2>Welcome, <?php echo $_SESSION['user_name']; ?>!</h2>
    <p>You are logged in as <?php echo $_SESSION['email']; ?>.</p>
    <a href="logout.php">Logout</a>
</body>
</html>
