<?php
$host = 'localhost';
$db = 'hotel_management';
$user = 'root'; // Replace with your database username
$pass = ''; // Replace with your database password

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'];
$status = $data['status'];

// Update complaint status in the complaints table
$stmt = $conn->prepare("UPDATE complaints SET status = ? WHERE id = ?");
$stmt->bind_param("si", $status, $id);
if ($stmt->execute()) {
    echo "Complaint status updated to $status.";
} else {
    echo "Failed to update complaint status.";
}

$stmt->close();
$conn->close();
?>