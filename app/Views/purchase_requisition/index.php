<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Purchase Requisition</h3>
    <a href="/purchase-requisition/create" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah PR
    </a>
</div>

<?php if (empty($purchase_requisitions)): ?>
    <div class="alert alert-info">Belum ada data Purchase Requisition.</div>
<?php else: ?>
    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-striped align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>PR Number</th>
                        <th>Description</th>
                        <th>Requester</th>
                        <th>Department</th>
                        <th>Total Price</th>
                        <th>Status</th>
                        <th class="text-center" width="180">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($purchase_requisitions as $pr): ?>
                        <tr>
                            <td><?= esc($pr['pr_number']) ?></td>
                            <td><?= esc($pr['description'] ?? '-') ?></td>
                            <td><?= esc($pr['requester']) ?></td>
                            <td><?= esc($pr['department'] ?? '-') ?></td>
                            <td>Rp <?= number_format($pr['total_price'], 0, ',', '.') ?></td>
                            <td>
                                <span class="badge bg-<?= $pr['status'] == 'Approved' ? 'success' : ($pr['status'] == 'Pending' ? 'warning' : 'danger') ?>">
                                    <?= esc($pr['status']) ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="/purchase-requisition/edit/<?= $pr['id'] ?>" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <a href="/purchase-requisition/delete/<?= $pr['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus data ini?')">
                                    <i class="bi bi-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>

