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
    $name = $_POST['name'];
    $email = $_POST['mail'];
    $username = $_POST['Uname'];
    $password = $_POST['pass'];
    $confirm_password = $_POST['pass2'];

    // Validate inputs
    if (empty($name) || empty($email) || empty($username) || empty($password) || empty($confirm_password)) {
        die("All fields are required.");
    }

    if ($password !== $confirm_password) {
        die("Passwords do not match.");
    }

    // Insert user into the database
    $sql = "INSERT INTO users (name, email, username, password) VALUES ('$name', '$email', '$username', '$password')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>window.location.href = 'login.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>