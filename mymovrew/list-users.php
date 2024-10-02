<?php
include 'db.php';
header('Content-Type: application/json');

// Fetching users with id, username, email, and password
$sql = "SELECT id, username, email, password FROM users";
$result = $conn->query($sql);

$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row; // This includes the password in the response
}

// Return the users as JSON, including passwords
echo json_encode(['users' => $users]);

$conn->close();
?>
