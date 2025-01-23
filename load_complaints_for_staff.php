<?php
$host = 'localhost';
$db = 'hotel_management';
$user = 'root'; // Replace with your database username
$pass = ''; // Replace with your database password

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch complaints from the complaints table
$query = "SELECT * FROM complaints";
$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
    $complaintId = $row['id'];
    $messagesQuery = "SELECT message FROM messages WHERE complaint_id = $complaintId";
    $messagesResult = $conn->query($messagesQuery);
    $messages = [];
    while ($messageRow = $messagesResult->fetch_assoc()) {
        $messages[] = $messageRow['message'];
    }

    $messagesHtml = implode('<br>', $messages);

    echo "
    <div class='complaint'>
        <p><strong>Username:</strong> {$row['username']}</p>
        <p><strong>Area:</strong> {$row['area']}</p>
        <p><strong>Complaint:</strong> {$row['complaint']}</p>
        <p><strong>Status:</strong> {$row['status']}</p>
        <p><strong>Messages:</strong><br> $messagesHtml</p>
        <input type='checkbox' onclick='markResolved({$row['id']}, this)' " . ($row['status'] == 'resolved' ? 'checked' : '') . "> Mark as resolved
        <button onclick='sendMessage({$row['id']})'>Send Message</button>
        <button onclick='deleteComplaint({$row['id']})'>Delete</button>
    </div>
    <hr>";
}

$conn->close();
?>