<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="card shadow-sm">
    <div class="card-header bg-warning text-dark">
        <h5 class="mb-0">Edit Performance</h5>
    </div>
    <div class="card-body">
        <form action="/performance/update/<?= $performance['id'] ?>" method="post">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="employee_id" class="form-label">Employee ID</label>
                    <input type="number" name="employee_id" id="employee_id" class="form-control" value="<?= esc($performance['employee_id'] ?? '') ?>">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="employee_name" class="form-label">Employee Name <span class="text-danger">*</span></label>
                    <input type="text" name="employee_name" id="employee_name" class="form-control" value="<?= esc($performance['employee_name']) ?>" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="period" class="form-label">Period</label>
                    <input type="text" name="period" id="period" class="form-control" value="<?= esc($performance['period'] ?? '') ?>">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="score" class="form-label">Score <span class="text-danger">*</span> (0-100)</label>
                    <input type="number" name="score" id="score" class="form-control" step="0.01" min="0" max="100" value="<?= esc($performance['score']) ?>" required>
                </div>

                <div class="col-12 mb-3">
                    <label for="notes" class="form-label">Notes</label>
                    <textarea name="notes" id="notes" class="form-control" rows="3"><?= esc($performance['notes'] ?? '') ?></textarea>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="/performance" class="btn btn-secondary">
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

