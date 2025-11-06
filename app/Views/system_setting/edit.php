<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="card shadow-sm">
    <div class="card-header bg-warning text-dark">
        <h5 class="mb-0">Edit System Setting</h5>
    </div>
    <div class="card-body">
        <form action="/system-setting/update/<?= $setting['id'] ?>" method="post">
            <div class="mb-3">
                <label for="setting_key" class="form-label">Setting Key <span class="text-danger">*</span></label>
                <input type="text" name="setting_key" id="setting_key" class="form-control" value="<?= esc($setting['setting_key']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="setting_value" class="form-label">Setting Value</label>
                <textarea name="setting_value" id="setting_value" class="form-control" rows="3"><?= esc($setting['setting_value'] ?? '') ?></textarea>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control" rows="2"><?= esc($setting['description'] ?? '') ?></textarea>
            </div>

            <div class="d-flex justify-content-between">
                <a href="/system-setting" class="btn btn-secondary">
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

