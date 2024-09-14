<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - FakeBook</title>
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
        .nav-link {
            color: #ffffff;
        }
        .nav-link:hover {
            color: #1DA1F2;
        }
        .profile-form {
            background-color: #192734;
            border-radius: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 80px;
        }
        .form-label {
            color: #8899A6;
        }
        .form-control {
            background-color: #253341;
            border-color: #38444d;
            color: #ffffff;
        }
        .form-control:focus {
            background-color: #253341;
            border-color: #1DA1F2;
            color: #ffffff;
            box-shadow: 0 0 0 0.25rem rgba(29, 161, 242, 0.25);
        }
        .btn-primary {
            background-color: #1DA1F2;
            border-color: #1DA1F2;
        }
        .btn-primary:hover {
            background-color: #1a91da;
            border-color: #1a91da;
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

    <div class="container">
        <div class="profile-form">
            <h2 class="mb-4">Edit Profile</h2>
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <form action="<?= site_url('profile/update') ?>" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="first_name" name="first_name" value="<?= esc($user['first_name']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" value="<?= esc($user['last_name']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= esc($user['email']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="bio" class="form-label">Bio</label>
                    <textarea class="form-control" id="bio" name="bio" rows="3"><?= esc($user['bio'] ?? '') ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="profile_picture" class="form-label">Profile Picture</label>
                    <input type="file" class="form-control" id="profile_picture" name="profile_picture" accept="image/*">
                </div>
                <div class="mb-3">
                    <label for="background_picture" class="form-label">Background Picture</label>
                    <input type="file" class="form-control" id="background_picture" name="background_picture" accept="image/*">
                </div>
                <button type="submit" class="btn btn-primary">Update Profile</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>