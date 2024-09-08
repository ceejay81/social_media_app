<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to FakeBook - Connect, Share, Engage</title>

    <!-- Importing CSS from Materio Template using Vite -->
    @vite('resources/assets/vendor/scss/core.scss')
    @vite('resources/assets/vendor/scss/theme-default.scss')
    @vite('resources/css/app.css')

    <style>
        .hero-section {
            background-image: linear-gradient(to bottom, #6b46c1, #4834a8),
                              url('/images/mountain-landscape.jpg');
            background-size: cover, cover;
            background-position: center, bottom;
            background-blend-mode: multiply;
            height: 100vh;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 0 20px;
            position: relative;
            overflow: hidden;
        }

        .hero-content {
            max-width: 800px;
            z-index: 2;
        }

        .hero-section h1 {
            font-size: 4rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: #ffffff;
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
        }

        .btn-primary {
            background-color: #4c1d95;
            border-color: #4c1d95;
        }

        .btn-primary:hover {
            background-color: #5b21b6;
            border-color: #5b21b6;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 30%;
            background: linear-gradient(to top, #4c1d95, transparent);
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }

        .floating-element {
            position: absolute;
            animation: float 6s ease-in-out infinite;
        }

        .moon {
            top: 10%;
            right: 10%;
            width: 100px;
            height: 100px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 50%;
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.6);
        }

        .star {
            background-color: #ffffff;
            border-radius: 50%;
            opacity: 0.8;
        }

        .features {
            padding: 4rem 0;
            background-color: #f8f9fa;
        }

        .feature-icon {
            font-size: 3rem;
            color: #4267B2;
            margin-bottom: 1rem;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.6s ease-out forwards;
        }

        .features {
            position: relative;
            overflow: hidden;
        }

        .features::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(
                to bottom right,
                rgba(66, 103, 178, 0.1),
                rgba(66, 103, 178, 0.05),
                rgba(66, 103, 178, 0.1)
            );
            animation: rotate 20s linear infinite;
            z-index: 1;
        }

        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }

        .features .container {
            position: relative;
            z-index: 2;
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
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('images/fakebook-logo.png') }}" alt="FakeBook Logo" class="rounded-full" style="width: 40px; height: 40px; object-fit: cover;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-content">
            <h1>WELCOME TO FAKEBOOK</h1>
            <p>Connect with friends, share your moments, and discover a world of possibilities in our vibrant social network.</p>
            <a href="{{ route('register') }}" class="btn btn-primary">JOIN NOW</a>
        </div>
        <div class="floating-element moon"></div>
        <div class="floating-element star" style="top: 20%; left: 15%; width: 4px; height: 4px;"></div>
        <div class="floating-element star" style="top: 30%; left: 25%; width: 3px; height: 3px;"></div>
        <div class="floating-element star" style="top: 15%; right: 25%; width: 5px; height: 5px;"></div>
    </section>

    <!-- Features Section -->
    <section class="features py-16">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center animate-fadeInUp" style="animation-delay: 0.2s;">
                    <div class="feature-icon mb-4">
                        <i class="fas fa-users text-5xl text-blue-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Connect with Friends</h3>
                    <p class="text-gray-600">Stay in touch with your loved ones and make new connections.</p>
                </div>
                <div class="text-center animate-fadeInUp" style="animation-delay: 0.4s;">
                    <div class="feature-icon mb-4">
                        <i class="fas fa-share-alt text-5xl text-blue-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Share Your Story</h3>
                    <p class="text-gray-600">Post updates, photos, and videos to share your life's moments.</p>
                </div>
                <div class="text-center animate-fadeInUp" style="animation-delay: 0.6s;">
                    <div class="feature-icon mb-4">
                        <i class="fas fa-globe text-5xl text-blue-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Discover Content</h3>
                    <p class="text-gray-600">Explore trending topics and discover interesting content.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container text-center">
            <p>&copy; 2024 FakeBook. All rights reserved.</p>
            <p>
                <a href="#" class="text-white me-3">Privacy Policy</a>
                <a href="#" class="text-white">Terms of Service</a>
            </p>
        </div>
    </footer>

    <!-- Importing JavaScript files -->
    @vite('resources/js/app.js')
    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>
</body>
</html>
