<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= csrf_hash() ?>">
    <title>Register - ITE311 MACA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
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
        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }
        .password-strength {
            margin-top: 0.25rem;
            font-size: 0.875rem;
        }
        .password-strength .progress {
            height: 5px;
            margin-top: 5px;
        }
        .password-requirements {
            font-size: 0.8rem;
            margin-top: 0.5rem;
            color: #6c757d;
        }
        .password-requirements ul {
            padding-left: 1.2rem;
            margin-bottom: 0;
        }
        .password-requirements li {
            margin-bottom: 0.25rem;
        }
        .password-requirements .valid {
            color: #198754;
        }
        .password-requirements .invalid {
            color: #6c757d;
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
        </div>
    </nav>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card mb-4">
                    <div class="card-body p-4">
                        <h2 class="text-center mb-4">Create Account</h2>
                        <?php if (session()->getFlashdata('success')): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?= esc(session()->getFlashdata('success')) ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= esc(session()->getFlashdata('error')) ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('errors')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0">
                                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                        <li class="small"><?= esc($error) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <form id="registerForm" action="<?= base_url('register') ?>" method="POST" novalidate>
                            <?= csrf_field() ?>
                            <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                            
                            <div class="mb-4">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control form-control-lg" id="name" name="name" 
                                       value="<?= esc(old('name')) ?>" 
                                       placeholder="Enter your full name" 
                                       pattern="[A-Za-z\s\-\.']+" 
                                       minlength="3" 
                                       maxlength="100" 
                                       required>
                                <div class="invalid-feedback">
                                    Please enter a valid name (letters, spaces, hyphens, apostrophes, and periods only).
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control form-control-lg" id="email" name="email" 
                                       value="<?= esc(old('email')) ?>" 
                                       placeholder="Enter your email" 
                                       maxlength="100" 
                                       required>
                                <div class="invalid-feedback">
                                    Please enter a valid email address.
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control form-control-lg" id="password" name="password" 
                                           placeholder="Enter your password" 
                                           minlength="12" 
                                           pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\da-zA-Z]).{12,}$"
                                           required>
                                    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <div class="password-strength">
                                    <div class="progress">
                                        <div id="password-strength-bar" class="progress-bar" role="progressbar" style="width: 0%"></div>
                                    </div>
                                </div>
                                <div class="password-requirements">
                                    <p class="mb-1">Password must contain:</p>
                                    <ul class="list-unstyled">
                                        <li id="length" class="invalid">At least 12 characters</li>
                                        <li id="uppercase" class="invalid">At least one uppercase letter</li>
                                        <li id="lowercase" class="invalid">At least one lowercase letter</li>
                                        <li id="number" class="invalid">At least one number</li>
                                        <li id="special" class="invalid">At least one special character</li>
                                    </ul>
                                </div>
                                <div class="invalid-feedback">
                                    Password must be at least 12 characters long and include uppercase, lowercase, number, and special character.
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="password_confirm" class="form-label">Confirm Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control form-control-lg" id="password_confirm" name="password_confirm" 
                                           placeholder="Confirm your password" 
                                           required>
                                    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password_confirm">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <div class="invalid-feedback">
                                    Passwords do not match.
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-user-plus me-2"></i> Create Account
                                </button>
                            </div>
                        </form>

                        <div class="text-center mt-4">
                            <p class="mb-0">Already have an account? <a href="<?= base_url('login') ?>">Log in</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-light border-top mt-auto py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>ITE311-MACA</h5>
                    <p class="mb-0">Secure User Registration System</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">&copy; <?= date('Y') ?> ITE311-MACA. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Enable Bootstrap tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Toggle password visibility
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const input = document.getElementById(targetId);
                const icon = this.querySelector('i');
                
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });

        // Password strength meter
        const passwordInput = document.getElementById('password');
        const strengthBar = document.getElementById('password-strength-bar');
        const requirements = {
            length: document.getElementById('length'),
            uppercase: document.getElementById('uppercase'),
            lowercase: document.getElementById('lowercase'),
            number: document.getElementById('number'),
            special: document.getElementById('special')
        };

        passwordInput.addEventListener('input', function() {
            const password = this.value;
            let strength = 0;
            
            // Check each requirement
            const hasLength = password.length >= 12;
            const hasUppercase = /[A-Z]/.test(password);
            const hasLowercase = /[a-z]/.test(password);
            const hasNumber = /\d/.test(password);
            const hasSpecial = /[^A-Za-z0-9]/.test(password);
            
            // Update requirement indicators
            updateRequirement('length', hasLength);
            updateRequirement('uppercase', hasUppercase);
            updateRequirement('lowercase', hasLowercase);
            updateRequirement('number', hasNumber);
            updateRequirement('special', hasSpecial);
            
            // Calculate strength
            if (hasLength) strength += 20;
            if (hasUppercase) strength += 20;
            if (hasLowercase) strength += 20;
            if (hasNumber) strength += 20;
            if (hasSpecial) strength += 20;
            
            // Update strength bar
            strengthBar.style.width = strength + '%';
            
            // Update strength bar color
            if (strength < 40) {
                strengthBar.className = 'progress-bar bg-danger';
            } else if (strength < 80) {
                strengthBar.className = 'progress-bar bg-warning';
            } else {
                strengthBar.className = 'progress-bar bg-success';
            }
        });
        
        function updateRequirement(id, isValid) {
            const element = requirements[id];
            if (isValid) {
                element.classList.remove('invalid');
                element.classList.add('valid');
            } else {
                element.classList.remove('valid');
                element.classList.add('invalid');
            }
        }

        // Form validation
        (function() {
            'use strict';
            
            // Fetch the form element
            const form = document.getElementById('registerForm');
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('password_confirm');
            
            // Validate password match
            function validatePassword() {
                if (password.value !== confirmPassword.value) {
                    confirmPassword.setCustomValidity('Passwords do not match');
                } else {
                    confirmPassword.setCustomValidity('');
                }
            }
            
            // Add event listeners
            password.addEventListener('change', validatePassword);
            confirmPassword.addEventListener('keyup', validatePassword);
            
            // Prevent form submission if validation fails
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                
                form.classList.add('was-validated');
            }, false);
            
            // Client-side XSS protection for name field
            const nameInput = document.getElementById('name');
            nameInput.addEventListener('input', function() {
                // Remove any HTML tags
                this.value = this.value.replace(/<[^>]*>/g, '');
                
                // Remove any suspicious patterns
                const suspiciousPatterns = [
                    /[<>\{\}\{\}\|\^~\[\]`;\/\?\:\@\=\&\#\+\-\*]/g,
                    /(\%27|\'|\"|\;|\-\-|\/\*|\*\/|\<\s*script|\<\s*\/?img|\<\s*\/?svg|\<\s*\/?div|\<\s*\/?body|\<\s*\/?html|\<\s*\/?input|\<\s*\/?form|\<\s*\/?style|\<\s*\/?link|\<\s*\/?meta|\<\s*\/?iframe|\<\s*\/?object|\<\s*\/?embed|\<\s*\/?applet|\<\s*\/?frame|\<\s*\/?frameset|\<\s*\/?xml|\<\s*\?php|\<\s*\?|\<\s*\%|\<\s*\$|\<\s*\!\-\-|\-\-\s*\>|\%3C|\%3E|\%22|\%27|\%3D|\%7C|\/\*|\*\/|\;|\s*OR\s*1\s*\=\s*1\s*|UNION\s+SELECT|INFORMATION_SCHEMA\.|pg_catalog\.|mysql\.|sys\.|master\.|xp_cmdshell|sp_executesql|exec\s*\(|sp_|xp_|char\(|0x[0-9a-f]+|\/\*!|--|#|\/\*\*\/)/gi
                ];
                
                suspiciousPatterns.forEach(pattern => {
                    if (pattern.test(this.value)) {
                        this.value = this.value.replace(pattern, '');
                        alert('Invalid characters detected and removed.');
                    }
                });
            });
        })();
    </script>
</body>
</html>
