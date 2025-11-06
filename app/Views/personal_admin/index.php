<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Personal Admin</h3>
    <a href="/personal-admin/create" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah Karyawan
    </a>
</div>

<?php if (empty($personal)): ?>
    <div class="alert alert-info">Belum ada data karyawan.</div>
<?php else: ?>
    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-striped align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>Divisi</th>
                        <th>Jabatan</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th class="text-center" width="180">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($personal as $p): ?>
                        <tr>
                            <td><?= esc($p['nik']) ?></td>
                            <td><?= esc($p['nama']) ?></td>
                            <td><?= esc($p['divisi'] ?? '-') ?></td>
                            <td><?= esc($p['jabatan'] ?? '-') ?></td>
                            <td><?= esc($p['email'] ?? '-') ?></td>
                            <td>
                                <span class="badge bg-<?= $p['status'] == 'Active' ? 'success' : 'secondary' ?>">
                                    <?= esc($p['status']) ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="/personal-admin/edit/<?= $p['id'] ?>" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <a href="/personal-admin/delete/<?= $p['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus data ini?')">
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

