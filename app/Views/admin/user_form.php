<?= $this->extend('templates/header'); ?>

<?= $this->section('title') ?><?= esc($title ?? 'User') ?><?= $this->endSection() ?>

<?= $this->section('content'); ?>
<?php $errors = session('errors') ?? []; ?>
<div class="container py-4">
    <div class="row mb-3">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('admin/users') ?>">Manage Users</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= esc($title ?? 'User') ?></li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h4 class="mb-0"><?= esc($title ?? 'User') ?></h4>
                </div>
                <div class="card-body">
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach ($errors as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <?php
                        $isEdit = isset($mode) && $mode === 'edit';
                        $action = $isEdit && !empty($user['id'])
                            ? base_url('admin/users/' . $user['id'] . '/update')
                            : base_url('admin/users/store');
                    ?>

                    <form method="post" action="<?= $action ?>">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" name="name" id="name" class="form-control" value="<?= old('name', $user['name'] ?? '') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" value="<?= old('email', $user['email'] ?? '') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select name="role" id="role" class="form-select" required>
                                <?php foreach ($roles as $roleOption): ?>
                                    <option value="<?= esc($roleOption) ?>" <?= old('role', $user['role'] ?? 'student') === $roleOption ? 'selected' : '' ?>>
                                        <?= ucfirst(esc($roleOption)) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="is_active" class="form-label">Status</label>
                            <select name="is_active" id="is_active" class="form-select">
                                <?php $activeValue = (string) old('is_active', isset($user['is_active']) ? (string) $user['is_active'] : '1'); ?>
                                <option value="1" <?= $activeValue === '1' ? 'selected' : '' ?>>Active</option>
                                <option value="0" <?= $activeValue === '0' ? 'selected' : '' ?>>Inactive</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">
                                <?= $isEdit ? 'New Password (leave blank to keep current)' : 'Password' ?>
                            </label>
                            <input type="password" name="password" id="password" class="form-control" <?= $isEdit ? '' : 'required' ?>>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="<?= base_url('admin/users') ?>" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <?= $isEdit ? 'Update User' : 'Create User' ?>
                            </button>
                        </div>
                    </form>
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
