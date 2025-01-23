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
$complaintId = $data['id'];
$message = $data['message'];

// Insert message into messages table
$stmt = $conn->prepare("INSERT INTO messages (complaint_id, message) VALUES (?, ?)");
$stmt->bind_param("is", $complaintId, $message);
if ($stmt->execute()) {
    echo "Message sent successfully.";
} else {
    echo "Failed to send message.";
}

$stmt->close();
$conn->close();
?>