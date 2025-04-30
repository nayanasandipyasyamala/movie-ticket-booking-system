<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if (!isset($_SESSION['movie_name'])) {
    header('Location: homepage.php');
    exit();
}

$movie_name = $_SESSION['movie_name'];

$conn = mysqli_connect("localhost", "root", "", "showbuzz");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM movies WHERE title = '$movie_name'";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) === 1) {
    $movie = mysqli_fetch_assoc($result);
} else {
    echo "Movie not found.";
    exit();
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Odela 2 Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/0631155e40.js" crossorigin="anonymous"></script>
    <style>
        body {
            background-color: rgb(8, 8, 8);
            font-family:'Playfair';
            color: white;
        }
        .navbar {
    height: 70px; 
    padding-top: 0;
    padding-bottom: 0;
}

.navbar-brand img {
    height: 90px;
    width: auto;
    object-fit: contain;
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
                <img src="logo.png" alt="Logo" width="50" height="50" class="me-3">
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
                            <li><a class="dropdown-item text-danger" href="login.html">Log Out</a></li>
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
                <source src="odela.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
        <div class="overlay"></div>
        <div class="content">
            <div class="poster">
                <img src="https://assets-in.bmscdn.com/iedb/movies/images/mobile/thumbnail/xlarge/odela-2-et00441350-1744199856.jpg" alt="Poster">
            </div>
            <div class="details">
                <h1>Odela 2</h1>
                <p><strong>Release Date:</strong>17 Apr, 2025</p>
                <div>
                    <span class="badge bg-white text-dark">2D, IMAX 2D</span>
                    <span class="badge bg-white text-dark">Telugu,Hindi</span>
                    <span class="badge bg-white text-dark">UA 16+</span>
                </div>
                <p><strong>Duration:</strong>2h 30m</p>
                <p><strong>Genre: </strong>Supernatural,Thriller</p>
                <p><strong>Rating:</strong> 4.5
                    <i class="fa-solid fa-star" style="color:rgb(248, 200, 9)"></i>
                    <i class="fa-solid fa-star" style="color:rgb(248, 200, 9)"></i>
                    <i class="fa-solid fa-star" style="color:rgb(248, 200, 9)"></i>
                    <i class="fa-solid fa-star" style="color:rgb(248, 200, 9)"></i>
                    <i class="fa-solid fa-star-half-alt" style="color:rgb(248, 200, 9);"></i>
                </p>
                <a href="screens.php"><button class="btn btn-danger">Book Tickets</button></a>
            </div>
        </div>
    </div>

    <!-- Bottom Section -->
    <div class="Bottom-section mt-5 mb-3 m-3">
        <h2><strong>About the movie</strong></h2>
        <p>In the village of Odela, a man abducts and murders newlywed women the day after their wedding. When his wife, Radha, uncovers the horrific truth, she takes justice into her own hands and kills him, later surrendering to the police. In the sequel, his vengeful spirit haunts the village, continuing his reign of terror. A fierce Aghori and devotee of Lord Shiva, Shiva Shakthi, arrives in Odela to confront the dark force and restore peace.</p>
        <hr class="mt-5">   
        <h2><strong>Top Cast</strong></h2>
        <div class="cast-container">
            <div class="cast-member">
                <img src="https://assets-in.bmscdn.com/iedb/artist/images/website/poster/large/tamannaah-bhatia-16842-20-12-2017-04-21-12.jpg" class="cast-image"/>
                <div class="cast-details">
                    <p>Tamannaah Bhatia
                        as Shiva Shakthi</p>
                </div>
            </div>
            <div class="cast-member">
                <img src="https://assets-in.bmscdn.com/iedb/artist/images/website/poster/large/hebah-patel-1045677-1681303218.jpg" class="cast-image"/>
                <div class="cast-details">
                    <p>Hebah Patel
                        as Radha</p>
                </div>
            </div>
            <div class="cast-member">
                <img src="https://assets-in.bmscdn.com/iedb/artist/images/website/poster/large/vasishta-n-simha-30413-1722675055.jpg" class="cast-image"/>
                <div class="cast-details">
                    <p>Vasishta N. Simha
                        as Tirupati</p>
                </div>
            </div>
            <div class="cast-member">
                <img src="https://assets-in.bmscdn.com/iedb/artist/images/website/poster/large/murali-sharma-1083751-16-06-2021-07-21-41.jpg" class="cast-image"/>
                <div class="cast-details">
                    <p>Murali Sharma
                        Actor
                        </p>
                </div>
            </div>
           <div class="cast-member">
            <img src="https://assets-in.bmscdn.com/iedb/artist/images/website/poster/large/ashok-teja-2028082-1684727667.jpg" class="cast-image"/>
            <div class="cast-details">
                <p>Ashok Teja</p>
                <p>Director</p>
            </div>
        </div>
            
        </div>
    </div>

</body>
</html>



