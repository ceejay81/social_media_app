<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to FakeBook - Connect, Share, Engage</title>

    <!-- Importing CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/core.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/theme-default.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/app.css') ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Arial', sans-serif;
        }
        .hero-section {
            background-image: linear-gradient(to bottom, rgba(26, 35, 126, 0.7), rgba(74, 20, 140, 0.7)),
                              url('<?= base_url('assets/images/mountain-landscape.jpg') ?>');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .hero-content {
            max-width: 800px;
            z-index: 2;
            padding: 20px;
        }
        .hero-section h1 {
            font-size: 4rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }
        .hero-section p {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            color: #e0e0e0;
        }
        .btn {
            padding: 0.75rem 1.5rem;
            font-size: 1.1rem;
            border-radius: 30px;
            text-transform: uppercase;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        .btn-primary {
            background-color: #4c1d95;
            border: none;
            color: white;
        }
        .btn-primary:hover {
            background-color: #5b21b6;
        }
        .moon {
            position: absolute;
            top: 10%;
            right: 10%;
            width: 100px;
            height: 100px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 50%;
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.6);
        }
        #stars, #shootingStars {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 1;
        }
        .star {
            position: absolute;
            background-color: #ffffff;
            border-radius: 50%;
            opacity: 0.8;
        }
        .shooting-star {
            position: absolute;
            height: 2px;
            background: linear-gradient(to right, rgba(255,255,255,0) 0%, rgba(255,255,255,1) 50%, rgba(255,255,255,0) 100%);
            animation: shoot 3s linear infinite;
        }
        @keyframes shoot {
            from {
                transform: translateX(-100px) translateY(100px);
            }
            to {
                transform: translateX(calc(100vw + 100px)) translateY(calc(-100vh - 100px));
            }
        }
        .navbar {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            z-index: 10;
            background-color: transparent;
            padding: 1rem 0;
        }
        .navbar-dark .navbar-nav .nav-link {
            color: #ffffff;
            font-weight: 600;
        }
        .navbar-dark .navbar-nav .nav-link:hover {
            color: #e0e0e0;
        }
        .features {
            background-color: #f8f9fa;
            padding: 4rem 0;
        }
        .feature-icon {
            font-size: 3rem;
            color: #4267B2;
            margin-bottom: 1rem;
        }
        .features h3 {
            color: #333;
        }
        .features p {
            color: #666;
        }
        footer {
            background-color: #343a40;
            color: #ffffff;
            padding: 2rem 0;
        }
        footer a {
            color: #ffffff;
            text-decoration: none;
        }
        footer a:hover {
            color: #e0e0e0;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="<?= base_url('assets/images/fakebook-logo.png') ?>" alt="FakeBook Logo" class="rounded-full" style="width: 40px; height: 40px; object-fit: cover;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('login') ?>">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('register') ?>">Register</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div id="stars"></div>
        <div id="shootingStars"></div>
        <div class="hero-content">
            <h1>WELCOME TO FAKEBOOK</h1>
            <p>Connect with friends, share your moments, and discover a world of possibilities in our vibrant social network.</p>
            <a href="<?= site_url('register') ?>" class="btn btn-primary">JOIN NOW</a>
        </div>
        <div class="floating-element moon"></div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="container">
            <div class="row">
                <div class="col-md-4 text-center mb-4">
                    <div class="feature-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>Connect with Friends</h3>
                    <p>Stay in touch with your loved ones and make new connections.</p>
                </div>
                <div class="col-md-4 text-center mb-4">
                    <div class="feature-icon">
                        <i class="fas fa-share-alt"></i>
                    </div>
                    <h3>Share Your Story</h3>
                    <p>Post updates, photos, and videos to share your life's moments.</p>
                </div>
                <div class="col-md-4 text-center mb-4">
                    <div class="feature-icon">
                        <i class="fas fa-globe"></i>
                    </div>
                    <h3>Discover Content</h3>
                    <p>Explore trending topics and discover interesting content.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <p>&copy; 2024 FakeBook. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <a href="#" class="me-3">Privacy Policy</a>
                    <a href="#">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Importing JavaScript files -->
    <script src="<?= base_url('js/app.js') ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <script>
        function createStars() {
            const stars = document.getElementById('stars');
            for (let i = 0; i < 200; i++) {
                const star = document.createElement('div');
                star.className = 'star';
                star.style.width = `${Math.random() * 3}px`;
                star.style.height = star.style.width;
                star.style.left = `${Math.random() * 100}%`;
                star.style.top = `${Math.random() * 100}%`;
                stars.appendChild(star);
            }
        }

        function createShootingStars() {
            const shootingStars = document.getElementById('shootingStars');
            setInterval(() => {
                const shootingStar = document.createElement('div');
                shootingStar.className = 'shooting-star';
                shootingStar.style.width = `${Math.random() * 200 + 100}px`;
                shootingStar.style.left = `${Math.random() * 100}%`;
                shootingStar.style.top = `${Math.random() * 100}%`;
                shootingStars.appendChild(shootingStar);
                setTimeout(() => {
                    shootingStar.remove();
                }, 3000);
            }, 2000);
        }

        document.addEventListener('DOMContentLoaded', () => {
            createStars();
            createShootingStars();
        });
    </script>
</body>
</html>
