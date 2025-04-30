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
    <title>Arjun S/O Vyjayanthi Details</title>
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
                <source src="sov.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
        <div class="overlay"></div>
        <div class="content">
            <div class="poster">
                <img src="https://assets-in.bmscdn.com/discovery-catalog/events/tr:w-400,h-600,bg-CCCCCC:w-400.0,h-660.0,cm-pad_resize,bg-000000,fo-top:l-image,i-discovery-catalog@@icons@@star-icon-202203010609.png,lx-24,ly-615,w-29,l-end:l-text,ie-OC45LzEwICA0NzYgVm90ZXM%3D,fs-29,co-FFFFFF,ly-612,lx-70,pa-8_0_0_0,l-end/et00438469-cyxdmzaamx-portrait.jpg" alt="Poster">
            </div>
            <div class="details">
                <h1>Arjun S/O Vyjayanthi</h1>
                <p><strong>Release Date:</strong>18 Apr, 2025</p>
                <div>
                    <span class="badge bg-white text-dark">2D, IMAX 2D</span>
                    <span class="badge bg-white text-dark">Telugu</span>
                    <span class="badge bg-white text-dark">UA 16+</span>
                </div>
                <p><strong>Duration:</strong>2h 24m</p>
                <p><strong>Genre: </strong>Action,Drama,Thriller</p>
                <p><strong>Rating:</strong> 3.0 
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
        <p>A sincere police officer faces her toughest battle in the form of her son. As their beliefs collide, a gripping drama unfolds, putting both their ideologies and their bond to the ultimate test.</p>
        <hr class="mt-5">   
        <h2><strong>Top Cast</strong></h2>
        <div class="cast-container">
            <div class="cast-member">
                <img src="https://assets-in.bmscdn.com/iedb/artist/images/website/poster/large/nandamuri-kalyan-ram-2877-1659164694.jpg" class="cast-image"/>
                <div class="cast-details">
                    <p>Nandamuri Kalyan Ram
                        as Arjun</p>
                </div>
            </div>
            <div class="cast-member">
                <img src="https://in.bmscdn.com/iedb/artist/images/website/poster/large/vijayashanti-iein020721-24-03-2017-17-46-38.jpg" class="cast-image"/>
                <div class="cast-details">
                    <p>Vijayashanti
                        as Vyjayanthi</p>
                </div>
            </div>
            <div class="cast-member">
                <img src="https://assets-in.bmscdn.com/iedb/artist/images/website/poster/large/meka-srikanth-1047571-24-10-2017-01-49-35.jpg" class="cast-image"/>
                <div class="cast-details">
                    <p>Meka Srikanth</p>
                    <p>Actor</p>
                </div>
            </div>
            <div class="cast-member">
                <img src="https://in.bmscdn.com/iedb/artist/images/website/poster/large/saiee-manjrekar-29522-12-11-2019-02-42-51.jpg" class="cast-image"/>
                <div class="cast-details">
                    <p>Saiee Manjrekar</p>
                    <p>Actor</p>
                </div>
            </div>
           <div class="cast-member">
            <img src="https://assets-in.bmscdn.com/iedb/artist/images/website/poster/large/pradeep-chilukuri-1065979-1742220986.jpg" class="cast-image"/>
            <div class="cast-details">
                <p>Pradeep Chilukuri</p>
                <p>Director</p>
            </div>
        </div>
            
        </div>
    </div>

</body>
</html>
