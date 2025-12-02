<?= $this->extend('templates/header'); ?>
<?= $this->section('title') ?>Create New Course<?= $this->endSection() ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-plus-circle me-2" style="color: var(--primary-color);"></i>
                        Create New Course
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('errors')): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('admin/courses/store') ?>" method="post">
                        <?= csrf_field() ?>
                        
                        <div class="mb-3">
                            <label for="title" class="form-label">Course Title</label>
                            <input type="text" class="form-control" id="title" name="title" required 
                                   value="<?= old('title') ?>">
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" 
                                      rows="3" required><?= old('description') ?></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="teacher_id" class="form-label">Teacher</label>
                                    <select class="form-select" id="teacher_id" name="teacher_id" required>
                                        <option value="">Select Teacher</option>
                                        <?php 
                                        // In a real application, you would fetch teachers from the database
                                        if (!empty($teachers)):
                                            foreach ($teachers as $teacher): 
                                                $selected = (old('teacher_id') == $teacher['id']) ? 'selected' : '';
                                        ?>
                                            <option value="<?= $teacher['id'] ?>" <?= $selected ?>>
                                                <?= esc($teacher['name']) ?>
                                            </option>
                                        <?php 
                                            endforeach;
                                        else:
                                        ?>
                                            <option value="">No teachers available</option>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" id="status" name="status" required>
                                        <option value="active" <?= old('status') === 'active' ? 'selected' : '' ?>>Active</option>
                                        <option value="inactive" <?= old('status') === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="<?= base_url('admin/courses') ?>" class="btn btn-secondary me-md-2">
                                <i class="fas fa-arrow-left me-1"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Save Course
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
