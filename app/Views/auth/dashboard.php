<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - ITE311-MACA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
        }
        .card {
            border: none;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .navbar {
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .navbar-brand {
            font-weight: 600;
            color: #333;
        }
        .nav-link {
            color: #333;
        }
        .btn-primary {
            background-color: #0d6efd;
            border: none;
            padding: 8px 16px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" ?>ITE311-MACA</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    </li>
                </ul>
                <div class="d-flex">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <?= $user['name'] ?>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="<?= base_url('logout') ?>">Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Welcome Section -->
        <div class="card mb-4">
            <div class="card-body">
                <h2 class="h4 mb-3">Welcome, <?= $user['name'] ?>!</h2>
                <p class="text-muted mb-1">Role: <span class="badge bg-primary"><?= ucfirst($user['role']) ?></span></p>
                <p class="mb-0">Email: <?= $user['email'] ?></p>
            </div>
        </div>

        <!-- Dashboard Stats -->
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <h3 class="h5 mb-2">Courses</h3>
                        <p class="h2 mb-0">0</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <h3 class="h5 mb-2">Lessons</h3>
                        <p class="h2 mb-0">0</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <h3 class="h5 mb-2">Quizzes</h3>
                        <p class="h2 mb-0">0</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card mb-4">
            <div class="card-body">
                <h3 class="h5 mb-3">Quick Actions</h3>
                <div class="row g-3">
                    <div class="col-6 col-md-3">
                        <a href="#" class="btn btn-outline-primary w-100 py-2">
                            Browse Courses
                        </a>
                    </div>
                    <div class="col-6 col-md-3">
                        <a href="#" class="btn btn-outline-primary w-100 py-2">
                            Start Learning
                        </a>
                    </div>
                    <div class="col-6 col-md-3">
                        <a href="#" class="btn btn-outline-primary w-100 py-2">
                            Take Quiz
                        </a>
                    </div>
                    <div class="col-6 col-md-3">
                        <a href="#" class="btn btn-outline-secondary w-100 py-2">
                            Edit Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="card">
            <div class="card-body">
                <h3 class="h5 mb-3">Recent Activity</h3>
                <p class="text-muted text-center py-4 mb-0">No recent activity to display.</p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <footer class="bg-light mt-5 py-4">
        <div class="container text-center text-muted">
            <p class="mb-0">&copy; <?= date('Y') ?> ITE311-MACA. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
