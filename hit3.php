<!-- filepath: c:\xampp\htdocs\movieticket\moviehit.php -->
<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Check if a movie is selected
if (!isset($_SESSION['movie_name'])) {
    echo "No movie selected.";
    exit();
}

// Get the selected movie name from the session
$movieName = $_SESSION['movie_name'];
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($movieName); ?> Movie Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/0631155e40.js" crossorigin="anonymous"></script>
    <style>
        body {
            background-color: rgb(8, 8, 8);
            font-family: 'Playfair';
            color: white;
        }

        nav a.home:hover {
            background-color: #8a1313;
            border-radius: 5px;
        }

        .navbar-body {
            background: linear-gradient(315deg, black, rgb(154, 9, 9));
        }

        .Top-section {
            position: relative;
            width: 100%;
            height: 70vh;
            overflow: hidden;
            margin-top: 0;
            padding-top: 0;
        }

        .video-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            cursor: pointer;
        }

        .video-container video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .overlay {
            background: rgba(0, 0, 0, 0.5);
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
        }

        .content {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: flex-end;
            height: 100%;
            padding: 20px;
        }

        .poster {
            max-width: 250px;
            margin-right: 30px;
            border-radius: 10px;
            overflow: hidden;
        }

        .poster img {
            width: 100%;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.6);
        }

        .details {
            max-width: 600px;
        }

        .cast-container {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            padding: 20px 0;
        }

        .cast-member {
            width: 120px;
            text-align: center;
        }

        .cast-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            object-position: top;
            border: 2px solid #ddd;
            border-radius: 50%;
            margin-bottom: 10px;
        }

        .cast-details p {
            margin: 0;
            font-size: 14px;
        }

        .cast-details p:first-child {
            font-weight: bold;
        }

    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-body">
        <div class="container">
            <a class="navbar-brand text-white d-flex align-items-center" href="#">
                <img src="logo.png" alt="Logo" width="40" height="30" class="me-3">
                <span class="align-middle">SHOW BUZZ</span>
            </a> 
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav ms-auto">
                    <a class="nav-link active home text-white" href="homepage.php">Home</a>
                    <div class="dropdown">
                        <a href="#" class="nav-link dropdown-toggle d-flex align-items-center" id="profileDropdown" data-bs-toggle="dropdown">
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

    <!-- Top Section -->
    <div class="Top-section">
        <div class="video-container" id="videoWrapper">
            <video id="trailerVideo" autoplay muted>
                <source src="hit3.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
        <div class="overlay"></div>
        <div class="content">
            <div class="poster">
                <img src="https://assets-in.bmscdn.com/iedb/movies/images/mobile/thumbnail/xlarge/hit-the-3rd-case-et00410905-1740556769.jpg" alt="Poster">
            </div>
            <div class="details">
                <h1><?php echo htmlspecialchars($movieName); ?></h1>
                <p><strong>Release Date:</strong>  1 May, 2025</p>
                <div>
                    <span class="badge bg-white text-dark">2D, IMAX 2D</span>
                    <span class="badge bg-white text-dark">Telugu, Kannada, Tamil, Malayalam, Hindi</span>
                    <span class="badge bg-white text-dark">UA 13+</span>
                </div>
                <p><strong>Duration:</strong> 2h 29m</p>
                <p><strong>Genre:</strong> Crime, Mystery, Thriller</p>
                <p><strong>Rating:</strong> 4.0 
                    <i class="fa-solid fa-star" style="color:rgb(248, 200, 9)"></i>
                    <i class="fa-solid fa-star" style="color:rgb(248, 200, 9)"></i>
                    <i class="fa-solid fa-star" style="color:rgb(248, 200, 9)"></i>
                    <i class="fa-solid fa-star" style="color:rgb(248, 200, 9)"></i>
                </p>
                <a href="screens.php"><button class="btn btn-danger">Book Tickets</button></a>
            </div>
        </div>
    </div>

    <!-- Bottom Section -->
    <div class="Bottom-section mt-5 mb-3 m-3">
        <h2><strong>About the movie</strong></h2>
        <p>Watch the Hunter`s Command from the most awaited <?php echo htmlspecialchars($movieName); ?>.</p>
        <hr class="mt-5">   
        <h2><strong>Top Cast</strong></h2>
        <div class="cast-container">
            <div class="cast-member">
                <img src="https://assets-in.bmscdn.com/iedb/artist/images/website/poster/large/nani-7485-1654492137.jpg" class="cast-image"/>
                <div class="cast-details">
                    <p>Nani as Arjun Sarkaar</p>
                    <p>Actor</p>
                </div>
            </div>
            <div class="cast-member">
                <img src="https://assets-in.bmscdn.com/iedb/artist/images/website/poster/large/sreenidhi-22732-19-02-2018-09-47-37.jpg" class="cast-image"/>
                <div class="cast-details">
                    <p>Srinidhi Shetty as Mrudula</p>
                    <p>Actor</p>
                </div>
            </div>
            <div class="cast-member">
                <img src="https://assets-in.bmscdn.com/iedb/artist/images/website/poster/large/samuthirakani-1052542-24-03-2017-17-46-22.jpg" class="cast-image"/>
                <div class="cast-details">
                    <p>Samuthirakani</p>
                    <p>Actor</p>
                </div>
            </div>
            <div class="cast-member">
                <img src="https://assets-in.bmscdn.com/iedb/artist/images/website/poster/large/sailesh-kolanu-2007334-1651641877.jpg" class="cast-image"/>
                <div class="cast-details">
                    <p>Sailesh Kolanu</p>
                    <p>Director, Writer</p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>