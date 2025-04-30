<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "sigfsd"; // You can use the same DB as signin

// Create connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create the table if it doesn't exist
$createTableSQL = "CREATE TABLE IF NOT EXISTS contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$conn->query($createTableSQL);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST["name"]);
    $email = $conn->real_escape_string($_POST["email"]);
    $message = $conn->real_escape_string($_POST["message"]);

    $insertSQL = "INSERT INTO contacts (name, email, message)
                  VALUES ('$name', '$email', '$message')";

    if ($conn->query($insertSQL) === TRUE) {
        echo "<script>alert('Thank you, $name! Your message has been received.'); window.location.href = 'index.html';</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "'); window.history.back();</script>";
    }
}

$conn->close();
?>
