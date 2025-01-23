<?php
$host = 'localhost';
$db = 'hotel_management';
$user = 'root'; // Replace with your database username
$pass = ''; // Replace with your database password

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$new_staff_id = $_POST['new_staff_id'];
$new_password = $_POST['new_password'];

if (strlen($new_password) !== 8) {
    echo "<script>alert('Password must be exactly 8 characters long.'); window.location.href='staff.html';</script>";
    exit();
}

$stmt = $conn->prepare("INSERT INTO staff (staff_id, password) VALUES (?, ?)");
$stmt->bind_param("ss", $new_staff_id, $new_password);

if ($stmt->execute()) {
    echo "<script>alert('Staff member added successfully'); window.location.href='staff.html';</script>";
} else {
    echo "<script>alert('Failed to add staff member.'); window.location.href='staff.html';</script>";
}

$stmt->close();
$conn->close();
?>