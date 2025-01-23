<?php
session_start();
$host = 'localhost';
$db = 'hotel_management';
$user = 'root'; // Replace with your database username
$pass = ''; // Replace with your database password

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_POST['id'];
$complaint = $_POST['complaint'];

// Update complaint in complaints table
$stmt = $conn->prepare("UPDATE complaints SET complaint = ? WHERE id = ?");
$stmt->bind_param("si", $complaint, $id);
if ($stmt->execute()) {
    echo "<script>alert('Complaint updated successfully'); window.location.href='complaint.html';</script>";
} else {
    echo "<script>alert('Failed to update complaint.'); window.location.href='complaint.html';</script>";
}

$stmt->close();
$conn->close();
?>