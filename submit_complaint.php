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

$username = $_POST['username'];
$area = $_POST['area'];
$complaint = $_POST['complaint'];

// Check if the username exists in the users table
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Insert complaint into complaints table
    $stmt = $conn->prepare("INSERT INTO complaints (username, area, complaint) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $area, $complaint);
    if ($stmt->execute()) {
        echo "<script>alert('Complaint submitted successfully'); window.location.href='complaint.html';</script>";
    } else {
        echo "<script>alert('Failed to submit complaint.'); window.location.href='complaint.html';</script>";
    }
} else {
    echo "<script>alert('Username not found. Please sign up.'); window.location.href='register.html';</script>";
}

$stmt->close();
$conn->close();
?>