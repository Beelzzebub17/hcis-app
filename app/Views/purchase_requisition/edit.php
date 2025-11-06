<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="card shadow-sm">
    <div class="card-header bg-warning text-dark">
        <h5 class="mb-0">Edit Purchase Requisition</h5>
    </div>
    <div class="card-body">
        <form action="/purchase-requisition/update/<?= $pr['id'] ?>" method="post">
            <div class="mb-3">
                <label class="form-label">PR Number</label>
                <input type="text" class="form-control" value="<?= esc($pr['pr_number']) ?>" readonly>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control" rows="3"><?= esc($pr['description'] ?? '') ?></textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="requester" class="form-label">Requester <span class="text-danger">*</span></label>
                    <input type="text" name="requester" id="requester" class="form-control" value="<?= esc($pr['requester']) ?>" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="department" class="form-label">Department</label>
                    <input type="text" name="department" id="department" class="form-control" value="<?= esc($pr['department'] ?? '') ?>">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="total_price" class="form-label">Total Price <span class="text-danger">*</span></label>
                    <input type="number" name="total_price" id="total_price" class="form-control" step="0.01" min="0" value="<?= esc($pr['total_price']) ?>" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="Pending" <?= ($pr['status'] ?? '') == 'Pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="Approved" <?= ($pr['status'] ?? '') == 'Approved' ? 'selected' : '' ?>>Approved</option>
                        <option value="Rejected" <?= ($pr['status'] ?? '') == 'Rejected' ? 'selected' : '' ?>>Rejected</option>
                    </select>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="/purchase-requisition" class="btn btn-secondary">
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

