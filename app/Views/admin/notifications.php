<?= $this->extend('templates/header'); ?>

<?= $this->section('title') ?>Notifications<?= $this->endSection() ?>

<?= $this->section('content'); ?>
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Notifications</li>
                </ol>
            </nav>

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">System Notifications</h4>
                        <div>
                            <button class="btn btn-sm btn-outline-secondary me-2">
                                <i class="fas fa-check-double me-1"></i> Mark all as read
                            </button>
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="fas fa-trash-alt me-1"></i> Clear all
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <!-- Sample notification items -->
                        <div class="list-group-item list-group-item-action">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar-sm">
                                        <span class="avatar-title rounded-circle bg-soft-primary text-primary">
                                            <i class="fas fa-user-plus"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="mb-1">New User Registration</h6>
                                        <small class="text-muted">2 hours ago</small>
                                    </div>
                                    <p class="mb-0 text-muted">A new user (john.doe@example.com) has registered.</p>
                                </div>
                            </div>
                        </div>

                        <div class="list-group-item list-group-item-action">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar-sm">
                                        <span class="avatar-title rounded-circle bg-soft-success text-success">
                                            <i class="fas fa-check-circle"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="mb-1">System Update</h6>
                                        <small class="text-muted">5 hours ago</small>
                                    </div>
                                    <p class="mb-0 text-muted">System maintenance completed successfully.</p>
                                </div>
                            </div>
                        </div>

                        <div class="list-group-item list-group-item-action">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar-sm">
                                        <span class="avatar-title rounded-circle bg-soft-warning text-warning">
                                            <i class="fas fa-exclamation-triangle"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="mb-1">Storage Warning</h6>
                                        <small class="text-muted">1 day ago</small>
                                    </div>
                                    <p class="mb-0 text-muted">Your storage is almost full (85% used).</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <div class="text-center">
                        <a href="#" class="text-primary">View all notifications</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
    // Add any JavaScript needed for the notifications page
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize any notification-related functionality here
        console.log('Notifications page loaded');
    });
</script>
<?= $this->endSection(); ?>
