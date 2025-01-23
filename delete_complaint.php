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

// Delete complaint from the complaints table
$stmt = $conn->prepare("DELETE FROM complaints WHERE id = ?");
$stmt->bind_param("i", $id);
if ($stmt->execute()) {
    echo "Complaint deleted successfully.";
} else {
    echo "Failed to delete complaint.";
}

$stmt->close();
$conn->close();
?>