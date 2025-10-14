<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>HCIS Smarthic - Demo (With CRUD & localStorage)</title>

  <!-- Bootstrap CSS & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet" />

  <style>
    :root {
      --sidebar-bg: #0f172a;
      --sidebar-text: #cbd5e1;
      --sidebar-hover: #111827;
      --accent: #2563eb;
      --card-radius: 12px;
    }
    html,body { height:100%; }
    body {
      margin:0;
      font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
      background: #f4f6fb;
      display:flex;
      height:100vh;
      overflow:hidden;
    }
    .sidebar{ width:260px; background:var(--sidebar-bg); color:var(--sidebar-text); display:flex; flex-direction:column; padding:18px 0; }
    .sidebar .sidebar-header { display:flex; align-items:center; gap:12px; padding:0 18px 14px; border-bottom:1px solid rgba(255,255,255,0.04); margin-bottom:8px; }
    .sidebar .sidebar-header img{ width:36px; }
    .sidebar .sidebar-header h1 { font-size:16px; margin:0; color:#fff; letter-spacing:0.2px; }
    .menu{ padding:8px 0; overflow:auto; flex:1;}
    .menu ul{ list-style:none; padding:0; margin:0;}
    .menu li { display:flex; align-items:center; gap:10px; padding:10px 18px; color:var(--sidebar-text); cursor:pointer; transition: background .12s, color .12s; }
    .menu li:hover{ background:var(--sidebar-hover); color:#fff; }
    .menu li.active{ background:var(--accent); color:#fff; }
    .menu li i{ width:20px; text-align:center; }
    .sidebar-footer{ padding:12px 18px; font-size:12px; color:#7b8794; border-top:1px solid rgba(255,255,255,0.03); }
    .content { flex:1; overflow:auto; padding:22px 28px; }
    .header-card{ background:#fff; border-radius:var(--card-radius); padding:20px; box-shadow:0 6px 18px rgba(20,30,60,0.06); display:flex; justify-content:space-between; align-items:center; gap:12px; margin-bottom:18px; }
    .settings-section{ background:#fff; border-radius:var(--card-radius); padding:18px; box-shadow:0 6px 18px rgba(20,30,60,0.04); }
    .kpi { padding:14px; border-radius:10px; display:flex; justify-content:space-between; align-items:center; gap:12px; background:linear-gradient(180deg,#fff,#fbfdff); box-shadow:0 8px 20px rgba(50,70,90,0.03); }
    .page { display:none; }
    .page.active { display:block; }
    .chat-wrap { height:420px; display:flex; flex-direction:column; gap:12px; }
    .chat-box { flex:1; border:1px solid #eef2f6; border-radius:10px; padding:12px; overflow:auto; background:#fbfdff; }
    .msg { margin:8px 0; max-width:70%; padding:8px 12px; border-radius:8px; }
    .msg.me { background:#e6f0ff; align-self:flex-end; }
    .msg.other { background:#f2f6fa; align-self:flex-start; }
    .small-muted { color:#6b7280; font-size:13px; }
    @media (max-width: 900px) { .sidebar { width:64px; } .sidebar .sidebar-header h1 { display:none; } .menu li span { display:none; } }
  </style>
</head>
<body>
  <!-- SIDEBAR -->
  <aside class="sidebar">
    <div class="sidebar-header">
      <img src="https://cdn-icons-png.flaticon.com/512/888/888879.png" alt="logo">
      <h1>HCIS Smarthic</h1>
    </div>

    <nav class="menu">
      <ul>
        <li data-page="dashboard" class="active"><i class="bi bi-speedometer2"></i> <span>Dashboard</span></li>
        <li data-page="survey"><i class="bi bi-people"></i> <span>Employee Surveys</span></li>
        <li data-page="chat"><i class="bi bi-chat"></i> <span>Chat</span></li>
        <li data-page="organization"><i class="bi bi-diagram-3"></i> <span>Organization Structure</span></li>
        <li data-page="personal"><i class="bi bi-person"></i> <span>Personal Administration</span></li>
        <li data-page="time"><i class="bi bi-clock"></i> <span>Time Management</span></li>
        <li data-page="training"><i class="bi bi-award"></i> <span>Training Development</span></li>
        <li data-page="performance"><i class="bi bi-graph-up"></i> <span>Performance</span></li>
        <li data-page="payroll"><i class="bi bi-cash-stack"></i> <span>Purchase Requisition</span></li>
        <li data-page="validation"><i class="bi bi-check2-square"></i> <span>Data Validation</span></li>
        <li data-page="setting"><i class="bi bi-gear"></i> <span>System Setting</span></li>
        <li data-page="profile"><i class="bi bi-person-circle"></i> <span>Profile</span></li>
      </ul>
    </nav>

    <div class="sidebar-footer">© 2025 Human Capital Information System</div>
  </aside>

  <!-- CONTENT -->
  <main class="content">
    <div class="header-card">
      <div>
        <h3 class="mb-0">HCIS Smarthic</h3>
        <div class="small-muted">Sistem Informasi Human Capital</div>
      </div>
      <div class="d-flex align-items-center gap-2">
        <button class="btn btn-outline-secondary btn-sm"><i class="bi bi-bell"></i></button>
        <button class="btn btn-primary btn-sm"><i class="bi bi-download"></i> Export</button>
      </div>
    </div>

    <!-- DASHBOARD -->
    <section id="dashboard" class="page active">
      <div class="settings-section mb-3">
        <div class="row g-3">
          <div class="col-md-3"><div class="kpi"><div><div class="small-muted">Total Karyawan</div><div class="h5 fw-bold" id="k_total">1,254</div></div><div class="text-muted text-end"><i class="bi bi-people fs-3 text-primary"></i></div></div></div>
          <div class="col-md-3"><div class="kpi"><div><div class="small-muted">Pelatihan Aktif</div><div class="h5 fw-bold">12 Program</div></div><div class="text-muted text-end"><i class="bi bi-award fs-3 text-warning"></i></div></div></div>
          <div class="col-md-3"><div class="kpi"><div><div class="small-muted">Kehadiran Hari Ini</div><div class="h5 fw-bold">96%</div></div><div class="text-muted text-end"><i class="bi bi-clock-history fs-3 text-success"></i></div></div></div>
          <div class="col-md-3"><div class="kpi"><div><div class="small-muted">Proyek Aktif</div><div class="h5 fw-bold">5</div></div><div class="text-muted text-end"><i class="bi bi-kanban fs-3 text-info"></i></div></div></div>
        </div>
      </div>

      <div class="row g-4">
        <div class="col-lg-8">
          <div class="settings-section">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h6 class="mb-0">Grafik Kehadiran Karyawan</h6>
              <select id="attendanceRange" class="form-select form-select-sm w-auto">
                <option value="week">Mingguan</option>
                <option value="month">Bulanan</option>
              </select>
            </div>
            <canvas id="attendanceChart" height="140"></canvas>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="settings-section">
            <h6>Aktivitas Terbaru</h6>
            <ul class="list-group list-group-flush mt-3">
              <li class="list-group-item"><i class="bi bi-person-check text-success me-2"></i> 5 Karyawan baru bergabung hari ini</li>
              <li class="list-group-item"><i class="bi bi-award text-warning me-2"></i> Program "Leadership Training" dimulai</li>
              <li class="list-group-item"><i class="bi bi-clock text-primary me-2"></i> Revisi jadwal shift malam HRD</li>
              <li class="list-group-item"><i class="bi bi-cash-stack text-info me-2"></i> Proses payroll Agustus selesai</li>
            </ul>
          </div>
        </div>
      </div>
    </section>

    <!-- EMPLOYEE SURVEYS -->
    <section id="survey" class="page">
      <div class="header-card mb-3 d-flex justify-content-between align-items-center">
        <div><h5 class="mb-0">Employee Surveys</h5><div class="small-muted">Kelola survei & hasil</div></div>
        <button class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Buat Survei</button>
      </div>
      <div class="settings-section">
        <div class="row">
          <div class="col-lg-8">
            <h6>Daftar Survei Aktif</h6>
            <div class="row g-3 mt-2">
              <div class="col-md-6"><div class="card p-3"><h6>Survei Kepuasan Kerja 2025</h6><p class="small-muted mb-2">Deadline: 30 Nov 2025</p><div class="progress mb-2" style="height:8px"><div class="progress-bar bg-success" style="width:72%"></div></div><div class="d-flex justify-content-between align-items-center"><small class="small-muted">72% terisi</small><button class="btn btn-outline-primary btn-sm">Lihat Hasil</button></div></div></div>
              <div class="col-md-6"><div class="card p-3"><h6>Survei Lingkungan Kerja</h6><p class="small-muted mb-2">Deadline: 15 Des 2025</p><div class="progress mb-2" style="height:8px"><div class="progress-bar bg-warning" style="width:38%"></div></div><div class="d-flex justify-content-between align-items-center"><small class="small-muted">38% terisi</small><button class="btn btn-outline-primary btn-sm">Isi Survei</button></div></div></div>
            </div>
          </div>
          <div class="col-lg-4">
            <h6>Ringkasan Partisipasi</h6>
            <canvas id="surveyChart" height="200"></canvas>
          </div>
        </div>
      </div>
    </section>

    <!-- CHAT -->
    <section id="chat" class="page">
      <div class="header-card mb-3"><div><h5 class="mb-0">Chat Internal</h5><div class="small-muted">Percakapan antar karyawan</div></div></div>
      <div class="settings-section">
        <div class="chat-wrap">
          <div class="chat-box" id="chatBox">
            <div class="msg other"><strong>Ari</strong><div>Halo tim, rapat jam 10:00</div></div>
            <div class="msg me"><strong>Anda</strong><div>Siap</div></div>
          </div>
          <div class="d-flex gap-2">
            <input id="chatInput" class="form-control" placeholder="Tulis pesan..." />
            <button id="sendBtn" class="btn btn-primary"><i class="bi bi-send"></i></button>
          </div>
        </div>
      </div>
    </section>

    <!-- ORGANIZATION -->
    <section id="organization" class="page">
      <div class="header-card mb-3"><div><h5 class="mb-0">Organization Structure</h5><div class="small-muted">Struktur organisasi</div></div></div>
      <div class="settings-section">
        <div class="row">
          <div class="col-md-6">
            <h6>Bagan Organisasi</h6>
            <ul>
              <li><strong>Direktur Utama</strong>
                <ul><li>VP HR<ul><li>HCIS Team</li><li>Recruitment</li></ul></li><li>VP Finance</li><li>VP Operasional</li></ul>
              </li>
            </ul>
          </div>
          <div class="col-md-6">
            <h6>Unit & Team</h6>
            <table class="table table-sm table-bordered">
              <thead class="table-light"><tr><th>Unit</th><th>Lead</th><th>Members</th></tr></thead>
              <tbody><tr><td>HCIS</td><td>Sinta</td><td>8</td></tr><tr><td>Recruitment</td><td>Anto</td><td>4</td></tr><tr><td>Payroll</td><td>Bima</td><td>6</td></tr></tbody>
            </table>
          </div>
        </div>
      </div>
    </section>

    <!-- PERSONAL ADMINISTRATION (with modal view/edit + localStorage) -->
    <section id="personal" class="page">
      <div class="header-card mb-3 d-flex justify-content-between align-items-center">
        <div><h5 class="mb-0">Personal Administration</h5><div class="small-muted">Kelola data karyawan</div></div>
        <div>
          <button id="btnAddPerson" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Tambah Karyawan</button>
        </div>
      </div>

      <div class="settings-section">
        <table id="personalTable" class="table table-hover table-bordered">
          <thead class="table-light"><tr><th>NIK</th><th>Nama</th><th>Divisi</th><th>Jabatan</th><th>Aksi</th></tr></thead>
          <tbody></tbody>
        </table>
      </div>
    </section>

    <!-- TIME MANAGEMENT -->
    <section id="time" class="page">
      <div class="header-card mb-3"><div><h5 class="mb-0">Time Management System</h5><div class="small-muted">Absensi & jadwal</div></div></div>
      <div class="settings-section">
        <div class="row">
          <div class="col-lg-8">
            <h6>Absensi Hari Ini</h6>
            <table class="table table-sm table-bordered">
              <thead class="table-light"><tr><th>No</th><th>Nama</th><th>Masuk</th><th>Keluar</th><th>Status</th></tr></thead>
              <tbody><tr><td>1</td><td>Firza</td><td>08:02</td><td>17:05</td><td><span class="badge bg-success">Hadir</span></td></tr><tr><td>2</td><td>Rina</td><td>08:10</td><td>17:00</td><td><span class="badge bg-success">Hadir</span></td></tr></tbody>
            </table>
          </div>
          <div class="col-lg-4">
            <h6>Ringkasan</h6>
            <ul class="list-group"><li class="list-group-item d-flex justify-content-between">Hadir <span>96%</span></li><li class="list-group-item d-flex justify-content-between">Izin <span>2%</span></li></ul>
          </div>
        </div>
      </div>
    </section>

    <!-- TRAINING -->
    <section id="training" class="page">
      <div class="header-card mb-3"><div><h5 class="mb-0">Training Development</h5><div class="small-muted">Manajemen pelatihan</div></div><button class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Tambah Program</button></div>
      <div class="settings-section">
        <div class="row g-3">
          <div class="col-md-4"><div class="card p-3"><h6>Leadership Training</h6><p class="small-muted mb-2">Durasi: 3 hari</p><div class="progress mb-2" style="height:8px"><div class="progress-bar bg-success" style="width:34%"></div></div><small class="small-muted">34% peserta</small></div></div>
          <div class="col-md-4"><div class="card p-3"><h6>Data Analyst Workshop</h6><p class="small-muted mb-2">Durasi: 2 hari</p><div class="progress mb-2" style="height:8px"><div class="progress-bar bg-info" style="width:12%"></div></div><small class="small-muted">12% peserta</small></div></div>
          <div class="col-md-4"><div class="card p-3"><h6>Onboarding New Joiner</h6><p class="small-muted mb-2">Durasi: 1 hari</p><div class="progress mb-2" style="height:8px"><div class="progress-bar bg-warning" style="width:88%"></div></div><small class="small-muted">88% selesai</small></div></div>
        </div>
      </div>
    </section>

    <!-- PERFORMANCE -->
    <section id="performance" class="page">
      <div class="header-card mb-3"><div><h5 class="mb-0">Performance Management</h5><div class="small-muted">Evaluasi KPI & feedback</div></div></div>
      <div class="settings-section">
        <div class="row">
          <div class="col-lg-6"><h6>Skor Kinerja Bulanan</h6><canvas id="performanceChart" height="200"></canvas></div>
          <div class="col-lg-6"><h6>Top 5 Employee</h6><ol class="mt-3"><li>Rina S — 95</li><li>Firza A — 92</li><li>Bima — 90</li><li>Sinta — 89</li><li>Anto — 87</li></ol></div>
        </div>
      </div>
    </section>

    <!-- PAYROLL -> PURCHASE REQUISITION FORM -->
    <section id="payroll" class="page">
      <div class="header-card mb-3 d-flex justify-content-between align-items-center">
        <div><h5 class="mb-0">Tambah Harga - Purchase Requisition</h5><div class="small-muted">Masukkan harga item untuk PR</div></div>
        <div>
          <button id="btnNewPR" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Tambah Item</button>
        </div>
      </div>

      <div class="settings-section">
        <form id="prForm" class="row g-3">
          <div class="col-md-4"><label class="form-label">Item Name</label><input id="pr_item" class="form-control" required></div>
          <div class="col-md-2"><label class="form-label">Quantity</label><input id="pr_qty" type="number" min="1" class="form-control" value="1" required></div>
          <div class="col-md-3"><label class="form-label">Unit Price</label><input id="pr_price" type="number" min="0" class="form-control" value="0" required></div>
          <div class="col-md-3"><label class="form-label">Vendor</label><input id="pr_vendor" class="form-control"></div>
          <div class="col-md-12 d-flex justify-content-between align-items-center">
            <div><strong>Total: Rp <span id="pr_total">0</span></strong></div>
            <div><button id="prSave" class="btn btn-success">Simpan</button></div>
          </div>
        </form>

        <hr>

        <h6 class="mb-2">Daftar PR (Sementara)</h6>
        <table id="prTable" class="table table-sm table-bordered">
          <thead class="table-light"><tr><th>No</th><th>Item</th><th>Qty</th><th>Unit Price</th><th>Vendor</th><th>Total</th><th>Aksi</th></tr></thead>
          <tbody></tbody>
        </table>
      </div>
    </section>

    <!-- DATA VALIDATION -->
    <section id="validation" class="page">
      <div class="header-card mb-3"><div><h5 class="mb-0">Payroll Data Validation</h5><div class="small-muted">Cek data sebelum payroll</div></div></div>
      <div class="settings-section">
        <table class="table table-sm table-bordered text-center">
          <thead class="table-light"><tr><th>NO</th><th>ITEM CHECK LIST</th><th>TOTAL</th><th>STATUS</th><th>ACTION</th></tr></thead>
          <tbody><tr><td>1</td><td>Check Null Account Bank</td><td>8</td><td><span class="badge bg-danger">Not OK</span></td><td><button class="btn btn-outline-primary btn-sm">View</button></td></tr><tr><td>2</td><td>Check OT Without SPL</td><td>0</td><td><span class="badge bg-success">OK</span></td><td><button class="btn btn-outline-primary btn-sm">View</button></td></tr></tbody>
        </table>
      </div>
    </section>

    <!-- SETTING -->
    <section id="setting" class="page">
      <div class="header-card mb-3"><div><h5 class="mb-0">System Setting</h5><div class="small-muted">Pengaturan aplikasi</div></div></div>
      <div class="settings-section">
        <form id="settingForm" class="row g-3">
          <div class="col-md-6"><label class="form-label">Nama Sistem</label><input id="s_name" class="form-control"></div>
          <div class="col-md-6"><label class="form-label">Email Admin</label><input id="s_email" type="email" class="form-control"></div>
          <div class="col-md-4"><label class="form-label">Mode</label><select id="s_mode" class="form-select"><option>Production</option><option>Testing</option><option>Development</option></select></div>
          <div class="col-md-12 text-end"><button class="btn btn-primary">Simpan Setting</button></div>
        </form>
      </div>
    </section>

    <!-- PROFILE -->
    <section id="profile" class="page">
      <div class="header-card mb-3"><div><h5 class="mb-0">Profile</h5><div class="small-muted">Informasi pengguna</div></div></div>
      <div class="settings-section">
        <div class="row">
          <div class="col-md-4">
            <div class="card p-3 text-center">
              <div class="mb-3"><i class="bi bi-person-circle" style="font-size:56px;color:#2563eb"></i></div>
              <h6 id="profileName">Firza Arif</h6>
              <div class="small-muted">Developer - HCIS</div>
            </div>
          </div>
          <div class="col-md-8">
            <h6>Detail</h6>
            <table class="table table-sm table-borderless">
              <tbody>
                <tr><th style="width:160px">Email</th><td id="profileEmail">firza@example.com</td></tr>
                <tr><th>Phone</th><td id="profilePhone">0812-xxxx-xxxx</td></tr>
                <tr><th>Location</th><td id="profileLoc">Jakarta</td></tr>
              </tbody>
            </table>
            <button id="editProfile" class="btn btn-outline-primary btn-sm">Edit Profile</button>
          </div>
        </div>
      </div>
    </section>

  </main>

  <!-- MODALS -->
  <!-- Personal: Add/Edit Modal -->
  <div class="modal fade" id="personModal" tabindex="-1">
    <div class="modal-dialog">
      <form id="personForm" class="modal-content">
        <div class="modal-header"><h5 class="modal-title" id="personModalTitle">Tambah Karyawan</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body">
          <input type="hidden" id="person_index">
          <div class="mb-3"><label class="form-label">NIK</label><input id="person_nik" class="form-control" required></div>
          <div class="mb-3"><label class="form-label">Nama</label><input id="person_name" class="form-control" required></div>
          <div class="mb-3"><label class="form-label">Divisi</label><input id="person_div" class="form-control"></div>
          <div class="mb-3"><label class="form-label">Jabatan</label><input id="person_pos" class="form-control"></div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary">Simpan</button></div>
      </form>
    </div>
  </div>

  <!-- Personal: View Modal -->
  <div class="modal fade" id="personViewModal" tabindex="-1">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header"><h5 class="modal-title">Detail Karyawan</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body">
          <p><strong>NIK:</strong> <span id="view_nik"></span></p>
          <p><strong>Nama:</strong> <span id="view_name"></span></p>
          <p><strong>Divisi:</strong> <span id="view_div"></span></p>
          <p><strong>Jabatan:</strong> <span id="view_pos"></span></p>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button></div>
      </div>
    </div>
  </div>

  <!-- PR Edit Modal -->
  <div class="modal fade" id="prEditModal" tabindex="-1">
    <div class="modal-dialog">
      <form id="prEditForm" class="modal-content">
        <div class="modal-header"><h5 class="modal-title">Edit PR Item</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body">
          <input type="hidden" id="pr_index">
          <div class="mb-3"><label class="form-label">Item Name</label><input id="e_pr_item" class="form-control" required></div>
          <div class="mb-3"><label class="form-label">Quantity</label><input id="e_pr_qty" type="number" min="1" class="form-control" required></div>
          <div class="mb-3"><label class="form-label">Unit Price</label><input id="e_pr_price" type="number" min="0" class="form-control" required></div>
          <div class="mb-3"><label class="form-label">Vendor</label><input id="e_pr_vendor" class="form-control"></div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary">Update</button></div>
      </form>
    </div>
  </div>

  <!-- SCRIPTS -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    /* ---------- NAVIGATION ---------- */
    const menuItems = document.querySelectorAll('.menu li');
    const pages = document.querySelectorAll('.page');

    function showPage(id) {
      pages.forEach(p => p.classList.remove('active'));
      menuItems.forEach(mi => mi.classList.remove('active'));
      const page = document.getElementById(id);
      if (page) page.classList.add('active');
      document.querySelectorAll('.menu li[data-page="'+id+'"]').forEach(mi => mi.classList.add('active'));
    }

    menuItems.forEach(item => {
      item.addEventListener('click', () => {
        const pageId = item.getAttribute('data-page');
        showPage(pageId);
      });
    });

    // Ensure first page active
    showPage('dashboard');

    /* ---------- localStorage keys & helpers ---------- */
    const KEY_PERSON = 'hcis_personal';
    const KEY_PR = 'hcis_pr_list';
    const KEY_SETTING = 'hcis_setting';

    function readStorage(key) {
      const raw = localStorage.getItem(key);
      return raw ? JSON.parse(raw) : null;
    }
    function writeStorage(key, value) {
      localStorage.setItem(key, JSON.stringify(value));
    }

    /* ---------- PERSONAL CRUD ---------- */
    let personalList = readStorage(KEY_PERSON) || [
      { nik: '190120', name: 'Firza Arif', div: 'HCIS', pos: 'Developer' },
      { nik: '190121', name: 'Rina S', div: 'HR', pos: 'HR Officer' },
      { nik: '190122', name: 'Andi', div: 'Finance', pos: 'Analyst' }
    ];
    writeStorage(KEY_PERSON, personalList);

    const personalTableBody = document.querySelector('#personalTable tbody');
    const personModal = new bootstrap.Modal(document.getElementById('personModal'));
    const personViewModal = new bootstrap.Modal(document.getElementById('personViewModal'));

    function renderPersonal() {
      personalTableBody.innerHTML = '';
      personalList.forEach((p, idx) => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
          <td>${p.nik}</td>
          <td>${p.name}</td>
          <td>${p.div}</td>
          <td>${p.pos}</td>
          <td>
            <button class="btn btn-sm btn-outline-primary btn-view" data-idx="${idx}"><i class="bi bi-eye"></i></button>
            <button class="btn btn-sm btn-outline-warning btn-edit" data-idx="${idx}"><i class="bi bi-pencil"></i></button>
            <button class="btn btn-sm btn-outline-danger btn-del" data-idx="${idx}"><i class="bi bi-trash"></i></button>
          </td>`;
        personalTableBody.appendChild(tr);
      });
      document.getElementById('k_total').textContent = personalList.length;
      attachPersonalButtons();
    }

    function attachPersonalButtons() {
      document.querySelectorAll('.btn-view').forEach(btn => {
        btn.addEventListener('click', e => {
          const idx = +btn.dataset.idx;
          const p = personalList[idx];
          document.getElementById('view_nik').textContent = p.nik;
          document.getElementById('view_name').textContent = p.name;
          document.getElementById('view_div').textContent = p.div;
          document.getElementById('view_pos').textContent = p.pos;
          personViewModal.show();
        });
      });

      document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', e => {
          const idx = +btn.dataset.idx;
          const p = personalList[idx];
          document.getElementById('person_index').value = idx;
          document.getElementById('person_nik').value = p.nik;
          document.getElementById('person_name').value = p.name;
          document.getElementById('person_div').value = p.div;
          document.getElementById('person_pos').value = p.pos;
          document.getElementById('personModalTitle').textContent = 'Edit Karyawan';
          personModal.show();
        });
      });

      document.querySelectorAll('.btn-del').forEach(btn => {
        btn.addEventListener('click', e => {
          const idx = +btn.dataset.idx;
          if (confirm('Hapus data karyawan ini?')) {
            personalList.splice(idx,1);
            writeStorage(KEY_PERSON, personalList);
            renderPersonal();
          }
        });
      });
    }

    // open add modal
    document.getElementById('btnAddPerson').addEventListener('click', () => {
      document.getElementById('personForm').reset();
      document.getElementById('person_index').value = '';
      document.getElementById('personModalTitle').textContent = 'Tambah Karyawan';
      personModal.show();
    });

    // handle submit (add/edit)
    document.getElementById('personForm').addEventListener('submit', function(e){
      e.preventDefault();
      const idx = document.getElementById('person_index').value;
      const nik = document.getElementById('person_nik').value.trim();
      const name = document.getElementById('person_name').value.trim();
      const div = document.getElementById('person_div').value.trim();
      const pos = document.getElementById('person_pos').value.trim();
      if (idx === '') {
        // add
        personalList.push({ nik, name, div, pos });
      } else {
        // update
        personalList[+idx] = { nik, name, div, pos };
      }
      writeStorage(KEY_PERSON, personalList);
      personModal.hide();
      renderPersonal();
    });

    renderPersonal();

    /* ---------- PR (Purchase Requisition) CRUD ---------- */
    let prList = readStorage(KEY_PR) || [
      { item: 'Printer Toner', qty: 2, price: 450000, vendor: 'Vendor A' }
    ];
    writeStorage(KEY_PR, prList);

    const prForm = document.getElementById('prForm');
    const prTableBody = document.querySelector('#prTable tbody');
    const prEditModal = new bootstrap.Modal(document.getElementById('prEditModal'));

    function computePRTotal(qty, price) { return qty * price; }

    function renderPR() {
      prTableBody.innerHTML = '';
      prList.forEach((p, idx) => {
        const tr = document.createElement('tr');
        const total = computePRTotal(p.qty, p.price);
        tr.innerHTML = `<td>${idx+1}</td><td>${p.item}</td><td>${p.qty}</td><td>${formatNumber(p.price)}</td><td>${p.vendor || '-'}</td><td>${formatNumber(total)}</td>
          <td>
            <button class="btn btn-sm btn-outline-primary btn-edit-pr" data-idx="${idx}"><i class="bi bi-pencil"></i></button>
            <button class="btn btn-sm btn-outline-danger btn-del-pr" data-idx="${idx}"><i class="bi bi-trash"></i></button>
          </td>`;
        prTableBody.appendChild(tr);
      });
      attachPRButtons();
    }

    // helper format
    function formatNumber(n) {
      return new Intl.NumberFormat('id-ID').format(n);
    }

    function attachPRButtons() {
      document.querySelectorAll('.btn-edit-pr').forEach(btn => {
        btn.addEventListener('click', () => {
          const idx = +btn.dataset.idx;
          const p = prList[idx];
          document.getElementById('pr_index').value = idx;
          document.getElementById('e_pr_item').value = p.item;
          document.getElementById('e_pr_qty').value = p.qty;
          document.getElementById('e_pr_price').value = p.price;
          document.getElementById('e_pr_vendor').value = p.vendor;
          prEditModal.show();
        });
      });
      document.querySelectorAll('.btn-del-pr').forEach(btn => {
        btn.addEventListener('click', () => {
          const idx = +btn.dataset.idx;
          if (confirm('Hapus item PR ini?')) {
            prList.splice(idx,1);
            writeStorage(KEY_PR, prList);
            renderPR();
          }
        });
      });
    }

    // update PR total display on form
    function updatePRTotalDisplay() {
      const qty = +document.getElementById('pr_qty').value || 0;
      const price = +document.getElementById('pr_price').value || 0;
      document.getElementById('pr_total').textContent = formatNumber(qty * price);
    }
    document.getElementById('pr_qty').addEventListener('input', updatePRTotalDisplay);
    document.getElementById('pr_price').addEventListener('input', updatePRTotalDisplay);

    // Save new PR item
    prForm.addEventListener('submit', function(e){
      e.preventDefault();
      const item = document.getElementById('pr_item').value.trim();
      const qty = +document.getElementById('pr_qty').value;
      const price = +document.getElementById('pr_price').value;
      const vendor = document.getElementById('pr_vendor').value.trim();
      prList.push({ item, qty, price, vendor });
      writeStorage(KEY_PR, prList);
      prForm.reset();
      document.getElementById('pr_total').textContent = '0';
      renderPR();
      showPage('payroll');
    });

    // handle edit PR modal submit
    document.getElementById('prEditForm').addEventListener('submit', function(e){
      e.preventDefault();
      const idx = +document.getElementById('pr_index').value;
      const item = document.getElementById('e_pr_item').value.trim();
      const qty = +document.getElementById('e_pr_qty').value;
      const price = +document.getElementById('e_pr_price').value;
      const vendor = document.getElementById('e_pr_vendor').value.trim();
      prList[idx] = { item, qty, price, vendor };
      writeStorage(KEY_PR, prList);
      prEditModal.hide();
      renderPR();
    });

    // quick new item button focuses form
    document.getElementById('btnNewPR').addEventListener('click', () => {
      showPage('payroll');
      document.getElementById('pr_item').focus();
    });

    renderPR();

    /* ---------- SETTINGS (load/save) ---------- */
    const settingData = readStorage(KEY_SETTING) || { name: 'HCIS Smarthic', email: 'admin@hcis.co.id', mode: 'Production' };
    document.getElementById('s_name').value = settingData.name;
    document.getElementById('s_email').value = settingData.email;
    document.getElementById('s_mode').value = settingData.mode;

    document.getElementById('settingForm').addEventListener('submit', function(e){
      e.preventDefault();
      const data = { name: document.getElementById('s_name').value.trim(), email: document.getElementById('s_email').value.trim(), mode: document.getElementById('s_mode').value };
      writeStorage(KEY_SETTING, data);
      alert('Setting disimpan.');
    });

    /* ---------- PROFILE edit (demo) ---------- */
    document.getElementById('editProfile').addEventListener('click', () => {
      const newName = prompt('Nama pengguna:', document.getElementById('profileName').textContent);
      if (newName) document.getElementById('profileName').textContent = newName;
    });

    /* ---------- CHAT demo ---------- */
    document.getElementById('sendBtn').addEventListener('click', () => {
      const input = document.getElementById('chatInput');
      const box = document.getElementById('chatBox');
      const text = input.value.trim();
      if (!text) return;
      const el = document.createElement('div');
      el.className = 'msg me';
      el.innerHTML = `<strong>Anda</strong><div>${escapeHtml(text)}</div>`;
      box.appendChild(el);
      box.scrollTop = box.scrollHeight;
      input.value = '';
    });

    function escapeHtml(s) { return s.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;'); }

    /* ---------- Charts ---------- */
    const attendanceCtx = document.getElementById('attendanceChart').getContext('2d');
    const attendanceChart = new Chart(attendanceCtx, {
      type: 'line',
      data: { labels: ['Sen','Sel','Rab','Kam','Jum'], datasets: [{ label:'Kehadiran (%)', data:[95,97,93,98,96], borderColor:'#2563eb', backgroundColor:'rgba(37,99,235,0.12)', fill:true, tension:0.3 }] },
      options:{ responsive:true, plugins:{ legend:{ display:false } }, scales:{ y:{ beginAtZero:true, max:100 }, x:{ grid:{ display:false } } } }
    });

    document.getElementById('attendanceRange').addEventListener('change', function(e){
      if (e.target.value === 'month') {
        attendanceChart.data.labels = ['W1','W2','W3','W4'];
        attendanceChart.data.datasets[0].data = [94,95,96,96];
      } else {
        attendanceChart.data.labels = ['Sen','Sel','Rab','Kam','Jum'];
        attendanceChart.data.datasets[0].data = [95,97,93,98,96];
      }
      attendanceChart.update();
    });

    const surveyCtx = document.getElementById('surveyChart').getContext('2d');
    const surveyChart = new Chart(surveyCtx, { type:'doughnut', data:{ labels:['Terisi','Belum Terisi'], datasets:[{ data:[72,28] }] }, options:{ responsive:true, plugins:{ legend:{ position:'bottom' } } } });

    const perfCtx = document.getElementById('performanceChart').getContext('2d');
    const performanceChart = new Chart(perfCtx, { type:'bar', data:{ labels:['Jan','Feb','Mar','Apr','May','Jun'], datasets:[{ label:'Rata-rata Score', data:[78,81,83,79,85,87], backgroundColor:'rgba(37,99,235,0.7)' }] }, options:{ responsive:true, plugins:{ legend:{ display:false } }, scales:{ y:{ beginAtZero:true, max:100 } } } });

    /* ---------- Utility: initial load ---------- */
    // If no localStorage keys exist, they were initialized above. Update UI counts:
    document.getElementById('k_total').textContent = personalList.length;
    renderPersonal();
    renderPR();

  </script>
</body>
</html>
