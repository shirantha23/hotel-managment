<?php
session_start();
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Please log in first.'); window.location.href='login.html';</script>";
    exit();
}

$host = 'localhost';
$db = 'hotel_management';
$user = 'root'; // Replace with your database username
$pass = ''; // Replace with your database password

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_SESSION['username'];

// Fetch complaints and messages from complaints and messages tables
$query = "SELECT c.id, c.username, c.area, c.complaint, c.status, GROUP_CONCAT(m.message SEPARATOR '<br>') AS messages 
          FROM complaints c 
          LEFT JOIN messages m ON c.id = m.complaint_id 
          WHERE c.username = ? 
          GROUP BY c.id";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    echo "
    <div class='complaint'>
        <p><strong>Username:</strong> {$row['username']}</p>
        <p><strong>Area:</strong> {$row['area']}</p>
        <p><strong>Complaint:</strong> {$row['complaint']}</p>
        <p><strong>Status:</strong> {$row['status']}</p>
        <p><strong>Messages:</strong><br>{$row['messages']}</p>
    </div>
    <hr>";
}

$stmt->close();
$conn->close();
?>