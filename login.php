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

$type = $_POST['type'];
$username = $_POST['username'];
$password = $_POST['password'];

if (strlen($password) !== 8) {
    echo "<script>alert('Password must be exactly 8 characters long.'); window.location.href='login.html';</script>";
    exit();
}

if ($type == 'staff') {
    $stmt = $conn->prepare("SELECT * FROM staff WHERE staff_id = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
} else {
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
}

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $_SESSION['username'] = $username; // Set the username in the session
    if ($type == 'staff') {
        echo "<script>alert('Login successful'); window.location.href='staff.html';</script>";
    } else {
        echo "<script>alert('Login successful'); window.location.href='complaint.html';</script>";
    }
} else {
    echo "<script>alert('Invalid username or password'); window.location.href='login.html';</script>";
}

$stmt->close();
$conn->close();
?>