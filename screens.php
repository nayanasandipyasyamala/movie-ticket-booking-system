<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Check if a movie is selected
if (!isset($_SESSION['movie_name'])) {
    header('Location: homepage.php'); // Redirect to homepage if no movie is selected
    exit();
}

// Get the selected movie name from the session
$movieName = $_SESSION['movie_name'];

// Handle theater, showtime, and date selection
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['theater_name'], $_POST['showtime'], $_POST['show_date'])) {
        $_SESSION['theater_name'] = $_POST['theater_name'];
        $_SESSION['showtime'] = $_POST['showtime'];
        $_SESSION['show_date'] = $_POST['show_date'];
        $_SESSION['show_id'] = $_POST['show_id'];
      
        var_dump($_SESSION['show_id']);
        exit();
        // Determine the theater_type based on the selected theater
        $theater_type = 3; // Default theater type
        if ($_POST['theater_name'] === 'JLE Cinemas') {
            $theater_type = 1; // Theater type for JLE Cinemas
        }

        // Store the theater_type in the database (seats table)
        $conn = new mysqli('localhost', 'root', '', 'showbuzz'); // Update with your database credentials
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Insert or update the theater_type in the seats table
        $show_id = 1; // Replace with the actual show_id logic
        $sql = "UPDATE seats SET theater_type = ? WHERE show_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $theater_type, $show_id);
        $stmt->execute();
        $stmt->close();
        $conn->close();

        // Redirect based on the selected theater
        if ($theater_type === 1) {
            header('Location: seat1.php'); // Redirect to seat1.php for JLE Cinemas
        } else {
            header('Location: seat3.php'); // Redirect to seat3.php for other theaters
        }
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo htmlspecialchars($movieName); ?> - Available Shows</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <style>
    body {
      background-color: #111;
      font-family: 'Playfair', serif;
      color: white;
    }

    .date-carousel-wrapper {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      margin-top: 20px;
    }

    .arrow-btn {
      font-size: 2rem;
      background: none;
      color: white;
      border: none;
      cursor: pointer;
    }

    .navbar-body {
      background: linear-gradient(315deg, black, rgb(154, 9, 9));                     
    }

    .date-carousel {
      display: flex;
      gap: 15px;
      overflow: hidden;
      width: 320px;
    }

    .date-box {
      width: 70px;
      height: 80px;
      background-color: #333;
      color: white;
      border-radius: 5px;
      text-align: center;
      padding-top: 8px;
      cursor: pointer;
      flex-shrink: 0;
    }

    .date-box .day {
      font-size: 20px;
      font-weight: bold;
    }

    .date-box .month {
      font-size: 14px;
      color: #ccc;
    }

    .selected {
      background-color: #8a1313;
    }

    .theater-container {
      background-color: #222;
      margin: 15px;
      padding: 15px;
      border-radius: 8px;
      box-shadow: 0px 0px 10px rgba(255, 255, 255, 0.1);
    }

    .showtime-btn {
      padding: 10px 15px;
      border-radius: 5px;
      margin: 10px 10px 0 0;
      background-color: #760e0e;
      color: #cecece;
      font-weight: bold;
      border: 2px solid #951212;
    }
  </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-body">
        <div class="container">
            <a class="navbar-brand text-white d-flex align-items-center" href="#">
                <img src="logo.png" alt="Logo" width="50" height="50" class="me-3">
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
                            <li><a class="dropdown-item" href="#">Edit Profile</a></li>
                            <li><a class="dropdown-item" href="#">Booking History</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="login.php">Log Out</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>
  <div class="container">
    <h1 class="text-center mt-4"><?php echo htmlspecialchars($movieName); ?> - Available Shows</h1>
    <div class="date-carousel-wrapper">
      <button class="arrow-btn" onclick="scrollDates(-1)">&#8249;</button>
      <div class="date-carousel" id="dateCarousel"></div>
      <button class="arrow-btn" onclick="scrollDates(1)">&#8250;</button>
    </div>
    <div id="theater-list"></div>
  </div>

  <script>
    const movieData = {
      0: [
        { name: "CineSquare", location: "Amravathi road", times: ["11:00 AM", "2:00 PM", "5:00 PM"] },
        { name: "JLE Cinemas", location: "Palakaluru Road", times: ["1:30 PM", "4:30 PM"] },
        { name: "Mythri", location: "Phoenix Mall", times: ["3:30 PM", "6:30 PM"] }
      ],
      1: [
        { name: "CineSquare", location: "Amravathi road", times: ["11:00 AM", "5:00 PM"] },
        { name: "JLE Cinemas", location: "Palakaluru Road", times: ["1:00 PM", "4:00 PM"] },
        { name: "Mythri", location: "Phoenix Mall", times: ["3:30 PM", "6:30 PM"] }
      ],
      2: [
    { name: "CineSquare", location: "Amravathi road", times: ["10:00 AM", "1:00 PM", "6:00 PM"] },
    { name: "Mythri", location: "Phoenix Mall", times: ["3:30 PM", "6:30 PM"] }
  ],
  3: [
    { name: "CineSquare", location: "Amravathi road", times: ["11:00 AM", "2:00 PM", "5:00 PM"] },
    { name: "Mythri", location: "Phoenix Mall", times: ["2:00 PM", "5:00 PM"] }
  ],
    };

    const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun","Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

    let currentStart = 0; // index of first visible date
    const visibleCount = 4;
    const totalDates = 4;
    const dateCarousel = document.getElementById("dateCarousel");

    const today = new Date();
    const dateArray = [];

    for (let i = 0; i < totalDates; i++) {
      const tempDate = new Date();
      tempDate.setDate(today.getDate() + i);
      dateArray.push(new Date(tempDate));
    }

    function renderDates() {
      dateCarousel.innerHTML = "";
      for (let i = currentStart; i < currentStart + visibleCount && i < totalDates; i++) {
        const dateObj = dateArray[i];
        const day = dateObj.getDate();
        const month = monthNames[dateObj.getMonth()];
        const dayBox = document.createElement("div");
        dayBox.className = "date-box";
        dayBox.innerHTML = `<div class="day">${day}</div><div class="month">${month}</div>`;
        dayBox.onclick = () => {
          document.querySelectorAll('.date-box').forEach(box => box.classList.remove("selected"));
          dayBox.classList.add("selected");
          updateTheaters(i, `${day} ${month}`);
        };
        if (i === 0) dayBox.classList.add("selected");
        dateCarousel.appendChild(dayBox);
      }
    }

    function scrollDates(direction) {
      if ((direction === -1 && currentStart > 0) || (direction === 1 && currentStart + visibleCount < totalDates)) {
        currentStart += direction;
        renderDates();
      }
    }
    function updateTheaters(dayIndex, selectedDate) {
    const list = document.getElementById("theater-list");
    const theaters = movieData[dayIndex] || [];
    if (theaters.length === 0) {
        list.innerHTML = "<p class='text-center mt-4'>No shows available.</p>";
        return;
    }

    let html = "";
    theaters.forEach((t, theaterIndex) => {
        let times = t.times.map((time, timeIndex) => {
            const show_id = `${dayIndex}-${theaterIndex}-${timeIndex}`; // Generate a unique show_id
            return `
                <form method="POST" action="screens.php" style="display: inline;">
                    <input type="hidden" name="theater_name" value="${t.name}">
                    <input type="hidden" name="showtime" value="${time}">
                    <input type="hidden" name="show_date" value="${selectedDate}">
                    <input type="hidden" name="show_id" value="${show_id}">
                    <button type="submit" class="showtime-btn">${time}</button>
                </form>`;
        }).join("");

        html += `
            <div class="theater-container">
                <div><strong>${t.name}</strong></div>
                <div>${t.location}</div>
                <div class="mt-2">${times}</div>
            </div>`;
    });
    list.innerHTML = html;
}

    renderDates();
    updateTheaters(0, `${dateArray[0].getDate()} ${monthNames[dateArray[0].getMonth()]}`);
  </script>
</body>
</html>