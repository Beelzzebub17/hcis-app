<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>System Setting</h3>
    <a href="/system-setting/create" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah Setting
    </a>
</div>

<?php if (empty($settings)): ?>
    <div class="alert alert-info">Belum ada system setting.</div>
<?php else: ?>
    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-striped align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>Setting Key</th>
                        <th>Setting Value</th>
                        <th>Description</th>
                        <th class="text-center" width="180">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($settings as $s): ?>
                        <tr>
                            <td><strong><?= esc($s['setting_key']) ?></strong></td>
                            <td><?= esc($s['setting_value']) ?></td>
                            <td><?= esc($s['description'] ?? '-') ?></td>
                            <td class="text-center">
                                <a href="/system-setting/edit/<?= $s['id'] ?>" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <a href="/system-setting/delete/<?= $s['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus setting ini?')">
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

