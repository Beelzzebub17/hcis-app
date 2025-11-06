<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Tambah Purchase Requisition</h5>
    </div>
    <div class="card-body">
        <form action="/purchase-requisition/store" method="post">
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control" rows="3"></textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="requester" class="form-label">Requester <span class="text-danger">*</span></label>
                    <input type="text" name="requester" id="requester" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="department" class="form-label">Department</label>
                    <input type="text" name="department" id="department" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="total_price" class="form-label">Total Price <span class="text-danger">*</span></label>
                    <input type="number" name="total_price" id="total_price" class="form-control" step="0.01" min="0" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="Pending">Pending</option>
                        <option value="Approved">Approved</option>
                        <option value="Rejected">Rejected</option>
                    </select>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="/purchase-requisition" class="btn btn-secondary">
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

