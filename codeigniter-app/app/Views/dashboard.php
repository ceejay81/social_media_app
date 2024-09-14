<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - FakeBook</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            background-color: #15202B;
            color: #ffffff;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        }
        .header {
            background-color: rgba(21, 32, 43, 0.9);
            padding: 10px 0;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            border-bottom: 1px solid #38444d;
        }
        .logo {
            color: #1DA1F2;
            font-size: 24px;
            font-weight: bold;
        }
        .profile-cover {
            height: 300px;
            overflow: hidden;
            position: relative;
            margin-top: 60px;
            background-color: #192734;
        }
        .profile-cover-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .profile-cover-container {
            position: relative;
            height: 100%;
            max-width: 1400px;
            margin: 0 auto;
        }
        .profile-container {
            background-color: #15202B;
            padding: 0 15px;
        }
        .profile-header {
            position: relative;
            padding: 15px 0;
        }
        .profile-picture-container {
            position: absolute;
            top: -80px;
            left: 15px;
        }
        .profile-picture {
            width: 134px;
            height: 134px;
            border-radius: 50%;
            border: 4px solid #15202B;
            object-fit: cover;
        }
        .profile-info {
            padding-top: 60px;
        }
        .profile-name {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 2px;
        }
        .profile-handle {
            color: #8899A6;
            font-size: 15px;
            margin-bottom: 10px;
        }
        .profile-bio {
            font-size: 15px;
            line-height: 1.5;
            margin-bottom: 10px;
        }
        .profile-meta {
            display: flex;
            font-size: 15px;
            color: #8899A6;
        }
        .profile-meta-item {
            margin-right: 20px;
        }
        .nav-link {
            color: #ffffff;
        }
        .nav-link:hover {
            color: #1DA1F2;
        }
        .edit-profile-btn {
            background-color: transparent;
            border: 1px solid #1DA1F2;
            color: #1DA1F2;
            border-radius: 20px;
            padding: 6px 16px;
            font-weight: bold;
            float: right;
        }
        .edit-profile-btn:hover {
            background-color: rgba(29, 161, 242, 0.1);
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="header-content">
                <div class="logo">FakeBook</div>
                <nav>
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url('dashboard') ?>"><i class="fas fa-home"></i> Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url('profile') ?>"><i class="fas fa-user"></i> Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url('logout') ?>"><i class="fas fa-sign-out-alt"></i> Logout</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <div class="profile-cover">
        <div class="profile-cover-container">
            <img src="<?= base_url('uploads/' . ($user['background_picture'] ?? 'default-background.jpg')) ?>" alt="Profile Background" class="profile-cover-image">
        </div>
    </div>
    <div class="container">
        <div class="profile-container">
            <div class="profile-header">
                <div class="profile-picture-container">
                    <img src="<?= base_url('uploads/' . ($user['profile_picture'] ?? 'default-avatar.png')) ?>" alt="Profile Picture" class="profile-picture">
                </div>
                <div class="profile-info">
                    <h1 class="profile-name"><?= esc($user['first_name'] . ' ' . $user['last_name']) ?></h1>
                    <p class="profile-handle">@<?= esc($user['username'] ?? 'username') ?></p>
                    <p class="profile-bio"><?= esc($user['bio'] ?? 'No bio available') ?></p>
                    <div class="profile-meta">
                        <span class="profile-meta-item"><i class="fas fa-map-marker-alt"></i> <?= esc($user['location'] ?? 'Location') ?></span>
                        <span class="profile-meta-item"><i class="fas fa-calendar-alt"></i> Joined <?= esc($user['created_at'] ?? 'Date') ?></span>
                    </div>
                    <a href="<?= site_url('profile') ?>" class="btn edit-profile-btn">Edit Profile</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>