<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "showbuzz";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['mail'];
    $new_password = $_POST['pass1'];
    $confirm_password = $_POST['pass2'];

    // Validate inputs
    if (empty($email) || empty($new_password) || empty($confirm_password)) {
        die("All fields are required.");
    }

    if ($new_password !== $confirm_password) {
        die("Passwords do not match.");
    }

    // Update the user's password in the database
    $sql = "UPDATE users SET password = '$new_password' WHERE email = '$email'";

    if (mysqli_query($conn, $sql)) {
        if (mysqli_affected_rows($conn) > 0) {
            echo "<script>window.location.href = 'login.php';</script>";
        } else {
            echo "<script>alert('Email not found.'); window.location.href = 'forgot.html';</script>";
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>