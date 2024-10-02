<?php
// Include the database connection
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate the inputs
    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match'); window.location.href = 'register.html';</script>";
        exit();
    }

    // Insert the user data into the database without hashing the password
    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";

    // Prepare and bind the statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $email, $password); // Bind the plain password

    if ($stmt->execute()) {
        // Registration successful, redirect to login
        echo "<script>alert('Registration successful!'); window.location.href = 'login.html';</script>";
    } else {
        // Handle errors (e.g., duplicate email)
        echo "<script>alert('Error: " . $stmt->error . "'); window.location.href = 'register.html';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
