<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$conn = mysqli_connect("localhost", "root", "", "showbuzz");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle movie selection
if (isset($_POST['movie_name'])) {
    $_SESSION['movie_name'] = $_POST['movie_name']; // Store selected movie in session

    // Map movie names to their respective pages
    $moviePages = [
        'Hit 3' => 'hit3.php',
        'Mad Square' => 'mad.php',
        'Odela 2' => 'odela.php',
        'jack' => 'jack.php',
        'Arjun S/O Vyjayanthi'=> 'sov.php',
    ];

    // Redirect to the corresponding movie-specific page
    $redirectPage = isset($moviePages[$_POST['movie_name']]) ? $moviePages[$_POST['movie_name']] : 'default-movie.php';
    header("Location: $redirectPage");
    exit();
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Homepage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: rgb(17, 17, 17);
            font-family: "Playfair";
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

        nav a {
            text-decoration: none;
        }

        nav a.home:hover {
            background-color: #8a1313;
            border-radius: 5px;
        }

        .carousel {
            max-width: 1300px;
            margin: auto;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }

        .carousel-image {
            border-radius: 10px;
            height: 400px;
            width: 100%;
            object-fit: cover;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 50%;
            padding: 10px;
        }

        .carousel-indicators button {
            background-color: #555;
        }

        .card1-image {
            border-radius: 20px;
            padding: 10px;
            height: 350px;
            min-width: 260px;
            object-fit: cover;
        }

        .home-heading {
            color: #8d929c;
            font-weight: bold;
            font-size: 30px;
        }

        .navbar-body {
            background: linear-gradient(315deg, black,rgb(154,9,9));
        }

        .custom-search-input {
            background-color: #1f1f1f;
            border: 1px solid #444;
            color: white;
            border-radius: 20px;
            padding: 8px 15px;
            transition: 0.3s;
            width: 200px;
        }

        .custom-search-input::placeholder {
            color: #aaa;
        }

        .custom-search-input:focus {
            outline: none;
            box-shadow: 0 0 5px #8a1313;
            border-color: #8a1313;
            background-color: #2a2a2a;
        }

        .custom-search-btn {
            background-color: #eee3e3;
            border: none;
            border-radius: 50%;
            padding: 8px 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: 0.3s;
        }

        .custom-search-btn:hover {
            background-color: #a91a1a;
            box-shadow: 0 0 8px rgba(255, 0, 0, 0.4);
        }

        .search-form {
            display: flex;
            align-items: center;
            margin-bottom: 0;
        }
        .custom-search-input {
    color: white !important;
}


        .scroll-arrow {
            position: absolute;
            top: 40%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.6);
            border: none;
            color: white;
            font-size: 24px;
            padding: 10px;
            border-radius: 50%;
            cursor: pointer;
            z-index: 10;
            transition: background-color 0.3s ease;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .left-arrow {
            left: 5px;
        }

        .right-arrow {
            right: 5px;
        }

        .scroll-container {
            overflow-x: auto;
            display: flex;
            flex-wrap: nowrap;
            scroll-behavior: smooth;
            padding: 10px 0;
        }

        .scroll-container::-webkit-scrollbar {
            display: none;
        }
    </style>
</head>
<body>
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
            <div class="navbar-nav ms-auto d-flex align-items-center">
                <a class="nav-link active home text-white me-3" href="homepage.php">Home</a>

                <form class="search-form me-3" role="search">
                    <input class="form-control custom-search-input me-2" type="search" placeholder="Search movies..." aria-label="Search">
                    <button class="btn custom-search-btn" type="submit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85zm-5.242 1.106a5.5 5.5 0 1 1 0-11.001 5.5 5.5 0 0 1 0 11z" />
                        </svg>
                    </button>
                </form>

                <div class="dropdown">
                    <a href="#" class="nav-link dropdown-toggle d-flex align-items-center" id="profileDropdown" role="button" data-bs-toggle="dropdown">
                        <img src="https://www.vhv.rs/dpng/d/436-4363443_view-user-icon-png-font-awesome-user-circle.png" alt="Profile" width="30" height="30" class="rounded-circle">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
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



<div id="carouselExampleIndicators" class="carousel slide mt-4" data-bs-ride="carousel" data-bs-interval="2500">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="https://www.coca-cola.com/content/dam/onexp/in/en/homepage/Schweppes%20CCI%20Website%20Banner_2560%20X%201208%20Pix_Updated.jpg/width1960.jpg" class="d-block carousel-image" alt="Ad 1">
        </div>
        <div class="carousel-item">
            <img src="https://www.royalenfield.com/content/dam/royal-enfield/super-meteor-650/motorcycles/super-meteor-650-desktop_new.jpg" class="d-block carousel-image" alt="Ad 2">
        </div>
        <div class="carousel-item">
            <img src="https://i.ytimg.com/vi/sB67kk5JNXI/maxresdefault.jpg" class="d-block carousel-image" alt="Ad 3">
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>

<div class="container mt-4">
    <h4 class="home-heading">Recommended Movies</h4>
    <div class="position-relative">
        <div class="scroll-container" id="recommendedScroll">
       
    <form method="POST" action="homepage.php" style="display: inline;">
        <input type="hidden" name="movie_name" value="Hit 3">
        <button type="submit" style="border: none; background: none; padding: 0;">
            <img src="https://upload.wikimedia.org/wikipedia/en/0/09/HIT_-_The_Third_Case.jpg" class="card1-image" />
        </button>
    </form>
    <form method="POST" action="homepage.php" style="display: inline;">
        <input type="hidden" name="movie_name" value="Arjun S/O Vyjayanthi">
        <button type="submit" style="border: none; background: none; padding: 0;">
            <img src="https://assets-in.bmscdn.com/discovery-catalog/events/tr:w-400,h-600,bg-CCCCCC:w-400.0,h-660.0,cm-pad_resize,bg-000000,fo-top:l-image,i-discovery-catalog@@icons@@like_202006280402.png,lx-24,ly-617,w-29,l-end:l-text,ie-MTcuMksgTGlrZXM%3D,fs-29,co-FFFFFF,ly-612,lx-70,pa-8_0_0_0,l-end/et00438469-pwsrymlwpn-portrait.jpg" class="card1-image" />
        </button>
    </form>
    <form method="POST" action="homepage.php" style="display: inline;">
        <input type="hidden" name="movie_name" value="Mad Square">
        <button type="submit" style="border: none; background: none; padding: 0;">
            <img src="https://m.media-amazon.com/images/M/MV5BNjBkZmI5NWUtOGQxZS00MzgxLThkOGEtZmMwZDY0ZGM2OWUyXkEyXkFqcGc@._V1_.jpg" class="card1-image" />
        </button>
    </form>
    <form method="POST" action="homepage.php" style="display: inline;">
        <input type="hidden" name="movie_name" value="Odela 2">
        <button type="submit" style="border: none; background: none; padding: 0;">
            <img src="https://assets-in.bmscdn.com/discovery-catalog/events/tr:w-400,h-600,bg-CCCCCC:w-400.0,h-660.0,cm-pad_resize,bg-000000,fo-top:l-image,i-discovery-catalog@@icons@@like_202006280402.png,lx-24,ly-617,w-29,l-end:l-text,ie-MTMuMksgTGlrZXM%3D,fs-29,co-FFFFFF,ly-612,lx-70,pa-8_0_0_0,l-end/et00441350-rafzjbnfyz-portrait.jpg" class="card1-image" />
        </button>
    </form>
    <form method="POST" action="homepage.php" style="display: inline;">
        <input type="hidden" name="movie_name" value="jack">
        <button type="submit" style="border: none; background: none; padding: 0;">
            <img src="https://assets-in.bmscdn.com/discovery-catalog/events/tr:w-400,h-600,bg-CCCCCC:w-400.0,h-660.0,cm-pad_resize,bg-000000,fo-top:l-image,i-discovery-catalog@@icons@@star-icon-202203010609.png,lx-24,ly-615,w-29,l-end:l-text,ie-Ny4xLzEwICAzLjNLIFZvdGVz,fs-29,co-FFFFFF,ly-612,lx-70,pa-8_0_0_0,l-end/et00425214-lzwxxghzxh-portrait.jpg"  class="card1-image"/>
        </button>
    </form>
    <form method="POST" action="homepage.php" style="display: inline;">
        <input type="hidden" name="movie_name" value="Goodbad">
        <button type="submit" style="border: none; background: none; padding: 0;">
            <img src="https://assets-in.bmscdn.com/discovery-catalog/events/tr:w-400,h-600,bg-CCCCCC:w-400.0,h-660.0,cm-pad_resize,bg-000000,fo-top:l-image,i-discovery-catalog@@icons@@star-icon-202203010609.png,lx-24,ly-615,w-29,l-end:l-text,ie-OC42LzEwICA2OS4zSyBWb3Rlcw%3D%3D,fs-29,co-FFFFFF,ly-612,lx-70,pa-8_0_0_0,l-end/et00431346-wwjzwyrhrp-portrait.jpg"  class="card1-image"/>
        </button>
    </form>
    <button class="scroll-arrow left-arrow" onclick="scrollLeft()">&#10094;</button>
    <button class="scroll-arrow right-arrow" onclick="scrollRight()">&#10095;</button>
    
</div>
    </div>
    <div class="container mt-4">
    <h4 class="home-heading">Upcoming Movies</h4>
    <div class="position-relative">
        <div class="scroll-container" id="upcomingScroll">
            <form method="POST" action="homepage.php" style="display: inline;">
                <input type="hidden" name="movie_name" value="Kingdom">
                <button type="submit" style="border: none; background: none; padding: 0;">
                    <img src="https://assets-in.bmscdn.com/iedb/movies/images/mobile/thumbnail/xlarge/kingdom-et00433664-1740734137.jpg" class="card1-image" />
                </button>
            </form>
            <form method="POST" action="homepage.php" style="display: inline;">
                <input type="hidden" name="movie_name" value="Kannappa">
                <button type="submit" style="border: none; background: none; padding: 0;">
                    <img src="https://upload.wikimedia.org/wikipedia/en/e/ed/Kannappa_%28film%29.jpg" class="card1-image" />
                </button>
            </form>
            <form method="POST" action="homepage.php" style="display: inline;">
                <input type="hidden" name="movie_name" value="Hari Hara Veera Mallu">
                <button type="submit" style="border: none; background: none; padding: 0;">
                    <img src="https://assets-in.bmscdn.com/iedb/movies/images/mobile/thumbnail/xlarge/hari-hara-veera-mallu-et00308207-26-08-2021-04-26-29.jpg" class="card1-image" />
                </button>
            </form>
            <form method="POST" action="homepage.php" style="display: inline;">
                <input type="hidden" name="movie_name" value="Mass Jathara">
                <button type="submit" style="border: none; background: none; padding: 0;">
                    <img src="https://assets-in.bmscdn.com/iedb/movies/images/mobile/thumbnail/xlarge/mass-jathara-et00418116-1738044882.jpg" class="card1-image" />
                </button>
            </form>
        </div>
        <button class="scroll-arrow left-arrow" onclick="scrollLeft('upcomingScroll')">&#10094;</button>
        <button class="scroll-arrow right-arrow" onclick="scrollRight('upcomingScroll')">&#10095;</button>
    </div>
</div>

<div class="container mt-4">
    <h4 class="home-heading">Rereleases</h4>
    <div class="position-relative">
        <div class="scroll-container" id="rereleasesScroll">
            <form method="POST" action="homepage.php" style="display: inline;">
                <input type="hidden" name="movie_name" value="Jalsa">
                <button type="submit" style="border: none; background: none; padding: 0;">
                    <img src="https://rukminim2.flixcart.com/image/832/832/av-media/movies/g/7/y/jalsa-original-imadd5zsvhzqyfnd.jpeg?q=70&crop=false" class="card1-image" />
                </button>
            </form>
            <form method="POST" action="homepage.php" style="display: inline;">
                <input type="hidden" name="movie_name" value="Aditya 369">
                <button type="submit" style="border: none; background: none; padding: 0;">
                    <img src="https://images.vcinema.com/attachments/bf8367f0-578a-11ea-9ddb-02f113d3ceb6-aditya-369-movie-listing-1.jpg" class="card1-image" />
                </button>
            </form>
            <form method="POST" action="homepage.php" style="display: inline;">
                <input type="hidden" name="movie_name" value="Yevade Subramanyam">
                <button type="submit" style="border: none; background: none; padding: 0;">
                    <img src="https://sund-images.sunnxt.com/7736/250x375_YevadeSubramanyam_7736_69bf54b7-fa3b-4510-8533-29faef956d34.jpg" class="card1-image" />
                </button>
            </form>
        </div>
        <button class="scroll-arrow left-arrow" onclick="scrollLeft('rereleasesScroll')">&#10094;</button>
        <button class="scroll-arrow right-arrow" onclick="scrollRight('rereleasesScroll')">&#10095;</button>
    </div>
</div>

<script>
    function scrollLeft() {
        document.getElementById('recommendedScroll').scrollBy({
            left: -300,
            behavior: 'smooth'
        });
    }

    function scrollRight() {
        document.getElementById('recommendedScroll').scrollBy({
            left: 300,
            behavior: 'smooth'
        });
    }
</script>
<footer class="bg-dark text-white text-center p-2 mt-4">
            <div class="container p-3">
                <p>&copy; 2025 SHOWBUZZ. All Rights Reserved.</p>
                <p>
                    <a href="#" class="text-white p-2">Privacy Policy</a>
                    <a href="#" class="text-white p-2">Terms of Service</a>
                    <a href="#" class="text-white p-2">Contact Us</a>
                </p>
                <div class="mt-2 p-2">
                    <a href="https://www.facebook.com/" class="text-white icon-circle">
                        <i class="fa-brands fa-facebook-f"></i> 
                    </a>
                    <a href="https://x.com/?lang=en-in" class="text-white  icon-circle">
                        <i class="fab fa-twitter"></i> 
                    </a>
                    <a href="https://www.instagram.com/" class="text-white icon-circle">
                        <i class="fab fa-instagram"></i> 
                    </a>
                </div>
            </div>
 </footer>
</body>
</html>
