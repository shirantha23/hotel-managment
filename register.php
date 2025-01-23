<?php
$host = 'localhost';
$db = 'hotel_management';
$user = 'root'; // Replace with your database username
$pass = ''; // Replace with your database password

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_POST['username'];
$email = $_POST['email'];
$address = $_POST['address'];
$phone = $_POST['phone'];
$country = $_POST['country'];
$room = $_POST['room'];
$password = $_POST['password'];
$hotelPassword = $_POST['hotelPassword'];

if ($hotelPassword !== '123') {
    echo "<script>alert('Invalid hotel password.'); window.location.href='register.html';</script>";
    exit();
}

$stmt = $conn->prepare("INSERT INTO users (username, email, address, phone_number, country, room_number, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssss", $username, $email, $address, $phone, $country, $room, $password);

if ($stmt->execute()) {
    echo "<script>alert('Registration successful'); window.location.href='login.html';</script>";
} else {
    echo "<script>alert('Registration failed. Username might be taken.'); window.location.href='register.html';</script>";
}

$stmt->close();
$conn->close();
?>