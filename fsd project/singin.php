<?php
$host = "localhost";       // Database host
$user = "root";            // Database username
$password = "";            // Database password
$dbname = "signinfsd"; // Database name

// Create database connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create table if it doesn't exist
$table_sql = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    age INT NOT NULL,
    contact VARCHAR(15) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$conn->query($table_sql);

// Process form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $age = intval($_POST['age']);
    $contact = $conn->real_escape_string($_POST['contact']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Encrypt password

    $insert_sql = "INSERT INTO users (name, age, contact, email, password)
                   VALUES ('$name', $age, '$contact', '$email', '$password')";

    if ($conn->query($insert_sql) === TRUE) {
        echo "<script>alert('Sign-in successful! Welcome, $name'); window.location.href = 'index.html';</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "'); window.history.back();</script>";
    }
}

$conn->close();
?>
