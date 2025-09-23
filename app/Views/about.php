<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About - ITE311 MACA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .btn-primary {
            background-color: #0d6efd;
            border: none;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white mb-4">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url('/') ?>">
                <i class="fas fa-graduation-cap me-2"></i> ITE311-MACA
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/') ?>">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="<?= base_url('about') ?>">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('contact') ?>">Contact</a>
                    </li>
                </ul>
                <div class="d-flex">
                    <?php if (session()->get('isLoggedIn')): ?>
                        <a href="<?= base_url('dashboard') ?>" class="btn btn-outline-primary me-2">Dashboard</a>
                        <a href="<?= base_url('logout') ?>" class="btn btn-outline-secondary">Logout</a>
                    <?php else: ?>
                        <a href="<?= base_url('login') ?>" class="btn btn-outline-primary me-2">Login</a>
                        <a href="<?= base_url('register') ?>" class="btn btn-primary">Register</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-body p-4">
                        <h2 class="mb-4">About ITE311-MACA</h2>
                        <p class="text-muted mb-4">A learning management system designed for Information Technology Education</p>
                        
                        <p>We offer easy-to-follow courses, lessons, and quizzes to help IT students learn and improve their skills. Our platform provides a comprehensive learning experience tailored for both beginners and advanced learners in the field of Information Technology.</p>
                        
                        <div class="text-center mt-5">
                            <?php if (!session()->get('isLoggedIn')): ?>
                                <a href="<?= base_url('register') ?>" class="btn btn-primary me-2">
                                    Get Started
                                </a>
                                <a href="<?= base_url('contact') ?>" class="btn btn-outline-secondary">
                                    Contact Us
                                </a>
                            <?php else: ?>
                                <a href="<?= base_url('dashboard') ?>" class="btn btn-primary">
                                    Go to Dashboard
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-light border-top mt-5 py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>ITE311-MACA</h5>
                    <p class="text-muted">Learning Management System</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="text-muted mb-0">&copy; <?= date('Y') ?> ITE311 MACA. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
