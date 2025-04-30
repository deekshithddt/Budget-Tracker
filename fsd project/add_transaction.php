<?php
$conn = new mysqli("localhost", "root", "", "fsd");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create table if not exists
$conn->query("CREATE TABLE IF NOT EXISTS transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    description VARCHAR(255),
    amount DECIMAL(10,2),
    type ENUM('income','expense'),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

$description = $_POST['description'];
$amount = $_POST['amount'];
$type = $_POST['type'];

$sql = "INSERT INTO transactions (description, amount, type) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sds", $description, $amount, $type);

if ($stmt->execute()) {
    echo "Transaction added successfully.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
