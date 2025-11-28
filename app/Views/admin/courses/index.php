<?= $this->extend('templates/header'); ?>
<?= $this->section('title') ?>Manage Courses<?= $this->endSection() ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Manage Courses</h5>
                    <a href="<?= base_url('admin/courses/create') ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus me-1"></i> Add New Course
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

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <input
                                type="text"
                                id="courseSearchInput"
                                class="form-control"
                                placeholder="Search courses by title, description, or teacher...">
                        </div>
                        <div class="col-md-6 text-md-end mt-2 mt-md-0">
                            <small class="text-muted">
                                Type to instantly filter the courses in the table below.
                            </small>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover" id="adminCourseTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Teacher</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($courses)): ?>
                                    <?php foreach ($courses as $course): ?>
                                        <tr>
                                            <td><?= $course['id'] ?></td>
                                            <td><?= esc($course['title']) ?></td>
                                            <td><?= esc($course['teacher_name'] ?? 'Unassigned') ?></td>
                                            <td>
                                                <span class="badge bg-<?= $course['status'] === 'active' ? 'success' : 'secondary' ?>">
                                                    <?= ucfirst($course['status']) ?>
                                                </span>
                                            </td>
                                            <td><?= date('M d, Y', strtotime($course['created_at'])) ?></td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?= base_url('admin/courses/' . $course['id'] . '/edit') ?>" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="/ITE311-LUMABAO/admin/courses/<?= $course['id'] ?>/upload" class="btn btn-sm btn-danger text-white">
                                                        <i class="fas fa-upload me-1"></i> Upload
                                                    </a>
                                                    <a href="<?= base_url('admin/courses/' . $course['id'] . '/delete') ?>" 
                                                       class="btn btn-sm btn-outline-danger"
                                                       onclick="return confirm('Are you sure you want to delete this course?')">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center">No courses found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('scripts') ?>
<script>
    $(function () {
        var $searchInput = $('#courseSearchInput');
        var $tableRows = $('#adminCourseTable tbody tr');

        $searchInput.on('keyup', function () {
            var term = $(this).val().toLowerCase();

            $tableRows.each(function () {
                var text = $(this).text().toLowerCase();
                $(this).toggle(text.indexOf(term) > -1);
            });
        });
    });
</script>
<?= $this->endSection() ?>
