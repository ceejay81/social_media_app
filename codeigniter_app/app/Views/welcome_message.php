<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to FakeBook!</title>
    <meta name="description" content="A New Social Media Experience - FakeBook">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="/favicon.ico">

    <!-- STYLES -->
    <style>
        * {
            transition: background-color 300ms ease, color 300ms ease;
        }
        *:focus {
            background-color: rgba(221, 72, 20, .2);
            outline: none;
        }
        html, body {
            color: rgba(33, 37, 41, 1);
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji";
            font-size: 16px;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            text-rendering: optimizeLegibility;
        }
        header {
            background-color: rgba(247, 248, 249, 1);
            padding: .4rem 0 0;
        }
        .menu {
            padding: .4rem 2rem;
        }
        header ul {
            border-bottom: 1px solid rgba(242, 242, 242, 1);
            list-style-type: none;
            margin: 0;
            overflow: hidden;
            padding: 0;
            text-align: right;
        }
        header li {
            display: inline-block;
        }
        header li a {
            border-radius: 5px;
            color: rgba(0, 0, 0, .5);
            display: block;
            height: 44px;
            text-decoration: none;
        }
        header li.menu-item a {
            border-radius: 5px;
            margin: 5px 0;
            height: 38px;
            line-height: 36px;
            padding: .4rem .65rem;
            text-align: center;
        }
        header li.menu-item a:hover,
        header li.menu-item a:focus {
            background-color: rgba(221, 72, 20, .2);
            color: rgba(221, 72, 20, 1);
        }
        header .logo {
            float: left;
            height: 44px;
            padding: .4rem .5rem;
        }
        .hero {
            text-align: center;
            padding: 2rem 1rem;
            background-color: rgba(247, 248, 249, 1);
        }
        .hero h1 {
            font-size: 3rem;
            color: rgba(221, 72, 20, 1);
        }
        .hero h2 {
            font-size: 1.5rem;
            color: rgba(33, 37, 41, 0.8);
            font-weight: 300;
        }
        .btn-primary {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            font-size: 1rem;
            color: #ffffff;
            background-color: rgba(221, 72, 20, 1);
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        .btn-primary:hover {
            background-color: rgba(221, 72, 20, .8);
        }
        footer {
            background-color: rgba(221, 72, 20, .8);
            text-align: center;
            padding: 1rem;
            color: #ffffff;
        }
        .logo-circle {
    width: 100px; /* Adjust size as needed */
    height: 100px; /* Adjust size as needed */
    border-radius: 50%; /* Makes the image circular */
    display: block; /* Optional: for centering or other layout adjustments */
    object-fit: cover; /* Ensures the image fills the circular area */
}
    </style>
</head>
<body>
<!-- HEADER: MENU + HERO SECTION -->
<header>
    <div class="menu">
        <ul>
            <li class="logo">
                <a href="/">
                    <img src="/images/logo.png" alt="FakeBook Logo" height="44">
                </a>
            </li>
            <li class="menu-item"><a href="/">Home</a></li>
            <li class="menu-item"><a href="/explore">Explore</a></li>
            <li class="menu-item"><a href="/trending">Trending</a></li>
            <li class="menu-item"><a href="/help">Help Center</a></li>
        </ul>
    </div>
</header>

<!-- HERO SECTION -->
<div class="hero">
    <h1>Welcome to FakeBook!</h1>
    <h2>Your new social media experience starts here</h2>
    <a href="/register" class="btn-primary">Join Now</a>
</div>

<!-- FOOTER -->
<footer>
    <div class="environment">FakeBook &copy; 2024. All rights reserved.</div>
</footer>
</body>
</html>
