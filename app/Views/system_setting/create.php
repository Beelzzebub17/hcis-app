<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Tambah System Setting</h5>
    </div>
    <div class="card-body">
        <form action="/system-setting/store" method="post">
            <div class="mb-3">
                <label for="setting_key" class="form-label">Setting Key <span class="text-danger">*</span></label>
                <input type="text" name="setting_key" id="setting_key" class="form-control" required>
                <small class="text-muted">Harus unik, contoh: system_name, admin_email</small>
            </div>

            <div class="mb-3">
                <label for="setting_value" class="form-label">Setting Value</label>
                <textarea name="setting_value" id="setting_value" class="form-control" rows="3"></textarea>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control" rows="2"></textarea>
            </div>

            <div class="d-flex justify-content-between">
                <a href="/system-setting" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

