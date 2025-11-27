<?= $this->extend('templates/header'); ?>

<?php
$currentRole = session()->get('role') ?? 'student';
$uploadRoute = null;
if ($currentRole === 'admin') {
    $uploadRoute = 'admin.materials.upload';
} elseif ($currentRole === 'teacher') {
    $uploadRoute = 'teacher.materials.upload';
}
?>

<?= $this->section('title') ?><?= esc($course['title']) ?><?= $this->endSection() ?>

<?= $this->section('content'); ?>
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= esc($course['title']) ?></li>
                </ol>
            </nav>
            
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2 class="mb-0"><?= esc($course['title']) ?></h2>
                        <?php if ($isTeacherOrAdmin): ?>
                            <a href="<?= site_url('admin/courses/' . $course['id'] . '/edit') ?>" class="btn btn-primary btn-sm">
                                <i class="fas fa-edit me-1"></i> Edit Course
                            </a>
                        <?php endif; ?>
                    </div>
                    
                    <div class="mb-3">
                        <p class="mb-2"><?= nl2br(esc($course['description'] ?? 'No description available.')) ?></p>
                        <div class="text-muted small">
                            <span class="me-3"><i class="far fa-calendar-alt me-1"></i> Created: <?= date('M j, Y', strtotime($course['created_at'])) ?></span>
                            <?php if (!empty($course['updated_at'])): ?>
                                <span><i class="far fa-edit me-1"></i> Updated: <?= date('M j, Y', strtotime($course['updated_at'])) ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Course Materials</h5>
                    <?php if ($isTeacherOrAdmin && $uploadRoute): ?>
                        <a href="<?= route_to($uploadRoute, $course['id']) ?>" class="btn btn-primary btn-sm">
                            <i class="fas fa-upload me-1"></i> Upload Material
                        </a>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <?php if (empty($materials)): ?>
                        <div class="text-center py-4">
                            <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No materials available for this course yet.</p>
                            <?php if ($isTeacherOrAdmin && $uploadRoute): ?>
                                <a href="<?= route_to($uploadRoute, $course['id']) ?>" class="btn btn-primary">
                                    <i class="fas fa-upload me-1"></i> Upload Your First Material
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>File Name</th>
                                        <th>Size</th>
                                        <th>Uploaded</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($materials as $material): ?>
                                        <tr>
                                            <td><?= esc($material['title']) ?></td>
                                            <td><?= esc($material['file_name']) ?></td>
                                            <td><?= formatSizeUnits($material['file_size']) ?></td>
                                            <td><?= date('M j, Y', strtotime($material['created_at'])) ?></td>
                                            <td>
                                                <a href="<?= site_url('materials/download/' . $material['id']) ?>" class="btn btn-sm btn-primary me-1">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                                <?php if ($isTeacherOrAdmin): ?>
                                                    <a href="<?= site_url('materials/delete/' . $material['id']) ?>" 
                                                       class="btn btn-sm btn-danger"
                                                       onclick="return confirm('Are you sure you want to delete this material?')">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
    // Add any JavaScript needed for the course view
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
<?= $this->endSection(); ?>
