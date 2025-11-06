<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Daftar User</h3>
    <a href="/user/create" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah User
    </a>
</div>

<?php if (empty($users)): ?>
    <div class="alert alert-info">Belum ada user.</div>
<?php else: ?>
    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-striped align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th class="text-center" width="180">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $u): ?>
                        <tr>
                            <td><?= esc($u['id']) ?></td>
                            <td><?= esc($u['nama']) ?></td>
                            <td><?= esc($u['email']) ?></td>
                            <td class="text-center">
                                <a href="/user/edit/<?= $u['id'] ?>" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <a href="/user/delete/<?= $u['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus user ini?')">
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
