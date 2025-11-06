<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="card shadow-sm">
    <div class="card-header bg-warning text-dark">
        <h5 class="mb-0">Edit Data User</h5>
    </div>
    <div class="card-body">
        <form action="/user/update/<?= $user['id'] ?>" method="post">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Lengkap</label>
                <input type="text" name="nama" id="nama" class="form-control" value="<?= esc($user['nama']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Alamat Email</label>
                <input type="email" name="email" id="email" class="form-control" value="<?= esc($user['email']) ?>" required>
            </div>

            <div class="d-flex justify-content-between">
                <a href="/user" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
                <button type="submit" class="btn btn-warning">
                    <i class="bi bi-check-circle"></i> Update
                </button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
