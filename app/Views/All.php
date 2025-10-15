<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <title>HCIS Smarthic — Final Bundle</title>
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <!-- Bootstrap CSS + Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <style>
    :root{
      --brand:#0d6efd;
      --accent:#0648b0;
      --surface:#f6f9ff;
      --card-radius:12px;
      --success:#16a34a;
      --danger:#dc2626;
    }
    *{box-sizing:border-box}
    html,body{height:100%;margin:0;font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial;background:var(--surface);color:#0b1724}
    /* LOGIN */
    .login-page{
      min-height:100vh;
      background-image:linear-gradient(rgba(3,7,18,0.35),rgba(3,7,18,0.35)), url('https://images.unsplash.com/photo-1521790797524-b2497295b8a0?auto=format&fit=crop&w=1920&q=80');
      background-size:cover;
      background-position:center;
      display:flex;align-items:center;justify-content:center;
    }
    .login-card{
      width:100%;max-width:420px;background:rgba(255,255,255,0.95);border-radius:16px;padding:32px;box-shadow:0 12px 30px rgba(4,9,30,0.28);backdrop-filter: blur(4px);
    }
    .login-logo{width:84px;margin-bottom:6px}
    /* APP LAYOUT */
    .app-wrap{display:flex;min-height:100vh}
    .sidebar{
      width:260px;background:linear-gradient(180deg,var(--brand),var(--accent));color:#e7f0ff;padding:18px 12px;position:fixed;left:0;top:0;bottom:0;overflow:auto;
      box-shadow:2px 0 12px rgba(3,7,18,0.12);
    }
    .sidebar .brand{display:flex;align-items:center;gap:10px;padding:8px 12px 18px;border-bottom:1px solid rgba(255,255,255,0.06);margin-bottom:12px}
    .sidebar .brand img{width:38px}
    .sidebar h1{font-size:16px;margin:0;font-weight:700;color:#fff}
    .nav-list{list-style:none;padding:0;margin:0}
    .nav-item{margin:6px 8px}
    .nav-link{display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:10px;color:rgba(255,255,255,0.92);text-decoration:none}
    .nav-link:hover{background:rgba(255,255,255,0.06)}
    .nav-link.active{background:rgba(0,0,0,0.12);box-shadow:inset 0 0 0 1px rgba(255,255,255,0.03)}
    .sidebar-footer{margin-top:14px;padding:8px 12px;font-size:12px;color:rgba(255,255,255,0.8);border-top:1px solid rgba(255,255,255,0.03)}
    main.content{margin-left:300px;padding:22px;flex:1;min-height:100vh}
    .card-radius{border-radius:var(--card-radius)}
    /* Page transitions (fade + slight slide) */
    .page{display:none;opacity:0;transform:translateY(10px);transition:opacity .26s ease,transform .26s ease}
    .page.active{display:block;opacity:1;transform:translateY(0)}
    /* Toast */
    .toast-wrap{position:fixed;right:18px;top:18px;z-index:2200;display:flex;flex-direction:column;gap:10px}
    .toast-card{min-width:220px;color:#fff;padding:10px 14px;border-radius:10px;box-shadow:0 10px 24px rgba(4,9,30,0.12);transform:translateY(-8px);opacity:0;transition:transform .18s,opacity .18s}
    .toast-card.show{transform:none;opacity:1}
    .toast-success{background:linear-gradient(90deg,#16a34a,#34d399)}
    .toast-error{background:linear-gradient(90deg,#ef4444,#f87171)}
    .toast-info{background:linear-gradient(90deg,#0d6efd,#2563eb)}
    /* Modal smooth */
    .modal.fade .modal-dialog{transform:translateY(10px);transition:transform .26s cubic-bezier(.2,.8,.2,1),opacity .15s}
    .modal.fade.show .modal-dialog{transform:none}
    /* Responsive */
    @media (max-width:900px){
      .sidebar{width:68px;padding:12px}
      .sidebar h1{display:none}
      .nav-link span{display:none}
      main.content{margin-left:84px;padding:16px}
    }
    /* small helpers */
    .muted { color:#6b7280 }
    .kpi { padding:14px;border-radius:10px;background:linear-gradient(180deg,#fff,#f8fbff);box-shadow:0 8px 18px rgba(6,14,40,0.04);display:flex;justify-content:space-between;align-items:center;gap:12px }
    .kpi .title { font-size:13px;color:#64748b }
    .kpi .val { font-size:20px;font-weight:700 }
  </style>
</head>
<body>

  <!-- LOGIN PAGE -->
  <div id="loginPage" class="login-page" aria-hidden="false">
    <div class="login-card text-center" role="main" aria-labelledby="loginTitle">
      <img class="login-logo" src="https://i.ibb.co/t3v0BzG/hcis-logo.png" alt="HCIS Logo">
      <h2 id="loginTitle" class="fw-bold mb-1">HCIS Smarthic</h2>
      <p class="muted mb-3">Masuk untuk melihat dashboard & data perusahaan</p>

      <div class="form-floating mb-3">
        <input id="loginUser" class="form-control" placeholder="username" aria-label="username">
        <label for="loginUser">Username</label>
      </div>
      <div class="form-floating mb-3">
        <input id="loginPass" type="password" class="form-control" placeholder="password" aria-label="password">
        <label for="loginPass">Password</label>
      </div>

      <div class="d-grid gap-2">
        <button id="btnLogin" class="btn btn-primary btn-lg">Masuk</button>
      </div>

      <div id="loginError" class="text-danger small mt-2" style="min-height:20px"></div>
      <div class="text-muted small mt-3">Demo credentials: <strong>admin / 12345</strong></div>
    </div>
  </div>

  <!-- APP -->
  <div id="app" class="app-wrap" style="display:none;" aria-hidden="true">
    <!-- SIDEBAR -->
    <aside class="sidebar" role="navigation" aria-label="Main menu">
      <div class="brand">
        <img src="https://i.ibb.co/t3v0BzG/hcis-logo.png" alt="logo">
        <div>
          <h1>Addon SmartHCIS</h1>
          <div class="muted small">Human Capital Addon</div>
        </div>
      </div>

      <ul class="nav-list" role="menu" aria-label="Primary">
        <li class="nav-item"><a class="nav-link active" href="#" data-page="dashboard"><i class="bi bi-speedometer2 fs-5"></i><span>Dashboard</span></a></li>
        <li class="nav-item"><a class="nav-link" href="#" data-page="personal"><i class="bi bi-people-fill fs-5"></i><span>Personal Admin</span></a></li>
        <li class="nav-item"><a class="nav-link" href="#" data-page="payroll"><i class="bi bi-wallet2 fs-5"></i><span>Purchase Requisition</span></a></li>
        <li class="nav-item"><a class="nav-link" href="#" data-page="training"><i class="bi bi-award fs-5"></i><span>Training Dev</span></a></li>
        <li class="nav-item"><a class="nav-link" href="#" data-page="performance"><i class="bi bi-graph-up fs-5"></i><span>Performance</span></a></li>
        <li class="nav-item"><a class="nav-link" href="#" data-page="validation"><i class="bi bi-list-check fs-5"></i><span>Data Validation</span></a></li>
        <li class="nav-item"><a class="nav-link" href="#" data-page="setting"><i class="bi bi-gear fs-5"></i><span>System Setting</span></a></li>
        <li class="nav-item"><a class="nav-link" href="#" data-page="profile"><i class="bi bi-person-circle fs-5"></i><span>Profile</span></a></li>
        <li class="nav-item mt-2"><a class="nav-link" id="logoutBtn" href="#" style="color:#fff"><i class="bi bi-box-arrow-right fs-5"></i><span>Logout</span></a></li>
      </ul>

      <div class="sidebar-footer">© 2025 Human Capital Information System</div>
    </aside>

    <!-- MAIN -->
    <main class="content" role="main">
      <!-- DASHBOARD -->
      <section id="page-dashboard" class="page active" aria-labelledby="dashTitle">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <div>
            <h2 id="dashTitle" class="mb-0">Dashboard</h2>
            <div class="muted">Ringkasan performa dan aktivitas sistem</div>
          </div>
          <div class="d-flex gap-2">
            <button id="exportAllBtn" class="btn btn-outline-light btn-sm" title="Export demo"><i class="bi bi-download"></i> Export Demo</button>
          </div>
        </div>

        <div class="row g-3 mb-4">
          <div class="col-md-3">
            <div class="kpi">
              <div><div class="title">Total Karyawan</div><div class="val" id="k_total">0</div></div>
              <div class="text-muted text-end"><i class="bi bi-people-fill fs-3" style="color:var(--brand)"></i></div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="kpi">
              <div><div class="title">Pelatihan Aktif</div><div class="val" id="k_training">0</div></div>
              <div class="text-muted text-end"><i class="bi bi-award fs-3" style="color:#f59e0b"></i></div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="kpi">
              <div><div class="title">Kehadiran Hari Ini</div><div class="val" id="k_attendance">96%</div></div>
              <div class="text-muted text-end"><i class="bi bi-clock-history fs-3" style="color:#10b981"></i></div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="kpi">
              <div><div class="title">Proyek Aktif</div><div class="val" id="k_projects">5</div></div>
              <div class="text-muted text-end"><i class="bi bi-kanban fs-3" style="color:#0ea5e9"></i></div>
            </div>
          </div>
        </div>

        <div class="card p-3 mb-3 card-radius">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="mb-0">Grafik Kehadiran Karyawan</h6>
            <select id="attendanceRange" class="form-select form-select-sm w-auto">
              <option value="week">Mingguan</option>
              <option value="month">Bulanan</option>
            </select>
          </div>
          <canvas id="attendanceChart" height="140"></canvas>
        </div>
      </section>

      <!-- PERSONAL -->
      <section id="page-personal" class="page" aria-labelledby="personalTitle" hidden>
        <div class="d-flex justify-content-between align-items-center mb-3">
          <div>
            <h2 id="personalTitle" class="mb-0">Personal Administration</h2>
            <div class="muted">Kelola data karyawan</div>
          </div>
          <div>
            <button id="exportPersonal" class="btn btn-outline-light btn-sm me-2"><i class="bi bi-download"></i> Export CSV</button>
            <button id="btnAddPerson" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Tambah Karyawan</button>
          </div>
        </div>

        <div class="card p-3 card-radius">
          <table class="table table-hover mb-0">
            <thead class="table-light"><tr><th>NIK</th><th>Nama</th><th>Divisi</th><th>Jabatan</th><th style="width:140px">Aksi</th></tr></thead>
            <tbody id="personalTBody"></tbody>
          </table>
        </div>
      </section>

      <!-- PAYROLL (PR) -->
      <section id="page-payroll" class="page" aria-labelledby="prTitle" hidden>
        <div class="d-flex justify-content-between align-items-center mb-3">
          <div>
            <h2 id="prTitle" class="mb-0">Purchase Requisition (Tambah Harga)</h2>
            <div class="muted">Masukkan harga item untuk PR</div>
          </div>
          <div>
            <button id="exportPR" class="btn btn-outline-light btn-sm me-2"><i class="bi bi-download"></i> Export CSV</button>
            <button id="btnNewPR" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Tambah Item</button>
          </div>
        </div>

        <div class="card p-3 mb-3 card-radius">
          <form id="prForm" class="row g-2">
            <div class="col-md-4"><label class="form-label">Item</label><input id="pr_item" class="form-control" required></div>
            <div class="col-md-2"><label class="form-label">Qty</label><input id="pr_qty" type="number" min="1" value="1" class="form-control" required></div>
            <div class="col-md-3"><label class="form-label">Unit Price</label><input id="pr_price" type="number" min="0" value="0" class="form-control" required></div>
            <div class="col-md-3"><label class="form-label">Vendor</label><input id="pr_vendor" class="form-control"></div>
            <div class="col-12 d-flex justify-content-between align-items-center mt-2">
              <div><strong>Total: Rp <span id="pr_total">0</span></strong></div>
              <div><button class="btn btn-success" type="submit">Simpan</button></div>
            </div>
          </form>
        </div>

        <div class="card p-3 card-radius">
          <h6 class="mb-3">Daftar PR (Sementara)</h6>
          <table class="table table-sm">
            <thead class="table-light"><tr><th>No</th><th>Item</th><th>Qty</th><th>Unit Price</th><th>Vendor</th><th>Total</th><th style="width:130px">Aksi</th></tr></thead>
            <tbody id="prTBody"></tbody>
          </table>
        </div>
      </section>

      <!-- TRAINING -->
      <section id="page-training" class="page" hidden>
        <h2 class="mb-3">Training Development</h2>
        <div class="card p-3 card-radius">
          <div class="row g-3">
            <div class="col-md-4"><div class="p-3"><h6>Leadership Training</h6><p class="muted small">Durasi: 3 hari</p></div></div>
            <div class="col-md-4"><div class="p-3"><h6>Data Analyst Workshop</h6><p class="muted small">Durasi: 2 hari</p></div></div>
            <div class="col-md-4"><div class="p-3"><h6>Onboarding New Joiner</h6><p class="muted small">Durasi: 1 hari</p></div></div>
          </div>
        </div>
      </section>

      <!-- PERFORMANCE -->
      <section id="page-performance" class="page" hidden>
        <h2 class="mb-3">Performance Management</h2>
        <div class="card p-3 card-radius">
          <div class="row">
            <div class="col-lg-6"><h6>Skor Kinerja Bulanan</h6><canvas id="performanceChart" height="180"></canvas></div>
            <div class="col-lg-6"><h6>Top 5 Employee</h6><ol id="topEmployees" class="mt-3"></ol></div>
          </div>
        </div>
      </section>

      <!-- VALIDATION -->
      <section id="page-validation" class="page" hidden>
        <h2 class="mb-3">Payroll Data Validation</h2>
        <div class="card p-3 card-radius">
          <table class="table table-sm text-center">
            <thead class="table-light"><tr><th>NO</th><th>ITEM CHECK LIST</th><th>TOTAL</th><th>STATUS</th><th>ACTION</th></tr></thead>
            <tbody id="validationFullTBody"></tbody>
          </table>
        </div>
      </section>

      <!-- SETTING -->
      <section id="page-setting" class="page" hidden>
        <h2 class="mb-3">System Setting</h2>
        <div class="card p-3 card-radius">
          <form id="settingForm" class="row g-3">
            <div class="col-md-6"><label class="form-label">Nama Sistem</label><input id="s_name" class="form-control"></div>
            <div class="col-md-6"><label class="form-label">Email Admin</label><input id="s_email" type="email" class="form-control"></div>
            <div class="col-md-4"><label class="form-label">Mode</label><select id="s_mode" class="form-select"><option>Production</option><option>Testing</option><option>Development</option></select></div>
            <div class="col-12 text-end"><button class="btn btn-primary">Simpan Setting</button></div>
          </form>
        </div>
      </section>

      <!-- PROFILE -->
      <section id="page-profile" class="page" hidden>
        <h2 class="mb-3">Profile</h2>
        <div class="card p-3 card-radius">
          <p><strong>Nama:</strong> <span id="profileName">Admin HCIS</span></p>
          <p><strong>Email:</strong> <span id="profileEmail">admin@hcis.com</span></p>
        </div>
      </section>
    </main>
  </div>

  <!-- Toast container -->
  <div class="toast-wrap" id="toastWrap" aria-live="polite" aria-atomic="true"></div>

  <!-- MODALS -->
  <!-- Person Add/Edit -->
  <div class="modal fade" id="personModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <form id="personForm" class="modal-content">
        <div class="modal-header"><h5 id="personModalTitle" class="modal-title">Tambah Karyawan</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
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

  <!-- Person View -->
  <div class="modal fade" id="personViewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header"><h5 class="modal-title">Detail Karyawan</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body">
          <p><strong>NIK:</strong> <span id="view_nik"></span></p>
          <p><strong>Nama:</strong> <span id="view_name"></span></p>
          <p><strong>Divisi:</strong> <span id="view_div"></span></p>
          <p><strong>Jabatan:</strong> <span id="view_pos"></span></p>
        </div>
        <div class="modal-footer"><button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button></div>
      </div>
    </div>
  </div>

  <!-- PR Edit Modal -->
  <div class="modal fade" id="prEditModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <form id="prEditForm" class="modal-content">
        <div class="modal-header"><h5 class="modal-title">Edit PR Item</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body">
          <input type="hidden" id="pr_edit_index">
          <div class="mb-3"><label class="form-label">Item</label><input id="e_pr_item" class="form-control" required></div>
          <div class="mb-3"><label class="form-label">Qty</label><input id="e_pr_qty" type="number" min="1" class="form-control" required></div>
          <div class="mb-3"><label class="form-label">Unit Price</label><input id="e_pr_price" type="number" min="0" class="form-control" required></div>
          <div class="mb-3"><label class="form-label">Vendor</label><input id="e_pr_vendor" class="form-control"></div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary">Update</button></div>
      </form>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
  /* --------------------------
     Helpers: toast, format, escape
     -------------------------- */
  const toastWrap = document.getElementById('toastWrap');
  function showToast(title, msg, type='info', ms=2600) {
    const el = document.createElement('div');
    el.className = 'toast-card ' + (type==='success' ? 'toast-success' : (type==='error' ? 'toast-error' : 'toast-info'));
    el.innerHTML = `<div style="font-weight:700;margin-bottom:4px">${title}</div><div style="font-size:13px">${msg}</div>`;
    toastWrap.appendChild(el);
    requestAnimationFrame(()=> el.classList.add('show'));
    setTimeout(()=> { el.classList.remove('show'); setTimeout(()=> el.remove(), 300); }, ms);
  }
  function formatIDR(n){ return new Intl.NumberFormat('id-ID').format(n); }
  function escapeHtml(s=''){ return String(s).replaceAll('&','&amp;').replaceAll('<','&lt;').replaceAll('>','&gt;'); }

  /* --------------------------
     Auth (login)
     -------------------------- */
  const LOGIN_KEY = 'hcis_demo_logged';
  const demoUser = { user:'admin', pass:'12345' };
  const loginPage = document.getElementById('loginPage');
  const app = document.getElementById('app');

  document.getElementById('btnLogin').addEventListener('click', () => {
    const u = document.getElementById('loginUser').value.trim();
    const p = document.getElementById('loginPass').value.trim();
    const err = document.getElementById('loginError');
    if(!u || !p){ err.textContent = 'Username & password wajib diisi.'; showToast('Error','Username & password wajib diisi.','error'); return; }
    if(u === demoUser.user && p === demoUser.pass){
      localStorage.setItem(LOGIN_KEY, '1');
      err.textContent = '';
      showToast('Sukses','Login berhasil.','success');
      setTimeout(()=> {
        loginPage.style.display = 'none';
        app.style.display = 'flex';
        app.setAttribute('aria-hidden','false');
        initAfterLogin();
      }, 350);
    } else {
      err.textContent = 'Username atau password salah.';
      showToast('Gagal','Kredensial salah.','error');
    }
  });

  // Quick Enter key to login
  ['loginUser','loginPass'].forEach(id => {
    document.getElementById(id).addEventListener('keydown', (e) => { if(e.key === 'Enter') document.getElementById('btnLogin').click(); });
  });

  // Auto-login if flag set
  window.addEventListener('load', () => {
    if(localStorage.getItem(LOGIN_KEY) === '1'){
      loginPage.style.display = 'none';
      app.style.display = 'flex';
      app.setAttribute('aria-hidden','false');
      initAfterLogin();
    }
  });

  /* --------------------------
     Navigation: show pages with transitions
     -------------------------- */
  document.querySelectorAll('.nav-link').forEach(link => {
    link.addEventListener('click', (ev) => {
      ev.preventDefault();
      document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
      link.classList.add('active');
      const page = link.dataset.page;
      showPage(page);
    });
  });

  function showPage(id){
    document.querySelectorAll('main .page').forEach(p => { p.classList.remove('active'); p.hidden = true; });
    const target = document.getElementById('page-' + id);
    if(!target) return;
    target.hidden = false;
    requestAnimationFrame(()=> target.classList.add('active'));
    // lazy-update some pages
    if(id === 'performance') renderPerformanceChart();
  }

  // Logout
  document.getElementById('logoutBtn').addEventListener('click', (e) => {
    e.preventDefault();
    localStorage.removeItem(LOGIN_KEY);
    showToast('Logout','Anda telah logout','info');
    setTimeout(()=> location.reload(), 600);
  });

  /* --------------------------
     Local storage helpers & seed data
     -------------------------- */
  function read(key){ const raw = localStorage.getItem(key); return raw ? JSON.parse(raw) : null; }
  function write(key, val){ localStorage.setItem(key, JSON.stringify(val)); }

  const KEY_PERSON = 'hcis_personal_demo';
  const KEY_PR = 'hcis_pr_demo';
  const KEY_SURVEY = 'hcis_survey_demo';
  const KEY_SETTING = 'hcis_setting_demo';

  if(!read(KEY_PERSON)){
    write(KEY_PERSON, [
      { nik:'190120', name:'Firza Arif', div:'HCIS', pos:'Developer' },
      { nik:'190121', name:'Rina S', div:'HR', pos:'HR Officer' },
      { nik:'190122', name:'Andi', div:'Finance', pos:'Analyst' }
    ]);
  }
  if(!read(KEY_PR)){
    write(KEY_PR, [
      { item:'Printer Toner', qty:2, price:450000, vendor:'Vendor A' },
      { item:'Mouse Logitech', qty:5, price:150000, vendor:'Vendor B' }
    ]);
  }
  if(!read(KEY_SURVEY)){
    write(KEY_SURVEY, [
      { title:'Survei Kepuasan Kerja 2025', deadline:'30 Nov 2025', progress:72 },
      { title:'Survei Lingkungan Kerja', deadline:'15 Des 2025', progress:38 }
    ]);
  }
  if(!read(KEY_SETTING)){
    write(KEY_SETTING, { name:'HCIS Smarthic', email:'admin@hcis.co.id', mode:'Production' });
  }

  /* --------------------------
     After login: init UI, listeners, render
     -------------------------- */
  let attendanceChart = null;
  function initAfterLogin(){
    // show dashboard
    showPage('dashboard');

    // populate counts
    document.getElementById('k_total').textContent = (read(KEY_PERSON) || []).length;
    document.getElementById('k_training').textContent = (read(KEY_SURVEY) || []).length;

    // render
    renderAttendanceChart();
    renderPersonalList();
    renderPRList();
    renderSurveys();
    renderValidation();
    renderPerformanceList();

    // attach listeners
    attachAppListeners();
  }

  function attachAppListeners(){
    // PERSONAL: open add modal
    document.getElementById('btnAddPerson').addEventListener('click', () => {
      document.getElementById('personForm').reset();
      document.getElementById('person_index').value = '';
      document.getElementById('personModalTitle').textContent = 'Tambah Karyawan';
      new bootstrap.Modal(document.getElementById('personModal')).show();
    });

    // personal export
    document.getElementById('exportPersonal').addEventListener('click', () => exportCSV(KEY_PERSON, 'personal.csv'));

    // person form submit (add/edit)
    document.getElementById('personForm').addEventListener('submit', (e) => {
      e.preventDefault();
      const idx = document.getElementById('person_index').value;
      const nik = document.getElementById('person_nik').value.trim();
      const name = document.getElementById('person_name').value.trim();
      const div = document.getElementById('person_div').value.trim();
      const pos = document.getElementById('person_pos').value.trim();
      if(!nik || !name){ showToast('Error','NIK & Nama wajib diisi','error'); return; }
      const arr = read(KEY_PERSON) || [];
      if(idx === '') { arr.push({ nik, name, div, pos }); showToast('Sukses','Karyawan ditambahkan','success'); }
      else { arr[+idx] = { nik, name, div, pos }; showToast('Sukses','Data karyawan diperbarui','success'); }
      write(KEY_PERSON, arr);
      bootstrap.Modal.getInstance(document.getElementById('personModal')).hide();
      renderPersonalList();
      document.getElementById('k_total').textContent = arr.length;
    });

    // PR: realtime total update
    ['pr_qty','pr_price'].forEach(id => {
      document.getElementById(id).addEventListener('input', updatePRTotalDisplay);
    });

    // PR form submit (add)
    document.getElementById('prForm').addEventListener('submit', (e) => {
      e.preventDefault();
      const item = document.getElementById('pr_item').value.trim();
      const qty = parseInt(document.getElementById('pr_qty').value) || 0;
      const price = parseFloat(document.getElementById('pr_price').value) || 0;
      const vendor = document.getElementById('pr_vendor').value.trim();
      if(!item){ showToast('Error','Item wajib diisi','error'); return; }
      if(qty <= 0){ showToast('Error','Qty harus > 0','error'); return; }
      const arr = read(KEY_PR) || [];
      arr.push({ item, qty, price, vendor });
      write(KEY_PR, arr);
      showToast('Sukses','PR disimpan','success');
      document.getElementById('prForm').reset();
      document.getElementById('pr_total').textContent = '0';
      renderPRList();
    });

    // PR export
    document.getElementById('exportPR').addEventListener('click', () => exportCSV(KEY_PR, 'pr_list.csv'));

    // create survey
    document.getElementById('createSurvey')?.addEventListener('click', () => {
      const arr = read(KEY_SURVEY) || [];
      arr.push({ title:'Survei Baru', deadline:'- - -', progress:0 });
      write(KEY_SURVEY, arr); renderSurveys(); showToast('Sukses','Survei dibuat (dummy)','success');
    });

    // settings save
    document.getElementById('settingForm')?.addEventListener('submit', (e) => {
      e.preventDefault();
      const d = { name: document.getElementById('s_name').value.trim(), email:document.getElementById('s_email').value.trim(), mode:document.getElementById('s_mode').value };
      write(KEY_SETTING, d); showToast('Sukses','Setting disimpan','success');
    });

    // export demo (top-right)
    document.getElementById('exportAllBtn').addEventListener('click', ()=> {
      exportCSV(KEY_PERSON,'personal.csv');
      exportCSV(KEY_PR,'pr_list.csv');
      showToast('Selesai','Export demo: personal + PR','success');
    });

    // quick new PR focus
    document.getElementById('btnNewPR').addEventListener('click', ()=> {
      showPage('payroll');
      document.getElementById('pr_item').focus();
    });
  }

  /* --------------------------
     Personal: render, view, edit, delete
     -------------------------- */
  function renderPersonalList(){
    const arr = read(KEY_PERSON) || [];
    const tbody = document.getElementById('personalTBody');
    tbody.innerHTML = arr.map((p,i)=>`
      <tr>
        <td>${escapeHtml(p.nik)}</td>
        <td>${escapeHtml(p.name)}</td>
        <td>${escapeHtml(p.div)}</td>
        <td>${escapeHtml(p.pos)}</td>
        <td>
          <button class="btn btn-sm btn-outline-primary me-1" onclick="viewPerson(${i})"><i class="bi bi-eye"></i></button>
          <button class="btn btn-sm btn-outline-warning me-1" onclick="editPerson(${i})"><i class="bi bi-pencil"></i></button>
          <button class="btn btn-sm btn-outline-danger" onclick="deletePerson(${i})"><i class="bi bi-trash"></i></button>
        </td>
      </tr>
    `).join('');
  }

  window.viewPerson = function(i){
    const arr = read(KEY_PERSON) || []; const p = arr[i]; if(!p) return;
    document.getElementById('view_nik').textContent = p.nik;
    document.getElementById('view_name').textContent = p.name;
    document.getElementById('view_div').textContent = p.div;
    document.getElementById('view_pos').textContent = p.pos;
    new bootstrap.Modal(document.getElementById('personViewModal')).show();
  };

  window.editPerson = function(i){
    const arr = read(KEY_PERSON) || []; const p = arr[i]; if(!p) return;
    document.getElementById('person_index').value = i;
    document.getElementById('person_nik').value = p.nik;
    document.getElementById('person_name').value = p.name;
    document.getElementById('person_div').value = p.div;
    document.getElementById('person_pos').value = p.pos;
    document.getElementById('personModalTitle').textContent = 'Edit Karyawan';
    new bootstrap.Modal(document.getElementById('personModal')).show();
  };

  window.deletePerson = function(i){
    if(!confirm('Hapus data karyawan ini?')) return;
    const arr = read(KEY_PERSON) || []; arr.splice(i,1); write(KEY_PERSON, arr);
    renderPersonalList(); showToast('Sukses','Karyawan dihapus','success');
    document.getElementById('k_total').textContent = arr.length;
  };

  /* --------------------------
     PR: render, edit, delete
     -------------------------- */
  function updatePRTotalDisplay(){
    const q = +document.getElementById('pr_qty').value || 0;
    const p = +document.getElementById('pr_price').value || 0;
    document.getElementById('pr_total').textContent = formatIDR(q * p);
  }

  function renderPRList(){
    const arr = read(KEY_PR) || [];
    const tbody = document.getElementById('prTBody');
    tbody.innerHTML = arr.map((r,i)=>`
      <tr>
        <td>${i+1}</td>
        <td>${escapeHtml(r.item)}</td>
        <td>${r.qty}</td>
        <td>Rp ${formatIDR(r.price)}</td>
        <td>${escapeHtml(r.vendor || '-')}</td>
        <td>Rp ${formatIDR(r.qty * r.price)}</td>
        <td>
          <button class="btn btn-sm btn-outline-warning me-1" onclick="editPR(${i})"><i class="bi bi-pencil"></i></button>
          <button class="btn btn-sm btn-outline-danger" onclick="deletePR(${i})"><i class="bi bi-trash"></i></button>
        </td>
      </tr>
    `).join('');
  }

  window.editPR = function(i){
    const arr = read(KEY_PR) || []; const p = arr[i]; if(!p) return;
    document.getElementById('pr_edit_index').value = i;
    document.getElementById('e_pr_item').value = p.item;
    document.getElementById('e_pr_qty').value = p.qty;
    document.getElementById('e_pr_price').value = p.price;
    document.getElementById('e_pr_vendor').value = p.vendor;
    new bootstrap.Modal(document.getElementById('prEditModal')).show();
  };

  window.deletePR = function(i){
    if(!confirm('Hapus item PR ini?')) return;
    const arr = read(KEY_PR) || []; arr.splice(i,1); write(KEY_PR, arr);
    renderPRList(); showToast('Sukses','Item PR dihapus','success');
  };

  // PR edit submit
  document.getElementById('prEditForm').addEventListener('submit', (e) => {
    e.preventDefault();
    const idx = parseInt(document.getElementById('pr_edit_index').value);
    const item = document.getElementById('e_pr_item').value.trim();
    const qty = parseInt(document.getElementById('e_pr_qty').value) || 0;
    const price = parseFloat(document.getElementById('e_pr_price').value) || 0;
    const vendor = document.getElementById('e_pr_vendor').value.trim();
    if(!item){ showToast('Error','Item wajib diisi','error'); return; }
    const arr = read(KEY_PR) || []; arr[idx] = { item, qty, price, vendor }; write(KEY_PR, arr);
    bootstrap.Modal.getInstance(document.getElementById('prEditModal')).hide();
    renderPRList(); showToast('Sukses','PR diperbarui','success');
  });

  /* --------------------------
     Surveys & Validation (dashboard)
     -------------------------- */
  function renderSurveys(){
    const arr = read(KEY_SURVEY) || [];
    const tbody = document.getElementById('surveysTBody');
    if(!tbody) return;
    tbody.innerHTML = arr.map((s,i)=>`
      <tr>
        <td>${i+1}</td>
        <td>${escapeHtml(s.title)}</td>
        <td>${escapeHtml(s.deadline)}</td>
        <td><div class="progress" style="height:8px"><div class="progress-bar" style="width:${s.progress}%"></div></div></td>
        <td><button class="btn btn-sm btn-outline-primary">View</button></td>
      </tr>
    `).join('');
  }

  function renderValidation(){
    const items = [
      'Check Null Account Bank','Check OT Without SPL','Check Without Schedule','Check Total Employee\'s',
      'Check Without Basic Salary','Check Without Organization','Check Without Work Status'
    ];
    const totals = [8,0,0,1150,1,0,189];
    const tbody = document.getElementById('validationFullTBody');
    tbody.innerHTML = items.map((it,i)=>{
      const statusOk = (totals[i] === 0);
      const badge = statusOk ? '<span class="badge bg-info">OK</span>' : '<span class="badge bg-danger">Not OK</span>';
      return `<tr><td>${i+1}</td><td>${escapeHtml(it)}</td><td>${totals[i]}</td><td>${badge}</td><td><button class="btn btn-sm btn-outline-primary" onclick="alert('View detail: ${escapeHtml(it)}')">View</button></td></tr>`;
    }).join('');
  }

  /* --------------------------
     Charts: attendance & performance
     -------------------------- */
  function renderAttendanceChart(){
    const ctx = document.getElementById('attendanceChart').getContext('2d');
    if(attendanceChart) attendanceChart.destroy();
    attendanceChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: ['Sen','Sel','Rab','Kam','Jum'],
        datasets: [{ label:'Kehadiran (%)', data:[95,97,93,98,96], borderColor: 'rgba(13,110,253,0.95)', backgroundColor:'rgba(13,110,253,0.12)', fill:true, tension:0.3 }]
      },
      options: { responsive:true, plugins:{ legend:{ display:false } }, scales:{ y:{ beginAtZero:true, max:100 }, x:{ grid:{ display:false } } } }
    });

    document.getElementById('attendanceRange').addEventListener('change', function(e){
      if(e.target.value === 'month'){
        attendanceChart.data.labels = ['W1','W2','W3','W4'];
        attendanceChart.data.datasets[0].data = [94,95,96,96];
      } else {
        attendanceChart.data.labels = ['Sen','Sel','Rab','Kam','Jum'];
        attendanceChart.data.datasets[0].data = [95,97,93,98,96];
      }
      attendanceChart.update();
    });
  }

  function renderPerformanceList(){
    const top = ['Rina S — 95','Firza A — 92','Bima — 90','Sinta — 89','Anto — 87'];
    document.getElementById('topEmployees').innerHTML = top.map(t=>`<li>${t}</li>`).join('');
  }

  function renderPerformanceChart(){
    const ctx = document.getElementById('performanceChart').getContext('2d');
    new Chart(ctx, {
      type:'bar',
      data:{ labels:['Jan','Feb','Mar','Apr','May','Jun'], datasets:[{ label:'Rata-rata Score', data:[78,81,83,79,85,87], backgroundColor:'rgba(13,110,253,0.75)' }] },
      options:{ responsive:true, plugins:{ legend:{ display:false } }, scales:{ y:{ beginAtZero:true, max:100 } } }
    });
  }

  /* --------------------------
     Export CSV util
     -------------------------- */
  function exportCSV(key, filename){
    const arr = read(key) || [];
    if(!arr.length){ showToast('Info','Tidak ada data untuk diexport','error'); return; }
    const cols = Object.keys(arr[0]);
    const csv = [cols.join(',')].concat(arr.map(r => cols.map(c => `"${String(r[c]).replaceAll('"','""')}"`).join(','))).join('\n');
    const blob = new Blob([csv], { type:'text/csv;charset=utf-8;' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a'); a.href = url; a.download = filename; document.body.appendChild(a); a.click(); a.remove(); URL.revokeObjectURL(url);
    showToast('Sukses','Export CSV berhasil','success');
  }

  /* --------------------------
     Small inits & bindings
     -------------------------- */
  // render/update helpers
  function renderAllLists(){
    renderPersonalList(); renderPRList(); renderSurveys(); renderValidation(); renderPerformanceList();
  }

  // Bind PR total live for edit modal fields too (optional)
  document.getElementById('e_pr_qty')?.addEventListener('input', ()=> {});
  document.getElementById('e_pr_price')?.addEventListener('input', ()=> {});

  // PR initial render and personal initial render
  function renderPRListInitial(){
    renderPRList();
    updatePRTotalDisplay();
  }

  // ensure PR rendering function exists when script executes
  try { renderPRList(); } catch(e) {}

  // Call initial render if already logged in
  if(localStorage.getItem(LOGIN_KEY) === '1'){ initAfterLogin(); }

  // keyboard shortcuts (optional)
  document.addEventListener('keydown', (e) => {
    if(e.key === 'Escape'){ // close modals if any open
      document.querySelectorAll('.modal.show').forEach(m => bootstrap.Modal.getInstance(m)?.hide());
    }
  });

  </script>
</body>
</html>
