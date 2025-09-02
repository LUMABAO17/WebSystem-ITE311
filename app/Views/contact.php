<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<<<<<<< HEAD
    <title>Contact - ITE311 MACA</title>
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
=======
    <title>Contact - ITE311</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
            padding: 20px;
            background: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin-top: 20px;
        }
        nav {
            background: #333;
            color: #fff;
            padding: 10px 0;
        }
        nav ul {
            padding: 0;
            list-style: none;
            text-align: center;
        }
        nav ul li {
            display: inline;
            margin: 0 15px;
        }
        nav ul li a {
            color: #fff;
            text-decoration: none;
        }
        h1 {
            color: #333;
        }
        .contact-form {
            max-width: 600px;
            margin: 20px auto;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .form-group textarea {
            height: 150px;
        }
        button {
            background: #333;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background: #555;
>>>>>>> 93a09e5307e0f02cc1dbf798a06b1a8fc5edd195
        }
    </style>
</head>
<body>
<<<<<<< HEAD
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
                        <a class="nav-link" href="<?= base_url('about') ?>">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="<?= base_url('contact') ?>">Contact</a>
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
                        <h2 class="mb-4">Contact Us</h2>
                        <p class="text-muted mb-4">Have a question or feedback? Reach out to us.</p>
                        
                        <form class="mb-4">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Message</label>
                                <textarea class="form-control" id="message" rows="4" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                Send Message
                            </button>
                        </form>
                        
                        <hr class="my-4">
                        
                        <div class="row text-center">
                            <div class="col-md-4 mb-3 mb-md-0">
                                <p class="mb-1 fw-bold">Email</p>
                                <p class="text-muted mb-0">itee.edu.ph</p>
                            </div>
                            <div class="col-md-4 mb-3 mb-md-0">
                                <p class="mb-1 fw-bold">Phone</p>
                                <p class="text-muted mb-0">+63 (98) 141-7869</p>
                            </div>
                            <div class="col-md-4">
                                <p class="mb-1 fw-bold">Location</p>
                                <p class="text-muted mb-0">IT Department, RMMC</p>
                            </div>
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
=======
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul>
    </nav>
    <div class="container">
        <h1>Contact Us</h1>
        <div class="contact-form">
            <form action="/submit-contact" method="post">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="message">Message:</label>
                    <textarea id="message" name="message" required></textarea>
                </div>
                <button type="submit">Send Message</button>
            </form>
        </div>
    </div>
>>>>>>> 93a09e5307e0f02cc1dbf798a06b1a8fc5edd195
</body>
</html>
