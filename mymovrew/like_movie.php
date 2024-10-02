<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection parameters
$servername = "localhost";  // Replace with your server name
$username = "root";         // Replace with your database username
$password = "";             // Replace with your database password
$dbname = "main";           // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the movie ID from POST request
$movieId = isset($_POST['movie_id']) ? intval($_POST['movie_id']) : 0;

if ($movieId <= 0) {
    $response = array('status' => 'error', 'message' => 'Invalid movie ID.');
    echo json_encode($response);
    exit();
}

// Prepare and execute query
$stmt = $conn->prepare("SELECT like_count FROM movies WHERE id = ?");
$stmt->bind_param("i", $movieId);
$stmt->execute();
$stmt->bind_result($like_count);
$stmt->fetch();
$stmt->close();

if ($like_count === null) {
    $response = array('status' => 'error', 'message' => 'Movie not found.');
    echo json_encode($response);
    exit();
}

// Increment like count
$new_like_count = $like_count + 1;

$stmt = $conn->prepare("UPDATE movies SET like_count = ? WHERE id = ?");
$stmt->bind_param("ii", $new_like_count, $movieId);
$result = $stmt->execute();

$response = array();
if ($result) {
    $response['status'] = 'success';
    $response['message'] = 'Like counted!';
} else {
    $response['status'] = 'error';
    $response['message'] = 'Failed to update like count.';
}

header('Content-Type: application/json');
echo json_encode($response);

$stmt->close();
$conn->close();
?>
