<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Data Validation</h3>
    <a href="/data-validation/create" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah Validation Item
    </a>
</div>

<?php if (empty($validations)): ?>
    <div class="alert alert-info">Belum ada data validation.</div>
<?php else: ?>
    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-striped align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>Check Item</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Last Check</th>
                        <th class="text-center" width="180">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($validations as $v): ?>
                        <tr>
                            <td><?= esc($v['check_item']) ?></td>
                            <td><?= esc($v['total']) ?></td>
                            <td>
                                <span class="badge bg-<?= $v['status'] == 'OK' ? 'success' : 'danger' ?>">
                                    <?= esc($v['status']) ?>
                                </span>
                            </td>
                            <td><?= $v['last_check'] ? date('d/m/Y H:i', strtotime($v['last_check'])) : '-' ?></td>
                            <td class="text-center">
                                <a href="/data-validation/edit/<?= $v['id'] ?>" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <a href="/data-validation/delete/<?= $v['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus data ini?')">
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

