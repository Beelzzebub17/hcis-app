<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Training Development</h3>
    <a href="/training-dev/create" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah Training
    </a>
</div>

<?php if (empty($trainings)): ?>
    <div class="alert alert-info">Belum ada data training.</div>
<?php else: ?>
    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-striped align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>Title</th>
                        <th>Duration</th>
                        <th>Instructor</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th class="text-center" width="180">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($trainings as $t): ?>
                        <tr>
                            <td><?= esc($t['title']) ?></td>
                            <td><?= esc($t['duration'] ?? '-') ?></td>
                            <td><?= esc($t['instructor'] ?? '-') ?></td>
                            <td><?= $t['start_date'] ? date('d/m/Y', strtotime($t['start_date'])) : '-' ?></td>
                            <td><?= $t['end_date'] ? date('d/m/Y', strtotime($t['end_date'])) : '-' ?></td>
                            <td>
                                <span class="badge bg-<?= $t['status'] == 'Completed' ? 'success' : ($t['status'] == 'Scheduled' ? 'primary' : 'warning') ?>">
                                    <?= esc($t['status']) ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="/training-dev/edit/<?= $t['id'] ?>" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <a href="/training-dev/delete/<?= $t['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus data ini?')">
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

