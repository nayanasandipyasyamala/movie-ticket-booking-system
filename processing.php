<!-- filepath: c:\xampp\htdocs\movieticket\processing.php -->
<?php
var_dump($_SESSION['show_id']);
$show_id = $_SESSION['show_id'] ?? null;
if (!$show_id) {
    echo "Show ID is missing in the session.";
    exit();}
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if total price is set
if (!isset($_POST['total_price'])) {
    header('Location: payment.php'); // Redirect if no payment details are provided
    exit();
}

// Get the total price and payment method (wallet/card/UPI)
$total_price = $_POST['total_price'];
$payment_method = $_POST['paymentMethod'] ?? null; // Use null coalescing to avoid undefined key error

if (!$payment_method) {
    echo "Payment method not selected.";
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "showbuzz";
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assuming user_id is stored in session (if the user is logged in)
if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to process payment.";
    exit();
}

$user_id = $_SESSION['user_id'];

// ✅ Handle free ticket logic
$use_free_ticket = isset($_POST['use_free_ticket']) ? intval($_POST['use_free_ticket']) : 0;

if ($use_free_ticket == 1) {
    $check_subscription = "SELECT free_tickets_remaining FROM subscriptions WHERE user_id = $user_id AND end_date >= CURDATE()";
    $result = $conn->query($check_subscription);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $free_tickets = $row['free_tickets_remaining'];

        if ($free_tickets > 0) {
            $update_ticket = "UPDATE subscriptions SET free_tickets_remaining = free_tickets_remaining - 1 WHERE user_id = $user_id AND end_date >= CURDATE()";
            if (!$conn->query($update_ticket)) {
                echo "Error updating free tickets: " . $conn->error;
                exit();
            }
        }
    }
}


// ✅ Mark seats as booked
if (isset($_SESSION['selected_seats']) && !empty($_SESSION['selected_seats'])) {
    $seats = $_SESSION['selected_seats'];
    $show_id = $_SESSION['show_id'] ?? null; // Ensure show_id is stored in the session
    $booking_date = date('Y-m-d H:i:s'); // Current date and time

    if (!$show_id) {
        echo "Show ID is missing.";
        exit();
    }

    foreach ($seats as $seat) {
        $seat = $conn->real_escape_string($seat); // Sanitize input

        // Insert booking details into the bookings table
        $insert_booking = "INSERT INTO bookings (user_id, show_id, seat_number, booking_date)
                           VALUES ('$user_id', '$show_id', '$seat', '$booking_date')";

        if (!$conn->query($insert_booking)) {
            echo "Error inserting booking: " . $conn->error;
            exit();
        }

        // Update seat status in the seats table
        $conn->query("UPDATE seats SET status='booked' WHERE seat_number='$seat'");
    }
} else {
    echo "No seats selected.";
    exit();
}
$conn->close();

echo "Show ID: " . $show_id; // Debugging
?>

<html>
<head>
    <title>Processing Payment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: rgb(17, 17, 17);
            font-family: "Playfair";
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .processing-container {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="processing-container">
        <h2>Processing Payment...</h2>
        <div class="spinner-border text-light" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <script>
        // Redirect to confirmation page after 5 seconds
        setTimeout(() => {
            window.location.href = "booking.php";
        }, 2000);
    </script>
</body>
</html>