<?php
session_start();
$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
// Unset the message after retrieving it
unset($_SESSION['message']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taste.it</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <div class="form-container sign-up-container">
            <form id="registerForm" action="Regester.php" method="POST">
                <h1>Create Account</h1>
                <input type="text" placeholder="First Name" name="first_name" id="registerFname" required/>
                <input type="text" placeholder="Last Name" name="last_name" id="registerLname" required/>
                <input type="email" placeholder="Email" name="email" id="registerEmail" required/>
                <input type="text" placeholder="Phone Number" name="phone" id="registerPhone"/>
                <input type="password" placeholder="Password" name="password" id="registerPassword" required/>
                <button type="submit">Register</button>
            </form>
        </div>
        <div class="form-container sign-in-container">
            <form id="loginForm" action="Login.php" method="POST">
                <h1>Sign in</h1>
                <input type="email" placeholder="Email" name="email" id="loginEmail" required/>
                <input type="password" placeholder="Password" name="password" id="loginPassword" required/>
                <button type="submit">Login</button>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Welcome Back!</h1>
                    <p>To keep connected with us please login with your personal info</p>
                    <button class="ghost" id="signIn">Sign In</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Hello, Food Lover!</h1>
                    <p>Enter your personal details and start your journey with us</p>
                    <button class="ghost" id="signUp">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript file inclusion -->
    <script src="script.js"></script>
    <script>
        // JavaScript to show alert message if it exists
        document.addEventListener('DOMContentLoaded', (event) => {
            var message = <?php echo json_encode($message); ?>;
            if (message) {
                alert(message);
            }
        });
    </script>
</body>
</html>
