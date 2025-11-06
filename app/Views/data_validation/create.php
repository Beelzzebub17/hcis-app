<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Tambah Validation Item</h5>
    </div>
    <div class="card-body">
        <form action="/data-validation/store" method="post">
            <div class="mb-3">
                <label for="check_item" class="form-label">Check Item <span class="text-danger">*</span></label>
                <input type="text" name="check_item" id="check_item" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control" rows="3"></textarea>
            </div>

            <div class="mb-3">
                <label for="total" class="form-label">Total</label>
                <input type="number" name="total" id="total" class="form-control" min="0" value="0">
                <small class="text-muted">Status akan otomatis "OK" jika total = 0, "Not OK" jika total > 0</small>
            </div>

            <div class="d-flex justify-content-between">
                <a href="/data-validation" class="btn btn-secondary">
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

