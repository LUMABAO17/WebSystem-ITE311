<?= $this->extend('templates/header'); ?>

<?php
$role = $user['role'] ?? 'admin';
$backRoute = $role === 'teacher' ? 'teacher.courses' : 'admin.courses';
$uploadRoute = $role === 'teacher' ? 'teacher.materials.upload' : 'admin.materials.upload';
$deleteRoute = $role === 'teacher' ? 'teacher.materials.delete' : 'admin.materials.delete';
?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Upload Materials for <?= esc($course['title'] ?? 'Course') ?></h5>
                    <a href="<?= route_to($backRoute) ?>" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i> Back to Courses
                    </a>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            <?= session()->getFlashdata('success') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <?= session()->getFlashdata('error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Upload New Material</h6>
                                </div>
                                <div class="card-body">
                                    <?= form_open_multipart(route_to($uploadRoute, $course['id']), ['class' => 'needs-validation', 'novalidate' => '']) ?>
                                        <div class="mb-3">
                                            <label for="material" class="form-label">Select File</label>
                                            <input type="file" class="form-control" id="material" name="material" required>
                                            <div class="invalid-feedback">
                                                Please select a file to upload.
                                            </div>
                                            <div class="form-text">
                                                Allowed file types: PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX, JPG, PNG, GIF, TXT, ZIP
                                                <br>Max file size: 100MB
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="title" class="form-label">Title</label>
                                            <input type="text" class="form-control" id="title" name="title" required>
                                            <div class="invalid-feedback">
                                                Please provide a title for this material.
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="description" class="form-label">Description (Optional)</label>
                                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                                        </div>
                                        
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-upload me-1"></i> Upload Material
                                        </button>
                                    <?= form_close() ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Uploaded Materials</h6>
                                </div>
                                <div class="card-body">
                                    <?php if (!empty($materials)): ?>
                                        <div class="list-group">
                                            <?php foreach ($materials as $material): ?>
                                                <div class="list-group-item">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <h6 class="mb-1"><?= esc($material['title']) ?></h6>
                                                            <p class="mb-1 small text-muted">
                                                                <?= date('M d, Y H:i', strtotime($material['created_at'])) ?>
                                                                • <?= formatBytes($material['file_size'] ?? 0) ?>
                                                            </p>
                                                            <?php if (!empty($material['description'])): ?>
                                                                <p class="mb-0 small"><?= esc($material['description']) ?></p>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="btn-group">
                                                            <a href="<?= base_url('materials/download/' . $material['id']) ?>" 
                                                               class="btn btn-sm btn-outline-primary" 
                                                               title="Download">
                                                                <i class="fas fa-download"></i>
                                                            </a>
                                                            <a href="<?= route_to($deleteRoute, $material['id']) ?>" 
                                                               class="btn btn-sm btn-outline-danger" 
                                                               title="Delete"
                                                               onclick="return confirm('Are you sure you want to delete this material?')">
                                                                <i class="fas fa-trash"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="alert alert-info mb-0">
                                            <i class="fas fa-info-circle me-2"></i>
                                            No materials have been uploaded yet.
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add this script for form validation -->
<script>
// Enable Bootstrap form validation
(function () {
    'use strict'
    
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll('.needs-validation')
    
    // Loop over them and prevent submission
    Array.prototype.slice.call(forms).forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }
            
            form.classList.add('was-validated')
        }, false)
    })
})()
</script>
<?= $this->endSection() ?>
