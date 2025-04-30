<!-- filepath: c:\xampp\htdocs\movieticket\seat1.php -->
<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Check if a movie, theater, showtime, and date are selected
if (!isset($_SESSION['movie_name'], $_SESSION['theater_name'], $_SESSION['showtime'], $_SESSION['show_date'])) {
    header('Location: screens.php'); // Redirect to screens if details are missing
    exit();
}

// Handle seat selection
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['seats'])) {
    $_SESSION['selected_seats'] = $_POST['seats']; // Store selected seats in session
    echo "<script>document.addEventListener('DOMContentLoaded', () => { new bootstrap.Modal(document.getElementById('foodModal')).show(); });</script>";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Movie Ticket Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #111;
            color: #fff;
            text-align: center;
            margin: 0;
            padding: 20px;
        }

        .row {
            margin: 8px 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .gap-between-classes {
            height: 30px;
        }

        .seat {
            width: 30px; /* Square shape */
            height: 30px; /* Square shape */
            margin: 2px;
            background-color: black;
            border: 2px solid #00bcd4;
            border-radius: 4px;
            cursor: pointer;
            transition: 0.3s;
        }

        .seat.selected {
            background-color: #00bcd4; /* Blue color for selected seats */
        }

        .seat.booked {
            background-color: gray;
            border-color: gray;
        }

        .space {
            width: 40px;
        }

        .legend {
            display: flex;
            justify-content: center;
            margin-top: 25px;
            gap: 20px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .legend-box {
            width: 30px; /* Match seat size */
            height: 30px; /* Match seat size */
            border-radius: 4px;
        }

        .available-box {
            background-color: black;
            border: 2px solid #00bcd4;
        }

        .selected-box {
            background-color: #00bcd4;
        }

        .booked-box {
            background-color: gray;
        }

        .screen {
            width: 60%;
            height: 6px;
            background: #ccc;
            margin: 40px auto 10px;
            border-radius: 4px;
            transform: skewX(-25deg);
            box-shadow: 0 0 10px #aaa;
        }

        .price-label {
            color: gray;
            font-size: 14px;
            border-top: 1px dotted gray;
            width: fit-content;
            margin: 20px auto 5px;
            padding-top: 5px;
        }

        #bookBtn {
            display:none;
            margin-top: 30px;
            padding: 10px 30px;
            font-size: 16px;
            background-color: #00bcd4;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s, transform 0.2s;
            text-align: center; /* Ensure text is centered */
    width: fit-content; /* Prevent the button from stretching */
    margin-left: auto; /* Center the button horizontally */
    margin-right: auto;
        }

        #bookBtn:hover {
            background-color: #0097a7;
            transform: scale(1.05); /* Slightly enlarge on hover */
        }
        .modal-content {
            background-color: black;
            color: white;
        }
        .modal-dialog {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
    </style>
</head>
<body>

<h2>Choose Your Seats</h2>

<!-- Legend -->
<div class="legend">
    <div class="legend-item"><div class="legend-box available-box"></div> Available</div>
    <div class="legend-item"><div class="legend-box selected-box"></div> Selected</div>
    <div class="legend-item"><div class="legend-box booked-box"></div> Booked</div>
</div>

<?php
$goldRows = ['A', 'B'];
$silverRows30 = ['C', 'D']; // 30 seats (15 + 15)
$silverRows20 = ['E', 'F', 'G', 'H', 'I', 'J']; // 20 seats (10 + 10)

function renderPriceLabel($label) {
    echo "<div class='price-label'>₹$label - tickets </div>";
}


function renderRow($row, $totalSeats) {
    echo "<div class='row'>";
    echo "<div style='width:30px; text-align:right; margin-right:5px;'>$row</div>";
    $left = floor($totalSeats / 2);
    $right = $totalSeats - $left;

    for ($i = 0; $i < $left; $i++) {
        echo "<div class='seat' data-seat='$row" . chr(65 + $i) . "'></div>";
    }

    echo "<div class='space'></div>";

    for ($i = 0; $i < $right; $i++) {
        echo "<div class='seat' data-seat='$row" . chr(65 + $left + $i) . "'></div>";
    }

    echo "</div>";
}

// Golden Class
renderPriceLabel("250");
foreach ($goldRows as $row) {
    renderRow($row, 30);
}

// Gap between classes
echo "<div class='gap-between-classes'></div>";

// Silver Class
renderPriceLabel("150");

// First 2 Silver Rows with 30 seats
foreach ($silverRows30 as $row) {
    renderRow($row, 30);
}

// Remaining Silver Rows with 20 seats
foreach ($silverRows20 as $row) {
    renderRow($row, 20);
}
?>

<!-- Screen at the bottom -->
<div class="screen"></div>

<!-- Book button -->
<form action="food.php" method="POST" id="seatForm">
    <div class="book-btn" id="bookBtn">
        <button type="submit">Book Selected Seats</button>
    </div>
    <div id="hiddenInputs"></div>
</form>

<div class="modal fade" id="foodModal" tabindex="-1" aria-labelledby="foodModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="foodModalLabel">Pre-order Food</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Would you like to pre-order food for your movie?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="redirectToPayment()">No, Thanks</button>
                <a href="food.php" class="btn btn-primary">Yes, Pre-order</a>
            </div>
        </div>
    </div>
</div>

<script>
    const seats = document.querySelectorAll('.seat:not(.booked)');
    const bookBtn = document.getElementById('bookBtn');
    const form = document.getElementById('seatForm');
    const hiddenInputs = document.getElementById('hiddenInputs');

    seats.forEach(seat => {
        seat.addEventListener('click', () => {
            seat.classList.toggle('selected');
            const selectedSeats = document.querySelectorAll('.seat.selected');
            bookBtn.style.display = selectedSeats.length > 0 ? 'block' : 'none';
        });
    });

    form.addEventListener('submit', function (e) {
        // Clear old inputs
        hiddenInputs.innerHTML = '';

        // Add inputs for selected seats
        const selectedSeats = document.querySelectorAll('.seat.selected');
        selectedSeats.forEach(seat => {
            const seatId = seat.getAttribute('data-seat');
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'seats[]';
            input.value = seatId;
            hiddenInputs.appendChild(input);
        });
    });
</script>

</body>
</html>