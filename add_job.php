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
$job = $data['job'];
$cost = $data['cost'];

// Update complaint with job and cost in the complaints table
$stmt = $conn->prepare("UPDATE complaints SET job = ?, cost = ? WHERE id = ?");
$stmt->bind_param("ssi", $job, $cost, $id);
if ($stmt->execute()) {
    echo "Job and cost added to complaint.";
} else {
    echo "Failed to add job and cost to complaint.";
}

$stmt->close();
$conn->close();
?>