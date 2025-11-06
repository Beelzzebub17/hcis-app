<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Performance Management</h3>
    <a href="/performance/create" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah Performance
    </a>
</div>

<?php if (empty($performances)): ?>
    <div class="alert alert-info">Belum ada data performance.</div>
<?php else: ?>
    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-striped align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>Employee Name</th>
                        <th>Period</th>
                        <th>Score</th>
                        <th>Rating</th>
                        <th class="text-center" width="180">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($performances as $p): ?>
                        <tr>
                            <td><?= esc($p['employee_name']) ?></td>
                            <td><?= esc($p['period'] ?? '-') ?></td>
                            <td><strong><?= number_format($p['score'], 2) ?></strong></td>
                            <td>
                                <span class="badge bg-<?= $p['rating'] == 'Excellent' ? 'success' : ($p['rating'] == 'Very Good' ? 'info' : ($p['rating'] == 'Good' ? 'primary' : 'warning')) ?>">
                                    <?= esc($p['rating']) ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="/performance/edit/<?= $p['id'] ?>" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <a href="/performance/delete/<?= $p['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus data ini?')">
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

