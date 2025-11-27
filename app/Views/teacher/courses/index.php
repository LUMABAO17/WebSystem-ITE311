<?= $this->extend('templates/header'); ?>
<?= $this->section('title') ?>My Courses<?= $this->endSection() ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h3 class="mb-0">My Courses</h3>
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

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">Courses You Teach</h5>
        </div>
        <div class="card-body">
            <?php if (!empty($courses)): ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($courses as $course): ?>
                                <tr>
                                    <td><?= $course['id'] ?></td>
                                    <td><?= esc($course['title']) ?></td>
                                    <td>
                                        <span class="badge bg-<?= ($course['status'] ?? 'active') === 'active' ? 'success' : 'secondary' ?>">
                                            <?= ucfirst($course['status'] ?? 'active') ?>
                                        </span>
                                    </td>
                                    <td><?= date('M d, Y', strtotime($course['created_at'])) ?></td>
                                    <td class="text-end">
                                        <div class="btn-group" role="group">
                                            <a href="<?= site_url('teacher/courses/' . $course['id']) ?>" class="btn btn-sm btn-outline-primary" title="View Course">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?= site_url('teacher/courses/' . $course['id'] . '/upload') ?>" class="btn btn-sm btn-primary text-white" title="Upload Materials">
                                                <i class="fas fa-upload"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-info mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    You are not assigned to any courses yet.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
