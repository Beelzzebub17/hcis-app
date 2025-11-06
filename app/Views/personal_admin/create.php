<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Tambah Karyawan Baru</h5>
    </div>
    <div class="card-body">
        <form action="/personal-admin/store" method="post">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nik" class="form-label">NIK <span class="text-danger">*</span></label>
                    <input type="text" name="nik" id="nik" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="nama" id="nama" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="divisi" class="form-label">Divisi</label>
                    <input type="text" name="divisi" id="divisi" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="jabatan" class="form-label">Jabatan</label>
                    <input type="text" name="jabatan" id="jabatan" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" name="phone" id="phone" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="/personal-admin" class="btn btn-secondary">
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

