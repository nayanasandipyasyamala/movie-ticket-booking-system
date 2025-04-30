<!-- filepath: c:\xampp\htdocs\movieticket\payment.php -->
<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Retrieve session data
$seats = $_SESSION['selected_seats'] ?? [];
$food_order = $_SESSION['food_order'] ?? [];

// Pricing for seats
$seat_prices = [
    'gold' => 250,
    'silver' => 150,
];

// Calculate total price for seats
$total_price = 0;
foreach ($seats as $seat) {
    if (strpos($seat, 'A') === 0 || strpos($seat, 'B') === 0) { // Rows A and B are Gold
        $total_price += $seat_prices['gold'];
    } else { // Other rows are Silver
        $total_price += $seat_prices['silver'];
    }
}

// Calculate total price for food
$food_total = 0;
if (!empty($food_order)) {
    foreach ($food_order as $item => $quantity) {
        $prices = [
            'popcorn_cold_drink_combo' => 150,
            'nachos' => 120,
            'french_fries' => 100,
            'samosa' => 50,
            'sandwich' => 70,
            'popcorn' => 90,
        ];
        $food_total += $prices[$item] * $quantity;
    }
}

// Calculate GST and grand total
$gst = round(($total_price + $food_total) * 0.09, 2); // 9% GST
$grand_total = $total_price + $food_total + $gst;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Payment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: rgb(17, 17, 17);
            font-family: "Playfair";
            color: white;
        }
        .navbar-body {
            background: linear-gradient(315deg, black, rgb(154, 9, 9));
        }
        .container-box {
            background: #222;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.1);
        }
        strong {
            color: #8d929c;
        }
        h3 {
            color: #a51717;
        }
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            display: none;
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background: #222;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.1);
            width: 300px;
            text-align: center;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-body">
    <div class="container">
        <a class="navbar-brand text-white d-flex align-items-center" href="#">
            <img src="logo.png" alt="Logo" width="40" height="30" class="me-3">
            <span class="align-middle">SHOWBUZZ</span>
        </a> 
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav ms-auto">
                <a class="nav-link active home text-white ms-auto" href="homepage.php">Home</a>
                <div class="dropdown">
                    <a href="#" class="nav-link dropdown-toggle d-flex align-items-center" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://www.vhv.rs/dpng/d/436-4363443_view-user-icon-png-font-awesome-user-circle.png" alt="Profile" width="30" height="30" class="rounded-circle ms-4">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                        <li><a class="dropdown-item" href="wallet.php">Wallet</a></li>
                        <li><a class="dropdown-item" href="subscription.php">Subscription</a></li>
                        <li><a class="dropdown-item" href="#">Wishlist</a></li>
                        <li><a class="dropdown-item" href="#">Booking History</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="login.php">Log Out</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>    

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="container-box mb-4">
                <h3 class="text-center fw-bold">Payment Details</h3>
                <p><strong>Tickets:</strong> <?php echo count($seats); ?> booked</p>
                <p><strong>Subtotal (Seats):</strong> &#8377;<?php echo $total_price; ?></p>
                <?php if (!empty($food_order)): ?>
                    <p><strong>Food Total:</strong> &#8377;<?php echo $food_total; ?></p>
                <?php endif; ?>
                <p><strong>GST (9%):</strong> &#8377;<?php echo $gst; ?></p>
                <p><strong>Total:</strong> &#8377;<?php echo $grand_total; ?></p>
            </div>

            <div class="container-box mt-4">
                <h3 class="text-center fw-bold">Payment Method</h3>
                <form id="paymentForm" method="POST" action="processing.php">
                    <input type="hidden" name="total_price" value="<?php echo $grand_total; ?>">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="paymentMethod" id="card" value="card" onclick="showModal('card')">
                        <label class="form-check-label" for="card">Credit/Debit Card</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="paymentMethod" id="upi" value="upi" onclick="showModal('upi')">
                        <label class="form-check-label" for="upi">UPI</label>
                    </div>
                </form>
                <button class="btn btn-primary w-100 mt-3" onclick="submitPayment()">Pay Now</button>
            </div>
        </div>
    </div>
</div>

<div id="paymentModal" class="modal">
    <div class="modal-content">
        <h4>Enter Payment Details</h4>
        <div id="cardDetails" style="display:none;">
            <input type="text" class="form-control mb-2" placeholder="Card Number (12 digits)" id="cardNumber">
            <input type="text" class="form-control mb-2" placeholder="CVV (3 digits)" id="cvv">
            <div class="d-flex">
                <select class="form-select mb-2 me-2" id="expiryMonth">
                    <option value="" disabled selected>Month</option>
                    <option value="01">01 - January</option>
                    <option value="02">02 - February</option>
                    <option value="03">03 - March</option>
                    <option value="04">04 - April</option>
                    <option value="05">05 - May</option>
                    <option value="06">06 - June</option>
                    <option value="07">07 - July</option>
                    <option value="08">08 - August</option>
                    <option value="09">09 - September</option>
                    <option value="10">10 - October</option>
                    <option value="11">11 - November</option>
                    <option value="12">12 - December</option>
                </select>
                <select class="form-select mb-2" id="expiryYear">
                    <option value="" disabled selected>Year</option>
                    <option value="2025">2025</option>
                    <option value="2026">2026</option>
                    <option value="2027">2027</option>
                    <option value="2028">2028</option>
                    <option value="2029">2029</option>
                </select>
            </div>
        </div>
        <div id="upiDetails" style="display:none;">
            <input type="text" class="form-control mb-2" placeholder="UPI ID" id="upiId">
        </div>
        <button class="btn btn-danger mt-3" onclick="closeModal()">Close</button>
    </div>
</div>

<script>
    function showModal(type) {
        document.getElementById("paymentModal").style.display = "flex";
        if (type === 'card') {
            document.getElementById("cardDetails").style.display = "block";
            document.getElementById("upiDetails").style.display = "none";
        } else if (type === 'upi') {
            document.getElementById("cardDetails").style.display = "none";
            document.getElementById("upiDetails").style.display = "block";
        }
    }

    function closeModal() {
        document.getElementById("paymentModal").style.display = "none";
    }

    function submitPayment() {
        document.getElementById("paymentForm").submit();
    }
</script>
</body>
</html>