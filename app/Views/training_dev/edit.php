<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="card shadow-sm">
    <div class="card-header bg-warning text-dark">
        <h5 class="mb-0">Edit Training</h5>
    </div>
    <div class="card-body">
        <form action="/training-dev/update/<?= $training['id'] ?>" method="post">
            <div class="mb-3">
                <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                <input type="text" name="title" id="title" class="form-control" value="<?= esc($training['title']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control" rows="3"><?= esc($training['description'] ?? '') ?></textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="duration" class="form-label">Duration</label>
                    <input type="text" name="duration" id="duration" class="form-control" value="<?= esc($training['duration'] ?? '') ?>">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="instructor" class="form-label">Instructor</label>
                    <input type="text" name="instructor" id="instructor" class="form-control" value="<?= esc($training['instructor'] ?? '') ?>">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" name="start_date" id="start_date" class="form-control" value="<?= $training['start_date'] ?? '' ?>">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="end_date" class="form-label">End Date</label>
                    <input type="date" name="end_date" id="end_date" class="form-control" value="<?= $training['end_date'] ?? '' ?>">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="Scheduled" <?= ($training['status'] ?? '') == 'Scheduled' ? 'selected' : '' ?>>Scheduled</option>
                        <option value="Ongoing" <?= ($training['status'] ?? '') == 'Ongoing' ? 'selected' : '' ?>>Ongoing</option>
                        <option value="Completed" <?= ($training['status'] ?? '') == 'Completed' ? 'selected' : '' ?>>Completed</option>
                        <option value="Cancelled" <?= ($training['status'] ?? '') == 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
                    </select>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="/training-dev" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save"></i> Update
                </button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

