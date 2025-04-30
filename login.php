<?php
session_start(); // Start the session

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

$errorMessage = ""; // Initialize error message

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = mysqli_real_escape_string($conn, $_POST["mail"]);
    $password = mysqli_real_escape_string($conn, $_POST["pass"]);

    // Query to check user credentials
    $sql = "SELECT user_id FROM users WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $row['user_id']; // Set session variable with the user ID
        header("Location: homepage.php"); // Redirect to homepage upon successful login
        exit();
    } else {
        $errorMessage = "Invalid email or password."; // Handle incorrect login credentials
    }
    mysqli_close($conn); // Close the database connection
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .logincard {
            background: linear-gradient(315deg, black, rgb(154, 9, 9));
            width: 350px;
            margin-top: 160px;
            box-shadow: 5px 5px 5px rgb(30,30,30);
            padding: 25px;
            border-radius: 15px;
            height: 430px;
            font-family: "Playfair";
        }
        .login-form-button {
            width: 75%;
        }
        .login-form-button:hover {
            background-color: rgb(214, 214, 214);
            color: white;
        }
        .forgot {
            text-decoration: none;
            font-size: 12px;
            color: white;
            display: block;
            text-align: right;
        }
        .loginpage {
            background-image: url(background.png);
            background-size: cover;
            height: 100vh;
        }
        .error {
            color: white;
            font-size: 13px;
        }
        b:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="loginpage d-flex flex-row justify-content-center">
    <div class="logincard">
        <form method="POST" action="">
            <h2 class="text-white text-center mb-4">Login</h2>
            <input type="text" class="form-control mb-2" id="mail" name="mail" placeholder="Email" value="<?php echo isset($_POST['mail']) ? htmlspecialchars($_POST['mail']) : ''; ?>">
            <p class="error"><?php echo isset($errorMessage) && !empty($errorMessage) ? $errorMessage : ''; ?></p>
            <input type="password" class="form-control mb-2 mt-4" name="pass" id="passw" placeholder="Password">
            <a href="forgot.html" class="forgot"><b>Forgot Password?</b></a>
            <div class="text-start mt-2">
                <input type="checkbox">
                <label class="text-white">Remember me</label>
            </div>
            <div class="text-center mb-3">
                <button type="submit" class="btn btn-light text-danger login-form-button mt-2">Sign In</button><br>
            </div>
            <center>
                <a href="signup.html" style="text-decoration: none; font-size: 13px; color: white;">
                    Don't have an Account? <b>Sign Up</b>
                </a>
            </center>
        </form>
    </div>
</div>
</body>
</html>