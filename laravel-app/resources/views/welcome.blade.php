<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to FakeBook App</title>

    <!-- Importing CSS from Materio Template using Vite -->
    @vite('resources/assets/vendor/scss/core.scss') <!-- Core styles -->
    @vite('resources/assets/vendor/scss/theme-default.scss') <!-- Theme styles -->
    @vite('resources/css/app.css') <!-- Custom styles -->

    <style>
         .hero-section {
            background-image: url('/images/logo.jpg'); /* Replace with your background image */
            background-size: cover; /* or 'contain' */
            background-position: center;
            background-repeat: no-repeat; /* Prevents the image from repeating */
            height: 100vh;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 0 20px;
        }

        .hero-section h1 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: white; /* Change the heading text color to white */
        }

        .hero-section p {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            color: blue; /* Change the paragraph text color to blue */
        }

        .hero-section .btn {
            padding: 0.75rem 1.5rem;
            font-size: 1.1rem;
            border-radius: 0.3rem;
        }
    </style>
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Social Media Fakebook</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
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
        <div class="container">
            <h1>Connect, Share, and Engage</h1>
            <p>Welcome to our social media platform, where you can connect with friends, share your thoughts, and engage with a vibrant community.</p>
            <a href="{{ route('register') }}" class="btn btn-primary">Join Now</a>
            <a href="{{ route('login') }}" class="btn btn-outline-light">Login</a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container text-center">
            <p>&copy; 2024 Social Media App. All rights reserved.</p>
            <p>
                <a href="#" class="text-white">Privacy Policy</a> |
                <a href="#" class="text-white">Terms of Service</a>
            </p>
        </div>
    </footer>

    <!-- Importing JavaScript files from Materio Template -->
    @vite('resources/assets/vendor/scss/_bootstrap-extended/_include.scss') <!-- Core JavaScript -->
    @vite('resources/js/app.js') <!-- Custom JavaScript -->
</body>
</html>
