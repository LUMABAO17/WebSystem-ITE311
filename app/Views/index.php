<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - ITE311 MACA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            line-height: 1.6;
        }
        
        .navbar {
            background: #fff !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .navbar-brand {
            font-weight: 700;
            color: #0d6efd !important;
        }
        
        .nav-link {
            font-weight: 500;
            color: #333 !important;
        }
        
        .nav-link:hover, .nav-link.active {
            color: #0d6efd !important;
        }
        
        .hero-section {
            background: #0d6efd;
            color: white;
            padding: 4rem 0;
            margin-bottom: 2rem;
        }
        
        .feature-card {
            background: white;
            border: 1px solid #eee;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            height: 100%;
            transition: all 0.3s ease;
        }
        
        .feature-card:hover {
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .feature-icon {
            font-size: 2rem;
            color: #0d6efd;
            margin-bottom: 1rem;
        }
        
        footer {
            background: #343a40;
            color: white;
            padding: 2rem 0;
            margin-top: 3rem;
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
                        <a class="nav-link active" href="<?= base_url('/') ?>">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('about') ?>">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('contact') ?>">Contact</a>
                    </li>
                </ul>
                <div class="d-flex">
                    <?php if (session()->get('isLoggedIn')): ?>
                        <div class="dropdown">
                            <a class="btn btn-outline-primary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user me-2"></i> <?= session()->get('name') ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="<?= base_url('dashboard') ?>">Dashboard</a></li>
                                <li><a class="dropdown-item" href="<?= base_url('profile') ?>">Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="<?= base_url('logout') ?>">Logout</a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a href="<?= base_url('login') ?>" class="btn btn-outline-primary me-2">
                            Login
                        </a>
                        <a href="<?= base_url('register') ?>" class="btn btn-primary">
                            Register
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container text-center py-5">
            <h1 class="display-4 fw-bold mb-4">Welcome to ITE Learning Management System</h1>
            <p class="lead mb-4">Your gateway to quality IT education and skill development</p>
            <?php if (!session()->get('isLoggedIn')): ?>
                <a href="<?= base_url('register') ?>" class="btn btn-light btn-lg me-2">
                    Get Started
                </a>
                <a href="#features" class="btn btn-outline-light btn-lg">
                    Learn More
                </a>
            <?php else: ?>
                <a href="<?= base_url('dashboard') ?>" class="btn btn-light btn-lg">
                    Go to Dashboard
                </a>
            <?php endif; ?>
        </div>
    </section>

    <!-- Features Section -->
    <div class="container py-5" id="features">
        <div class="text-center mb-5">
            <h2 class="mb-3">Our Features</h2>
            <p class="text-muted">Simple and effective learning solutions</p>
        </div>
        
        <div class="row">
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-laptop-code"></i>
                    </div>
                    <h4>IT Courses</h4>
                    <p>Learn the latest technologies and programming languages.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-book"></i>
                    </div>
                    <h4>Lessons</h4>
                    <p>Access well-structured lessons and tutorials.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-question-circle"></i>
                    </div>
                    <h4>Quizzes</h4>
                    <p>Test your knowledge with our assessment tools.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>ITE Learning Management System</h5>
                    <p class="mb-0">Providing quality IT education for students</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">&copy; <?= date('Y') ?> ITE311 MACA. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
                        