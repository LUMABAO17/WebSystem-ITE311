<?= $this->extend('templates/header'); ?>
<?= $this->section('title') ?><?= esc($course['title']) ?><?= $this->endSection() ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <a href="<?= site_url('student/courses') ?>" class="btn btn-outline-secondary mb-3">
                <i class="fas fa-arrow-left me-1"></i> Back to My Courses
            </a>
            <h2><?= esc($course['title']) ?></h2>
            <p class="text-muted"><?= esc($course['description'] ?? 'No description available') ?></p>
        </div>
    </div>

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
        <!-- Course Materials -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-file-download me-2" style="color: var(--primary-color);"></i>
                        Course Materials
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($materials)): ?>
                        <div class="list-group">
                            <?php foreach ($materials as $material): ?>
                                <div class="list-group-item d-flex justify-content-between align-items-center border-0">
                                    <div>
                                        <i class="fas fa-file me-2"></i>
                                        <span class="fw-semibold"><?= esc($material['file_name']) ?></span>
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
                    <?php else: ?>
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-folder-open fa-3x mb-3"></i>
                            <p>No materials available yet.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Course Lessons -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-list me-2" style="color: var(--primary-color);"></i>
                        Course Lessons
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($lessons)): ?>
                        <div class="list-group">
                            <?php foreach ($lessons as $lesson): ?>
                                <div class="list-group-item border-0">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-soft-primary p-2 rounded-3 me-3">
                                            <span class="fw-bold"><?= $lesson['order'] ?></span>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1"><?= esc($lesson['title']) ?></h6>
                                            <?php if (!empty($lesson['description'])): ?>
                                                <small class="text-muted"><?= esc(substr($lesson['description'], 0, 80)) ?>...</small>
                                            <?php endif; ?>
                                        </div>
                                        <a href="#" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-play me-1"></i> View
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-book-open fa-3x mb-3"></i>
                            <p>No lessons available yet.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
