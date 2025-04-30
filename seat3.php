<!-- filepath: c:\xampp\htdocs\movieticket\seat3.php -->
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
    <title>Theater Seating</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background: #111;
            font-family: Arial, sans-serif;
            color: white;
            text-align: center;
            padding: 20px;
        }
        .legend {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 20px;
        }
        .legend div {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
        }
        .legend-box {
            width: 20px;
            height: 20px;
            border: 2px solid #17a2b8;
            background: black;
        }
        .legend-available {
            background: black;
        }
        .legend-selected {
            background: #17a2b8;
        }
        .legend-booked {
            background: gray;
            border: 2px solid gray;
        }

        .row-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 4px 0;
        }
        .row-label {
            width: 20px;
            margin-right: 10px;
            text-align: right;
            color: #bbb;
        }
        .seat-row {
            display: flex;
        }
        .seat {
            width: 22px;
            height: 22px;
            margin: 2px;
            background-color: black;
            border: 2px solid #17a2b8;
            border-radius: 4px;
            font-size: 12px;
            color: white;
            cursor: pointer;
            user-select: none;
            transition: 0.2s;
        }
        .seat.selected {
            background-color: #17a2b8;
        }
        .seat.booked {
            background-color: gray;
            border: 2px solid gray;
            cursor: not-allowed;
        }
        .gap {
            width: 40px;
        }
        .screen {
            width: 30%;
            margin: 25px auto 10px auto;
            height: 12px;
            background: #ccc;
            color: #000;
            font-weight: bold;
            font-size: 12px;
            line-height: 12px;
            border-radius: 4px;
            box-shadow: 0 0 6px #666;
        }
        .book-btn {
            display: none;
            margin: 20px auto 0;
        }
        button {
            padding: 10px 20px;
            background: #17a2b8;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
        }

        /* Modal Customization */
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
    <div><div class="legend-box legend-available"></div> Available</div>
    <div><div class="legend-box legend-selected"></div> Selected</div>
    <div><div class="legend-box legend-booked"></div> Booked</div>
</div>

<!-- Golden Price Label -->
<div class="price-label">₹250 - Golden Class</div>

<?php
function renderRow($label, $leftCount, $rightCount) {
    echo "<div class='row-wrapper'>";
    echo "<div class='row-label'>$label</div>";
    echo "<div class='seat-row'>";
    for ($i = 1; $i <= $leftCount; $i++) {
        $id = "$label$i";
        echo "<div class='seat' data-id='$id'></div>";
    }
    echo "<div class='gap'></div>";
    for ($i = $leftCount + 1; $i <= $leftCount + $rightCount; $i++) {
        $id = "$label$i";
        echo "<div class='seat' data-id='$id'></div>";
    }
    echo "</div></div>";
}

// Rows A and B – Golden Class
renderRow('A', 6, 10);
renderRow('B', 6, 10);

// Silver Price Label
echo "<div class='price-label'>₹150 - Silver Class</div>";

// Row C (Silver Class – similar to Golden Class style)
renderRow('C', 15, 15);

// Small gap
echo "<div style='margin: 10px 0;'></div>";

// Rows D–K (Silver Class – Left filled)
foreach (['D','E','F','G','H','I','J','K'] as $label) {
    renderRow($label, 20, 0);
}
?>

<!-- Screen at Bottom -->
<div class="screen">SCREEN</div>

<!-- Book Button -->
<form action="seat3.php" method="POST" id="seatForm">
    <div class="book-btn" id="bookBtn">
        <button type="submit">Book Selected Seats</button>
    </div>
    <div id="hiddenInputs"></div>
</form>

<!-- Food Pre-order Modal -->
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
    function redirectToPayment() {
        window.location.href = "payment.php"; // Redirect to payment.php if the user clicks "No, Thanks"
    }

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
            const seatId = seat.getAttribute('data-id');
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