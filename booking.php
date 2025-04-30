<!-- filepath: c:\xampp\htdocs\movieticket\booking.php -->
<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Retrieve booking details from session
$movie_name = $_SESSION['movie_name'] ?? 'Unknown Movie';
$theater_name = $_SESSION['theater_name'] ?? 'Unknown Theater';
$show_date = $_SESSION['show_date'] ?? 'Unknown Date';
$show_time = $_SESSION['showtime'] ?? 'Unknown Time';
$selected_seats = $_SESSION['selected_seats'] ?? [];

// Format seat numbers
$seat_numbers = !empty($selected_seats) ? implode(', ', $selected_seats) : 'No seats selected';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Booking Confirmation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    <style>
        body {
            background-image: url(background.png);  
            background-size: cover;  
            font-family: "Playfair";
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .confirmation-box {
            background: #151515;
            padding: 30px;
            text-align: left;
            width: 420px;
            border-radius: 18px;
            box-shadow: 3px 3px 3px #262626;
        }

        h2 {
            color: #df212e;
            font-weight: bold;
            text-align: center;
            margin-bottom: 25px;
        }

        strong {
            display: block;
            font-size: 15px;
            color: #8d929c;
            margin-bottom: 5px;
        }

        p {
            font-size: 18px;
            margin-bottom: 20px;
            color: white;
        }

        .movie-title {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .seat-box {
            background-color: #212121;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 25px;
        }

        .go {
            border-radius: 20px;
        }

        .bottom-text {
            color: #9d9d9d;
            font-size: 16px;
            text-align: center;
            margin-top: 20px;
        }

        hr {
            border-color: #8e8d8d;
        }
    </style>
</head>
<body>
    <div class="confirmation-box">
        <h2><img src="logo.png" alt="Logo" width="40" height="30" class="me-3">Booking Confirmed!</h2>
        <hr>
        <p class="movie-title"><?php echo htmlspecialchars($movie_name); ?></p>
        <p><strong>Theater</strong> <?php echo htmlspecialchars($theater_name); ?></p>
        <p><strong>Date</strong> <?php echo htmlspecialchars($show_date); ?></p>
        <p><strong>Time</strong> <?php echo htmlspecialchars($show_time); ?></p>

        <div class="seat-box">
            <strong>Your Seats</strong>
            <p class="text-danger fw-bold"><?php echo htmlspecialchars($seat_numbers); ?></p>
        </div>
        <hr>
        <center><button class="go btn btn-danger" onclick="goHome()">Go Home</button></center>
        <p class="bottom-text">Enjoy your movie! Please arrive 15 minutes early.</p>
    </div>

    <script>
        window.addEventListener('load', () => {
            confetti({
                particleCount: 150,
                spread: 70,
                origin: { y: 0.6 }
            });
        });

        function goHome() {
            window.location.href = "homepage.php";
        }
    </script>
</body>
</html>