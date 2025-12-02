<?= $this->extend('templates/header'); ?>

<?= $this->section('title') ?>Manage Users<?= $this->endSection() ?>

<?= $this->section('content'); ?>
<div class="container py-4">
    <div class="row mb-3">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Manage Users</li>
                </ol>
            </nav>
            <?php $success = session()->getFlashdata('success'); ?>
            <?php if (!empty($success)): ?>
                <div class="alert alert-success">
                    <?= esc($success) ?>
                </div>
            <?php endif; ?>
            <?php $error = session()->getFlashdata('error'); ?>
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger">
                    <?= esc($error) ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Users</h4>
                    <a href="<?= base_url('admin/users/create') ?>" class="btn btn-sm btn-primary">Add User</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Status</th>
                                    <th scope="col" class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($users)): ?>
                                    <?php foreach ($users as $user): ?>
                                        <tr>
                                            <td><?= esc($user['id']) ?></td>
                                            <td><?= esc($user['name']) ?></td>
                                            <td><?= esc($user['email']) ?></td>
                                            <td>
                                                <span class="badge bg-secondary">
                                                    <?= ucfirst(esc($user['role'])) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php if (isset($user['is_active']) && (int) $user['is_active'] === 1): ?>
                                                    <span class="badge bg-success">Active</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">Inactive</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-end">
                                                <?php if ((int) $currentUserId === (int) $user['id']): ?>
                                                    <span class="text-muted small">You (<?= ucfirst(esc($user['role'])) ?>)</span>
                                                <?php else: ?>
                                                    <div class="d-inline-flex align-items-center gap-2">
                                                        <a href="<?= base_url('admin/users/' . $user['id'] . '/edit') ?>" class="btn btn-sm btn-outline-secondary">Edit</a>
                                                        <a href="<?= base_url('admin/users/' . $user['id'] . '/delete') ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">No users found.</td>
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

<?= $this->section('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
    });
</script>
<?= $this->endSection(); ?>
