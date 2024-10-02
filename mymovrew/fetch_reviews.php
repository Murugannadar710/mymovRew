<?php
$servername = "localhost"; // Your database server
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "main"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and execute query
$sql = "SELECT username, movie_title, review, created_at FROM reviews";
$result = $conn->query($sql);

// Prepare array for JSON output
$reviews = array();
while($row = $result->fetch_assoc()) {
    $reviews[] = $row;
}

// Output JSON
header('Content-Type: application/json');
echo json_encode($reviews);

// Close connection
$conn->close();
?>
