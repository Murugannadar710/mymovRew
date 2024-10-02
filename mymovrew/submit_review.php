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

// Retrieve POST data
$user = $_POST['username'];
$movieTitle = $_POST['movieTitle'];
$review = $_POST['review'];

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO reviews (username, movie_title, review) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $user, $movieTitle, $review);

// Execute the statement
if ($stmt->execute()) {
    echo "Review submitted successfully";
} else {
    echo "Error: " . $stmt->error;
}

// Close connection
$stmt->close();
$conn->close();
?>
