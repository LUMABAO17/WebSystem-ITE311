wwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwww                                 <?= $this->extend('templates/header'); ?>
<?= $this->section('title') ?><?= ucfirst($user['role']) ?> Dashboard<?= $this->endSection() ?>

<?= $this->section('content'); ?>
<div class="content-wrapper theme-<?= esc($user['role']) ?>" style="width: 100%; max-width: 1400px; margin: 0 auto;">
    <!-- Welcome Card -->
    <div class="welcome-card">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="h3 mb-2 fw-bold">Welcome back, <?= esc($user['name']); ?>! 👋</h2>
                <p class="mb-0 opacity-75"><?= date('l, F j, Y') ?></p>
            </div>
            <div class="d-flex align-items-center">
                <span class="badge bg-white text-primary rounded-pill px-3 py-2 fw-normal">
                    <i class="fas fa-user-shield me-1"></i> <?= esc(ucfirst($user['role'])); ?>
                </span>
            </div>
        </div>
    </div>
    <!-- Alerts -->
    <div class="row">
        <div class="col-12">
            <?php if (session()->getFlashdata('success')) : ?>
                <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-check-circle me-2"></i>
                        <div><?= session()->getFlashdata('success') ?></div>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <div><?= session()->getFlashdata('error') ?></div>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php if ($user['role'] === 'admin') : ?>
        <!-- Admin Dashboard -->
        <div class="admin-dashboard">
            <div class="row g-4 mb-4">
                <!-- Stats Cards -->
                <div class="col-md-3">
                    <div class="stats-card" style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <div class="icon"><i class="fas fa-users"></i></div>
                                <h3 class="mb-0 fw-bold"><?= number_format($stats['total_users'] ?? 0) ?></h3>
                                <p class="mb-0 small">Total Users</p>
                            </div>
                            <div class="ms-auto">
                                <span class="badge bg-white text-primary rounded-pill px-3 py-1">Live</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card" style="background: linear-gradient(135deg, var(--secondary-color) 0%, var(--primary-light) 100%);">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <div class="icon"><i class="fas fa-user-check"></i></div>
                                <h3 class="mb-0 fw-bold"><?= number_format($stats['active_users'] ?? 0) ?></h3>
                                <p class="mb-0 small">Active Users</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card" style="background: linear-gradient(135deg, var(--secondary-color) 0%, var(--primary-light) 100%);">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <div class="icon"><i class="fas fa-user-graduate"></i></div>
                                <h3 class="mb-0 fw-bold"><?= number_format($stats['total_students'] ?? 0) ?></h3>
                                <p class="mb-0 small">Students</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card" style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <div class="icon"><i class="fas fa-chalkboard-teacher"></i></div>
                                <h3 class="mb-0 fw-bold"><?= number_format($stats['total_teachers'] ?? 0) ?></h3>
                                <p class="mb-0 small">Teachers</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="row g-4 mb-4">
                <div class="col-12">
                    <h4 class="fw-bold mb-3">Quick Actions</h4>
                </div>
                <!-- Manage Courses Card - Moved to top and enhanced -->
                <div class="col-md-3">
                    <div class="dashboard-card p-4 h-100" style="border-left: 4px solid var(--primary-color);">
                        <a href="<?= site_url('admin/courses') ?>" class="text-decoration-none text-dark">
                            <div class="d-flex align-items-center">
                                <div class="card-icon" style="background-color: var(--primary-color); color: #fff; transform: scale(1.1);">
                                    <i class="fas fa-book-open"></i>
                                </div>
                                <div class="ms-3">
                                    <h5 class="mb-1">Manage Courses</h5>
                                    <p class="text-muted mb-0 small">View, add, and manage all courses</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                
                <!-- Manage Users Card -->
                <div class="col-md-3">
                    <div class="dashboard-card p-4 h-100">
                        <a href="<?= site_url('admin/users') ?>" class="text-decoration-none text-dark">
                            <div class="d-flex align-items-center">
                                <div class="card-icon" style="background-color: var(--secondary-color); color: #fff;">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="ms-3">
                                    <h5 class="mb-1">Manage Users</h5>
                                    <p class="text-muted mb-0 small">View and manage system users</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                        
                        <?php if (!empty($admin_courses)): ?>
                            <div class="upload-dropdown mt-3" onclick="event.stopPropagation()">
                                <div class="d-grid">
                                    <?php $uploadBaseUrl = ($user['role'] === 'admin') ? 'admin' : 'teacher'; ?>
                                    <select class="form-select form-select-sm" 
                                            onchange="if(this.value) window.location.href='<?= site_url('$uploadBaseUrl/courses/') ?>'+this.value+'/upload'"
                                            style="cursor: pointer;">
                                        <option value="" selected disabled>Upload materials...</option>
                                        <?php foreach ($admin_courses as $course): ?>
                                            <option value="<?= $course['id'] ?>">
                                                <?= esc(strlen($course['title']) > 22 ? substr($course['title'], 0, 20) . '...' : $course['title']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="text-center mt-2">
                                    <small class="text-muted">or</small>
                                </div>
                                <div class="d-grid mt-1">
                                    <a href="<?= site_url('admin/courses') ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-list me-1"></i> View All Courses
                                    </a>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="mt-3">
                                <a href="/admin/courses/create" class="btn btn-sm btn-primary w-100">
                                    <i class="fas fa-plus me-1"></i> Add New Course
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- Reports Card -->
                <div class="col-md-3">
                    <div class="dashboard-card p-4 h-100">
                        <a href="<?= site_url('admin/reports') ?>" class="text-decoration-none text-dark">
                            <div class="d-flex align-items-center">
                                <div class="card-icon" style="background-color: var(--primary-light); color: #fff;">
                                    <i class="fas fa-chart-bar"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold">Reports</h6>
                                    <p class="text-muted small mb-0">View system analytics</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <!-- Notifications Card -->
                <div class="col-md-3">
                    <div class="dashboard-card p-4 h-100">
                        <a href="<?= site_url('admin/notifications') ?>" class="text-decoration-none text-dark">
                            <div class="d-flex align-items-center">
                                <div class="card-icon" style="background-color: var(--warning-color); color: #fff;">
                                    <i class="fas fa-bell"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold">Notifications</h6>
                                    <p class="text-muted small mb-0">Manage system alerts</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="mb-0 fw-bold">Recent Activity</h5>
                                <a href="#" class="btn btn-sm btn-outline-primary">View All</a>
                            </div>
                            <div class="recent-activity">
                                <?php if (!empty($recent_activity ?? [])): ?>
                                    <?php foreach ($recent_activity as $activity): ?>
                                        <div class="activity-item">
                                            <div class="activity-dot"></div>
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <p class="mb-1 fw-medium">
                                                        <?php if (!empty($activity['icon'])): ?>
                                                            <i class="<?= esc($activity['icon']) ?> me-1"></i>
                                                        <?php endif; ?>
                                                        <?= esc($activity['title'] ?? 'Activity') ?>
                                                    </p>
                                                    <p class="text-muted small mb-0">
                                                        <?= esc($activity['description'] ?? '') ?>
                                                    </p>
                                                </div>
                                                <span class="text-muted small">
                                                    <?= !empty($activity['created_at']) 
                                                        ? date('M j, Y g:i A', strtotime($activity['created_at'])) 
                                                        : '' ?>
                                                </span>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="text-muted small">No recent activity yet.</div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php elseif ($user['role'] === 'teacher') : ?>
        <!-- Teacher Dashboard -->
        <div class="teacher-dashboard">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-soft-primary p-3 rounded-3 me-3">
                                    <i class="fas fa-chalkboard-teacher text-primary" style="font-size: 1.5rem;"></i>
                                </div>
                                <div>
                                    <h5 class="card-title mb-1">My Courses</h5>
                                    <p class="text-muted mb-0 small">Manage your courses and lessons</p>
                                </div>
                            </div>
                            <a href="/teacher/courses" class="stretched-link"></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-soft-primary p-3 rounded-3 me-3">
                                    <i class="fas fa-user-graduate text-primary" style="font-size: 1.5rem;"></i>
                                </div>
                                <div>
                                    <h5 class="card-title mb-1">Student Progress</h5>
                                    <p class="text-muted mb-0 small">Track students' progress and grades</p>
                                </div>
                            </div>
                            <a href="/teacher/students" class="stretched-link"></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-soft-primary p-3 rounded-3 me-3">
                                    <i class="fas fa-file-upload text-primary" style="font-size: 1.5rem;"></i>
                                </div>
                                <div>
                                    <h5 class="card-title mb-1">Upload Materials</h5>
                                    <p class="text-muted mb-0 small">Share course materials and resources</p>
                                </div>
                            </div>
                            <?php if (!empty($teacher_courses)): ?>
                                <div class="mt-2">
                                    <small class="text-muted">Select a course to upload:</small>
                                    <select class="form-select form-select-sm mt-1" onchange="if(this.value) window.location.href='/teacher/courses/'+this.value+'/upload'">
                                        <option value="">Choose a course...</option>
                                        <?php foreach ($teacher_courses as $course): ?>
                                            <option value="<?= $course['id'] ?>"><?= esc($course['title']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            <?php else: ?>
                                <a href="#" class="stretched-link"></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php else : ?>
        <!-- Student Dashboard -->
        <div class="student-dashboard">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="mb-1"><i class="fas fa-user-graduate me-2" style="color: var(--primary-color);"></i>Student Dashboard</h3>
                    <p class="text-muted mb-0 small">Welcome back to your learning journey</p>
                </div>
                <div class="last-login text-muted small">
                    <i class="far fa-clock me-1"></i> Last login: <?= !empty($user['last_login']) ? date('M j, Y g:i A', strtotime($user['last_login'])) : 'First login' ?>
                </div>
            </div>
            
            <?php if (session()->getFlashdata('welcome')): ?>
                <div class="alert alert-light alert-dismissible fade show border-0 shadow-sm" role="alert" style="background-color: #f8f9fa;">
                    <div class="d-flex align-items-center">
                        <div class="bg-soft-primary p-2 rounded-3 me-3">
                            <i class="fas fa-sparkles text-primary"></i>
                        </div>
                        <div>
                            <?= session()->getFlashdata('welcome') ?>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            
            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm hover-scale">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-soft-primary p-3 rounded-3 me-3">
                                    <i class="fas fa-book text-primary" style="font-size: 1.5rem;"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Enrolled Courses</h6>
                                    <h2 class="mb-0 mt-1" style="color: var(--primary-color);"><?= $enrolled_courses ?? 0 ?></h2>
                                </div>
                            </div>
                            <p class="text-muted mb-3 small">Continue learning from where you left off</p>
                            <a href="<?= site_url('student/courses') ?>" class="btn btn-sm btn-soft-primary stretched-link">
                                View All <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm hover-scale">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-soft-primary p-3 rounded-3 me-3">
                                    <i class="fas fa-tasks text-primary" style="font-size: 1.5rem;"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Completed Lessons</h6>
                                    <h2 class="mb-0 mt-1" style="color: var(--primary-color);"><?= $completed_lessons ?? 0 ?></h2>
                                </div>
                            </div>
                            <p class="text-muted mb-3 small">Track your learning progress</p>
                            <a href="<?= site_url('student/progress') ?>" class="btn btn-sm btn-soft-primary stretched-link">
                                View Progress <i class="fas fa-chart-line ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm hover-scale">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-soft-primary p-3 rounded-3 me-3">
                                    <i class="fas fa-calendar-check text-primary" style="font-size: 1.5rem;"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Upcoming</h6>
                                    <h2 class="mb-0 mt-1" style="color: var(--secondary-color);">0</h2>
                                </div>
                            </div>
                            <p class="text-muted mb-3 small">View your upcoming classes</p>
                            <a href="<?= site_url('student/calendar') ?>" class="btn btn-sm btn-soft-primary stretched-link">
                                View Calendar <i class="far fa-calendar-alt ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
                            </div>
                            
            <!-- Enrollment Sections -->
            <div class="row g-4 mt-2">
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white border-0 py-3 d-flex align-items-center">
                            <h5 class="mb-0"><i class="fas fa-list-check me-2" style="color: var(--primary-color);"></i>Enrolled Courses</h5>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($enrolled_list)): ?>
                                <ul class="list-group" id="enrolledList">
                                    <?php foreach ($enrolled_list as $course): ?>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <div class="fw-semibold"><?= esc($course['title']) ?></div>
                                                <small class="text-muted">Enrolled: <?= date('M j, Y', strtotime($course['enrollment_date'] ?? $course['enrolled_at'] ?? 'now')) ?></small>
                                            </div>
                                            <a class="btn btn-sm btn-outline-primary" href="<?= site_url('student/courses/' . $course['id']) ?>">Open</a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                <div class="text-center text-muted">No enrollments yet.</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white border-0 py-3 d-flex align-items-center">
                            <h5 class="mb-0"><i class="fas fa-book-open me-2" style="color: var(--primary-color);"></i>Available Courses</h5>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($available_courses)): ?>
                                <div class="list-group" id="availableList">
                                    <?php foreach ($available_courses as $course): ?>
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <div class="fw-semibold"><?= esc($course['title']) ?></div>
                                                <small class="text-muted"><?= esc(substr($course['description'] ?? '', 0, 90)) ?></small>
                                            </div>
                                            <button class="btn btn-sm btn-primary enroll-btn" data-course-id="<?= (int)$course['id'] ?>">Enroll</button>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <div class="text-center text-muted">No available courses.</div>
                            <?php endif; ?>
                            <div id="enrollAlert" class="mt-3" style="display:none;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Course Materials Section -->
            <?php if (!empty($enrolled_list)): ?>
                <div class="card border-0 shadow-sm mt-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0"><i class="fas fa-file-download me-2" style="color: var(--primary-color);"></i>Course Materials</h5>
                    </div>
                    <div class="card-body">
                        <?php
                        $materialModel = new \App\Models\MaterialModel();
                        $hasMaterials = false;
                        ?>
                        <?php foreach ($enrolled_list as $course): ?>
                            <?php
                            $courseMaterials = $materialModel->getMaterialsByCourse($course['id']);
                            if (!empty($courseMaterials)):
                                $hasMaterials = true;
                                break;
                            endif;
                            ?>
                        <?php endforeach; ?>
                        
                        <?php if ($hasMaterials): ?>
                            <div class="accordion" id="materialsAccordion">
                                <?php foreach ($enrolled_list as $course): ?>
                                    <?php
                                    $courseMaterials = $materialModel->getMaterialsByCourse($course['id']);
                                    if (empty($courseMaterials)) continue;
                                    ?>
                                    <div class="accordion-item border-0 mb-2">
                                        <h2 class="accordion-header" id="heading<?= $course['id'] ?>">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $course['id'] ?>" aria-expanded="false" aria-controls="collapse<?= $course['id'] ?>">
                                                <i class="fas fa-book me-2"></i><?= esc($course['title']) ?> (<?= count($courseMaterials) ?> files)
                                            </button>
                                        </h2>
                                        <div id="collapse<?= $course['id'] ?>" class="accordion-collapse collapse" aria-labelledby="heading<?= $course['id'] ?>" data-bs-parent="#materialsAccordion">
                                            <div class="accordion-body">
                                                <div class="list-group">
                                                    <?php foreach ($courseMaterials as $material): ?>
                                                        <div class="list-group-item d-flex justify-content-between align-items-center border-0">
                                                            <div>
                                                                <i class="fas fa-file me-2"></i>
                                                                <span><?= esc($material['file_name']) ?></span>
                                                                <small class="text-muted d-block">
                                                                    Uploaded: <?= date('M j, Y', strtotime($material['created_at'])) ?>
                                                                </small>
                                                            </div>
                                                            <a href="<?= site_url('materials/download/' . $material['id']) ?>" class="btn btn-sm btn-outline-primary">
                                                                <i class="fas fa-download me-1"></i> Download
                                                            </a>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center text-muted py-4">
                                <i class="fas fa-folder-open fa-3x mb-3"></i>
                                <p>No materials available for your enrolled courses yet.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Recent Activity Section -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-history me-2" style="color: var(--primary-color);"></i>Recent Activity</h5>
                        <a href="#" class="btn btn-sm btn-link text-decoration-none" style="color: var(--primary-color);">View All</a>
                    </div>
                                <div class="card-body">
                                    <?php if (!empty($recent_courses)): ?>
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Course</th>
                                                        <th>Last Accessed</th>
                                                        <th>Progress</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($recent_courses as $course): ?>
                                                        <tr>
                                                            <td>
                                                                <h6 class="mb-1"><?= esc($course['title']) ?></h6>
                                                                <small class="text-muted"><?= esc($course['code'] ?? '') ?></small>
                                                            </td>
                                                            <td><?= date('M j, Y', strtotime($course['last_accessed'] ?? 'N/A')) ?></td>
                                                            <td>
                                                                <div class="progress" style="height: 6px;">
                                                                    <div class="progress-bar bg-primary" role="progressbar" 
                                                                         style="width: <?= $course['progress'] ?? 0 ?>%;" 
                                                                         aria-valuenow="<?= $course['progress'] ?? 0 ?>" 
                                                                         aria-valuemin="0" 
                                                                         aria-valuemax="100">
                                                                    </div>
                                                                </div>
                                                                <small><?= $course['progress'] ?? 0 ?>% Complete</small>
                                                            </td>
                                                            <td>
                                                                <a href="<?= site_url('student/courses/' . $course['id']) ?>" 
                                                                   class="btn btn-sm btn-outline-primary">
                                                                    Continue <i class="fas fa-arrow-right ms-1"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php else: ?>
                                        <div class="text-center py-4">
                                            <div class="mb-3">
                                                <i class="fas fa-inbox fa-3x text-muted"></i>
                                            </div>
                                            <h5>No recent activity</h5>
                                            <p class="text-muted">Your recent courses and activities will appear here.</p>
                                            <a href="<?= site_url('student/courses') ?>" class="btn btn-primary">
                                                Browse Courses <i class="fas fa-arrow-right ms-1"></i>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Security Tips Card -->
                    <div class="card border-0 shadow-sm mt-4">
                        <div class="card-header bg-white border-0 py-3">
                            <h5 class="mb-0"><i class="fas fa-shield-alt me-2 text-warning"></i>Security Tips</h5>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-warning mb-0">
                                <div class="d-flex">
                                    <div class="me-3">
                                        <i class="fas fa-exclamation-triangle fa-2x"></i>
                                    </div>
                                    <div>
                                        <h6>Important Security Notice</h6>
                                        <p class="mb-2">For your security, please ensure you log out after each session, especially when using shared devices. Your last login was from IP: <strong><?= $user['last_login_ip'] ?? 'Unknown' ?></strong> on <?= !empty($user['last_login']) ? date('M j, Y g:i A', strtotime($user['last_login'])) : 'Never' ?>.</p>
                                        <div class="d-flex flex-wrap gap-2">
                                            <a href="<?= site_url('profile/security') ?>" class="btn btn-sm btn-outline-warning">
                                                <i class="fas fa-lock me-1"></i> Security Settings
                                            </a>
                                            <a href="<?= site_url('profile/activity') ?>" class="btn btn-sm btn-outline-secondary">
                                                <i class="fas fa-history me-1"></i> View Activity Log
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Session Timeout Warning Modal -->
    <div class="modal fade" id="sessionTimeoutModal" tabindex="-1" aria-labelledby="sessionTimeoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="sessionTimeoutModalLabel">
                        <i class="fas fa-clock me-2"></i>Session About to Expire
                    </h5>
                </div>
                <div class="modal-body">
                    <p>Your session will expire in <span id="countdown">2:00</span> due to inactivity.</p>
                    <p>Would you like to continue your session?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Log Out</button>
                    <button type="button" class="btn btn-primary" id="extendSession">
                        <i class="fas fa-sync-alt me-1"></i> Continue Session
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('scripts') ?>
<script>
$(function() {
    var csrfTokenName = '<?= csrf_token() ?>';
    var csrfToken = '<?= csrf_hash() ?>';

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': csrfToken }
    });

    function showAlert(type, message) {
        var html = '<div class="alert alert-' + type + ' alert-dismissible fade show" role="alert">'
            + message + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        $('#enrollAlert').html(html).show();
    }

    $('#availableList').on('click', '.enroll-btn', function(e) {
        e.preventDefault();
        var $btn = $(this);
        var courseId = $btn.data('course-id');
        $btn.prop('disabled', true).text('Enrolling...');

        var payload = { course_id: courseId };
        payload[csrfTokenName] = csrfToken;

        $.post('<?= site_url('/course/enroll') ?>', payload)
            .done(function(res, textStatus, xhr) {
                if (res.status === 'success' || res.status === 'exists') {
                    var msg = res.status === 'success' ? 'Enrolled successfully.' : 'Already enrolled.';
                    showAlert('success', msg);
                    // Move item to Enrolled list if success
                    if (res.status === 'success' && res.course) {
                        var item = '<li class="list-group-item d-flex justify-content-between align-items-center">'
                            + '<div><div class="fw-semibold">' + $('<div>').text(res.course.title).html() + '</div>'
                            + '<small class="text-muted">Enrolled: ' + new Date().toLocaleDateString() + '</small></div>'
                            + '<a class="btn btn-sm btn-outline-primary" href="<?= site_url('student/courses') ?>/' + res.course.id + '">Open</a>'
                            + '</li>';
                        var $list = $('#enrolledList');
                        if ($list.length === 0) {
                            $('#enrolledList').remove();
                            var wrapper = '<ul class="list-group" id="enrolledList"></ul>';
                            $(wrapper).appendTo($('#enrolledList').parent());
                        }
                        $('#enrolledList').prepend(item);
                    }
                    if (res.status === 'success' && window.refreshNotifications) {
                        window.refreshNotifications();
                    }
                    // Remove or disable button
                    $btn.closest('.list-group-item').remove();
                } else {
                    showAlert('danger', res.message || 'Failed to enroll');
                    $btn.prop('disabled', false).text('Enroll');
                }
                // Update CSRF token from header if provided
                var newToken = xhr.getResponseHeader('X-CSRF-TOKEN');
                if (newToken) {
                    csrfToken = newToken;
                }
            })
            .fail(function(xhr) {
                var msg = 'Error ' + xhr.status + ': ' + (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Request failed');
                showAlert('danger', msg);
                $btn.prop('disabled', false).text('Enroll');
            });
    });
});
</script>
<?= $this->endSection() ?>
