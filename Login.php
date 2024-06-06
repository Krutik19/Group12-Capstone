<?php
// Include DB connection
require_once 'DBconnection.php';

// Initialize message variable
$message = '';

// Start session
session_start();

// Check if request is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from POST request
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    // Query to get user data
    $sql = "SELECT * FROM Users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User found
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password_hash'])) {
            // Password is correct
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['email'] = $row['email'];
            header("Location: home.php");
            exit();
        } else {
            // Password is incorrect
            $message = "Incorrect password.";
        }
    } else {
        // User not found
        $message = "No account found with that email.";
    }

    // Close connection
    $conn->close();
}

// Store the message in session to pass it to the HTML page
$_SESSION['message'] = $message;

// Redirect back to the form page
header("Location: Login-Signup.php");
exit();
?>
