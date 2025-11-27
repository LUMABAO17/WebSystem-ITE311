<?= $this->extend('templates/header'); ?>
<?= $this->section('title') ?>My Courses<?= $this->endSection() ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h3><i class="fas fa-book me-2" style="color: var(--primary-color);"></i>My Courses</h3>
            <p class="text-muted">Your enrolled courses</p>
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

    <?php if (!empty($courses)): ?>
        <div class="row">
            <?php foreach ($courses as $course): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><?= esc($course['title']) ?></h5>
                            <p class="card-text text-muted">
                                <?= esc(substr($course['description'] ?? 'No description available', 0, 100)) ?>...
                            </p>
                            <small class="text-muted d-block mb-3">
                                <i class="far fa-calendar me-1"></i>
                                Enrolled: <?= date('M j, Y', strtotime($course['enrollment_date'])) ?>
                            </small>
                            <a href="<?= site_url('student/courses/' . $course['id']) ?>" class="btn btn-primary w-100">
                                <i class="fas fa-arrow-right me-1"></i> View Course
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="text-center py-5">
            <i class="fas fa-folder-open fa-5x text-muted mb-4"></i>
            <h4>No Courses Yet</h4>
            <p class="text-muted">You haven't enrolled in any courses yet.</p>
            <a href="<?= site_url('dashboard') ?>" class="btn btn-primary">
                <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
            </a>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection(); ?>
