<?php
// Include DB connection
require_once 'DBconnection.php';

// Initialize message variable
$message = '';

// Check if request is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from POST request
    $email = $_POST['email'];
    $password = $_POST['password'];
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $phone = $_POST['phone'];

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if email already exists
    $checkEmailQuery = "SELECT * FROM Users WHERE email = '$email'";
    $result = $conn->query($checkEmailQuery);

    if ($result->num_rows > 0) {
        // Email already exists
        $message = "Account with email '$email' already exists. Please use a different email.";
    } else {
        // Begin transaction for atomic operations
        $conn->begin_transaction();

        // Insert into Users table
        $sqlUsers = "INSERT INTO Users (email, password_hash)
                     VALUES ('$email', '$hashedPassword')";

        if ($conn->query($sqlUsers) === TRUE) {
            // Insert into Profiles table using last inserted user_id
            $userId = $conn->insert_id;
            $sqlProfiles = "INSERT INTO Profiles (user_id, first_name, last_name, phone_number)
                            VALUES ('$userId', '$firstName', '$lastName', '$phone')";

            if ($conn->query($sqlProfiles) === TRUE) {
                // Commit transaction if both inserts are successful
                $conn->commit();
                // Registration successful, set message for display
                $message = "Registration successful!";
            } else {
                // Rollback transaction if Profiles insert fails
                $conn->rollback();
                $message = "Error inserting into Profiles table: " . $conn->error;
            }
        } else {
            // Registration failed
            $message = "Error inserting into Users table: " . $conn->error;
            // Rollback transaction if Users insert fails
            $conn->rollback();
        }
    }

    // Close connection
    $conn->close();
}

// Store the message in session to pass it to the HTML page
session_start();
$_SESSION['message'] = $message;

// Redirect back to the form page
header("Location: Login-Signup.php");
exit();
?>
