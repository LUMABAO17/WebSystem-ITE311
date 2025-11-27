<?= $this->extend('templates/header') ?>

<?= $this->section('title') ?>
Upload Material - <?= esc($course['title'] ?? 'Course') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-upload me-2" style="color: var(--primary-color);"></i>
                        Upload Material - <?= esc($course['title'] ?? 'Course') ?>
                    </h5>
                    <a href="<?= $user['role'] === 'admin' ? site_url('admin/courses') : site_url('teacher/courses') ?>"
                       class="btn btn-sm btn-outline-secondary">
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

                    <?php if (session()->getFlashdata('errors')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <ul class="mb-0">
                                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php
                    $uploadUrl = ($user['role'] === 'admin')
                        ? site_url('admin/courses/' . $course_id . '/upload')
                        : site_url('teacher/courses/' . $course_id . '/upload');
                    ?>
                    <form action="<?= $uploadUrl ?>" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                        <?= csrf_field() ?>
                        <input type="hidden" name="course_id" value="<?= $course_id ?>">

                        <div class="mb-3">
                            <label for="title" class="form-label">Material Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?= session('errors.title') ? 'is-invalid' : '' ?>"
                                   id="title" name="title" value="<?= old('title') ?>" required>
                            <?php if (session('errors.title')): ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.title') ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"><?= old('description') ?></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="file" class="form-label">Select File <span class="text-danger">*</span></label>
                            <input type="file" class="form-control <?= session('errors.file') ? 'is-invalid' : '' ?>"
                                   id="file" name="file" required>
                            <div class="form-text">
                                Allowed file types: PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX, JPG, PNG, GIF, TXT (Max: 10MB)
                            </div>
                            <?php if (session('errors.file')): ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.file') ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-upload me-1"></i> Upload Material
                            </button>
                        </div>
                    </form>

                    <?php if (!empty($materials)): ?>
                        <hr class="my-4">
                        <h5 class="mb-3">Existing Materials</h5>
                        <div class="list-group">
                            <?php foreach ($materials as $material): ?>
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-file-alt me-2"></i>
                                        <?= esc($material['title']) ?>
                                        <small class="text-muted d-block">
                                            <?= format_file_size($material['file_size']) ?> •
                                            <?= strtoupper(pathinfo($material['file_name'], PATHINFO_EXTENSION)) ?>
                                        </small>
                                    </div>
                                    <div class="btn-group">
                                        <a href="<?= site_url('materials/download/' . $material['id']) ?>"
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-download"></i>
                                        </a>
                                        <?php if ($user['role'] === 'admin' || ($user['role'] === 'teacher' && $material['uploaded_by'] == $user['id'])): ?>
                                            <a href="<?= site_url('materials/delete/' . $material['id']) ?>"
                                               class="btn btn-sm btn-outline-danger"
                                               onclick="return confirm('Are you sure you want to delete this material?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$this->endSection();
$this->section('scripts');
?>
<script>
// File input preview
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('file');
    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            const fileName = this.files[0] ? this.files[0].name : 'No file chosen';
            console.log('Selected file:', fileName);
        });
    }
});

// Form validation
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('.needs-validation');
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
});
</script>
<?php $this->endSection(); ?>
