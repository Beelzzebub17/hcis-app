<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <title>SmartHCIS — Final</title>
  <meta name="viewport" content="width=device-width,initial-scale=1" />

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <style>
    /* ===== Theme variables ===== */
    :root{
      --brand: #3b82f6;        /* bright blue */
      --brand-2: #0b4df5;      /* deeper blue */
      --sidebar-deep: #07173b; /* very dark blue for sidebar bg */
      --surface: #f4f7ff;
      --muted: #94a3b8;
      --card-radius: 12px;
      --success: #16a34a;
      --danger: #ef4444;
    }

    * { box-sizing: border-box; }
    html,body { height:100%; margin:0; font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial; background:var(--surface); color:#0b1724; -webkit-font-smoothing:antialiased; }

    /* ===== Login page ===== */
    .login-page{
      min-height:100vh;
      display:flex;
      align-items:center;
      justify-content:center;
      background-image:
        linear-gradient(0deg, rgba(3,7,30,0.45), rgba(3,7,30,0.22)),
        url('https://images.unsplash.com/photo-1521790797524-b2497295b8a0?auto=format&fit=crop&w=1920&q=80');
      background-size:cover;
      background-position:center;
      padding:24px;
    }
    .login-card{
      width:100%;
      max-width:480px;
      background:linear-gradient(180deg, rgba(255,255,255,0.96), rgba(245,250,255,0.95));
      border-radius:16px;
      padding:28px;
      box-shadow: 0 20px 50px rgba(4,9,30,0.36);
      border:1px solid rgba(255,255,255,0.6);
      text-align:center;
    }
    .login-logo { display:inline-block; width:92px; height:92px; margin-bottom:8px; }

    /* ===== App layout ===== */
    .app-wrap { display:flex; min-height:100vh; }
    /* Sidebar */
    .sidebar{
      width:300px;
      background: linear-gradient(180deg, var(--sidebar-deep), #0b3366);
      color: #eaf2ff;
      padding:18px 14px;
      position:fixed;
      left:0; top:0; bottom:0;
      overflow:auto;
      box-shadow: 8px 0 30px rgba(3,7,30,0.28);
      -webkit-backdrop-filter: blur(6px);
      backdrop-filter: blur(6px);
    }
    .sidebar .brand{ display:flex; gap:12px; align-items:center; padding-bottom:12px; border-bottom:1px solid rgba(255,255,255,0.04); margin-bottom:12px; }
    .sidebar .brand svg { width:46px; height:46px; }
    .sidebar h1{ margin:0; font-size:16px; font-weight:800; color:#fff; letter-spacing:0.2px; }
    .sidebar .muted { font-size:12px; color:rgba(255,255,255,0.82); margin-top:2px; }

    .nav-list{ list-style:none; padding:0; margin:12px 0 0 0; }
    .nav-item{ margin:6px 6px; }
    .nav-link{
      display:flex;
      align-items:center;
      gap:12px;
      padding:12px;
      border-radius:12px;
      color:rgba(255,255,255,0.92);
      text-decoration:none;
      transition: background .12s ease, transform .08s ease;
    }
    .nav-link i { width:28px; text-align:center; opacity:0.95; }
    .nav-link span { font-weight:600; font-size:14px; }
    .nav-link:hover{ background: linear-gradient(90deg, rgba(255,255,255,0.03), rgba(255,255,255,0.01)); transform: translateY(-1px); color:#fff; }
    .nav-link.active{
      background: linear-gradient(180deg, rgba(255,255,255,0.03), rgba(255,255,255,0.01));
      box-shadow: 0 6px 18px rgba(11,77,245,0.08);
      color:#fff;
    }

    .sidebar-footer{ margin-top:16px; padding-top:10px; font-size:12px; color:rgba(255,255,255,0.82); border-top:1px solid rgba(255,255,255,0.03); }

    /* Main content */
    main.content{ margin-left:340px; padding:28px; flex:1; min-height:100vh; }
    .card-radius{ border-radius:var(--card-radius); }

    /* Page transition: fade + slight slide */
    .page { display:none; opacity:0; transform: translateY(10px); transition: opacity .28s cubic-bezier(.2,.9,.2,1), transform .28s cubic-bezier(.2,.9,.2,1); }
    .page.active{ display:block; opacity:1; transform: translateY(0); }

    /* Toasts */
    .toast-wrap{ position:fixed; right:18px; top:18px; z-index:2200; display:flex; flex-direction:column; gap:10px; }
    .toast-card{ min-width:220px; padding:10px 14px; color:#fff; border-radius:10px; box-shadow:0 10px 24px rgba(4,9,30,0.12); transform: translateY(-8px); opacity:0; transition: transform .18s, opacity .18s; }
    .toast-card.show{ transform:none; opacity:1; }
    .toast-success{ background: linear-gradient(90deg, #16a34a, #34d399); }
    .toast-error{ background: linear-gradient(90deg, #ef4444, #f87171); }
    .toast-info{ background: linear-gradient(90deg, var(--brand), #2b7bff); }

    /* Modal smoother animation */
    .modal.fade .modal-dialog{ transform: translateY(10px); transition: transform .26s cubic-bezier(.2,.8,.2,1), opacity .15s; }
    .modal.fade.show .modal-dialog{ transform: translateY(0); }

    /* small responsive */
    @media (max-width: 980px){
      .sidebar{ width:72px; padding:14px; }
      .sidebar h1, .sidebar .muted { display:none; }
      .nav-link span { display:none; }
      main.content{ margin-left:92px; padding:18px; }
    }

    /* helpers */
    .muted { color:var(--muted); }
    .kpi { padding:14px; border-radius:10px; background:linear-gradient(180deg,#fff,#f6fbff); box-shadow:0 8px 18px rgba(6,14,40,0.04); display:flex; justify-content:space-between; align-items:center; gap:12px; }
    .kpi .title{ font-size:13px; color:#64748b; }
    .kpi .val{ font-size:20px; font-weight:700; color:var(--brand-2); }
    .btn-brand { background: linear-gradient(90deg, var(--brand), var(--brand-2)); color:#fff; border: none; }
    .btn-brand-outline { background: transparent; border:1px solid rgba(255,255,255,0.08); color:#fff; }
    .table-light th { background: #f8fbff; }
    .ghost-card { background: linear-gradient(180deg,#ffffffcc,#f6faff); border-radius:12px; box-shadow:0 10px 30px rgba(7,20,60,0.06); padding:16px; }
  </style>
</head>
<body>

  <div id="loginPage" class="login-page" aria-hidden="false">
    <div class="login-card" role="main" aria-labelledby="loginTitle">
      <div class="login-logo mx-auto" aria-hidden="true">
        <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="SmartHCIS logo">
          <defs>
            <linearGradient id="lg2" x1="0" x2="1" y1="0" y2="1">
              <stop offset="0" stop-color="#79b8ff"/>
              <stop offset="1" stop-color="#0b4df5"/>
            </linearGradient>
            <filter id="glow" x="-50%" y="-50%" width="200%" height="200%">
              <feGaussianBlur stdDeviation="4" result="coloredBlur"/>
              <feMerge><feMergeNode in="coloredBlur"/><feMergeNode in="SourceGraphic"/></feMerge>
            </filter>
          </defs>
          <g filter="url(#glow)">
            <rect x="12" y="14" width="18" height="72" rx="6" fill="url(#lg2)"/>
            <rect x="70" y="14" width="18" height="72" rx="6" fill="url(#lg2)"/>
            <rect x="36" y="40" width="28" height="20" rx="6" fill="#eaf5ff" transform="skewX(-10)"/>
          </g>
        </svg>
      </div>

      <h2 id="loginTitle" class="fw-bold mb-1" style="color:var(--brand-2)">SmartHCIS</h2>
      <div class="muted mb-3">Addon Human Capital — masuk untuk melihat dashboard</div>

      <div class="form-floating mb-3">
        <input id="loginUser" class="form-control" placeholder="username" aria-label="username">
        <label for="loginUser">Username</label>
      </div>
      <div class="form-floating mb-3">
        <input id="loginPass" type="password" class="form-control" placeholder="password" aria-label="password">
        <label for="loginPass">Password</label>
      </div>

      <div class="d-grid gap-2 mb-2">
        <button id="btnLogin" class="btn btn-brand btn-lg">Masuk ke SmartHCIS</button>
      </div>

      <div id="loginError" class="text-danger small mb-2" style="min-height:18px"></div>
      <div class="text-muted small">Demo credentials: <strong>admin / 12345</strong></div>
    </div>
  </div>

  <div id="app" class="app-wrap" style="display:none;" aria-hidden="true">
    <aside class="sidebar" role="navigation" aria-label="Main menu">
      <div class="brand" role="banner">
        <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
          <defs>
            <linearGradient id="lgS" x1="0" x2="1"><stop offset="0" stop-color="#79b8ff"/><stop offset="1" stop-color="#0b4df5"/></linearGradient>
            <filter id="gGlow" x="-60%" y="-60%" width="220%" height="220%"><feGaussianBlur stdDeviation="3" result="b"/><feMerge><feMergeNode in="b"/><feMergeNode in="SourceGraphic"/></feMerge></filter>
          </defs>
          <g filter="url(#gGlow)">
            <rect x="12" y="14" width="18" height="72" rx="5" fill="url(#lgS)"/>
            <rect x="70" y="14" width="18" height="72" rx="5" fill="url(#lgS)"/>
            <rect x="36" y="40" width="28" height="20" rx="5" fill="#eaf5ff" transform="skewX(-10)"/>
          </g>
        </svg>

        <div>
          <h1>SmartHCIS</h1>
          <div class="muted small">Addon Human Capital</div>
        </div>
      </div>

      <ul class="nav-list" role="menu" aria-label="Primary">
        <li class="nav-item"><a class="nav-link active" href="#" data-page="dashboard"><i class="bi bi-speedometer2 fs-5"></i><span>Dashboard</span></a></li>
        <li class="nav-item"><a class="nav-link" href="#" data-page="personal"><i class="bi bi-people-fill fs-5"></i><span>Personal Admin</span></a></li>
        <li class="nav-item"><a class="nav-link" href="#" data-page="payroll"><i class="bi bi-wallet2 fs-5"></i><span>Purchase Requisition</span></a></li>
        <li class="nav-item"><a class="nav-link" href="#" data-page="training"><i class="bi bi-award fs-5"></i><span>Training Dev</span></a></li>
        <li class="nav-item"><a class="nav-link" href="#" data-page="performance"><i class="bi bi-graph-up fs-5"></i><span>Performance</span></a></li>
        <li class="nav-item"><a class="nav-link" href="#" data-page="validation"><i class="bi bi-list-check fs-5"></i><span>Data Validation</span></a></li>
        <!-- Chatbot moved to mini-toggle (no full page nav) -->
        <li class="nav-item"><a class="nav-link" href="#" data-page="adminchat"><i class="bi bi-people fs-5"></i><span>Admin Chat</span></a></li>
        <li class="nav-item"><a class="nav-link" href="#" data-page="setting"><i class="bi bi-gear fs-5"></i><span>System Setting</span></a></li>
        <li class="nav-item"><a class="nav-link" href="#" data-page="profile"><i class="bi bi-person-circle fs-5"></i><span>Profile</span></a></li>
        <li class="nav-item mt-2"><a class="nav-link" id="logoutBtn" href="#" style="color:#fff"><i class="bi bi-box-arrow-right fs-5"></i><span>Logout</span></a></li>
      </ul>

      <div class="sidebar-footer">© 2025 SmartHCIS</div>
    </aside>

    <main class="content" role="main">
      <section id="page-dashboard" class="page active" aria-labelledby="dashTitle">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <div>
            <h2 id="dashTitle" class="mb-0">Dashboard</h2>
            <div class="muted">Ringkasan performa dan aktivitas sistem</div>
          </div>
          <div class="d-flex gap-2">
            <button id="exportAllBtn" class="btn btn-outline-secondary btn-sm"><i class="bi bi-download"></i> Export Demo</button>
          </div>
        </div>

        <div class="row g-3 mb-4">
          <div class="col-md-3"><div class="kpi"><div><div class="title">Total Karyawan</div><div class="val" id="k_total">0</div></div><div class="text-muted text-end"><i class="bi bi-people-fill fs-3" style="color:var(--brand)"></i></div></div></div>
          <div class="col-md-3"><div class="kpi"><div><div class="title">Pelatihan Aktif</div><div class="val" id="k_training">0</div></div><div class="text-muted text-end"><i class="bi bi-award fs-3" style="color:#f59e0b"></i></div></div></div>
          <div class="col-md-3"><div class="kpi"><div><div class="title">Kehadiran Hari Ini</div><div class="val" id="k_attendance">96%</div></div><div class="text-muted text-end"><i class="bi bi-clock-history fs-3" style="color:#10b981"></i></div></div></div>
          <div class="col-md-3"><div class="kpi"><div><div class="title">Proyek Aktif</div><div class="val" id="k_projects">5</div></div><div class="text-muted text-end"><i class="bi bi-kanban fs-3" style="color:#0ea5e9"></i></div></div></div>
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
      <style>
        .chat-container { display:flex; flex-direction:column; min-height:260px; }
        .chat-messages { flex:1; overflow:auto; max-height:340px; padding:12px; background:#f8fbff; border-radius:10px; border:1px solid #e7f0ff; }
        .msg { margin-bottom:10px; display:flex; gap:8px; align-items:flex-end; }
        .msg .bubble { padding:10px 12px; border-radius:12px; max-width:80%; box-shadow:0 6px 14px rgba(6,14,40,0.04); }
        .msg.user { justify-content:flex-end; }
        .msg.user .bubble { background:linear-gradient(90deg,#3b82f6,#0b4df5); color:#fff; border-bottom-right-radius:6px; }
        .msg.bot .bubble { background:#fff; color:#0b1a2b; border-bottom-left-radius:6px; border:1px solid #eef6ff; }
        .chat-input-area .form-control { min-width:0; }
        .chat-attachment { display:block; margin-top:6px; font-size:13px; color:#344055; }
        .attachment-link { display:inline-block; margin-top:6px; background:#eef7ff; padding:6px 8px; border-radius:8px; font-size:13px; text-decoration:none; color:#0b4df5; }
        /* Admin chat list */
        #adminChatsList .list-group-item { cursor:pointer; display:flex; justify-content:space-between; align-items:center; }
        #adminMessages .msg { margin-bottom:8px; }
        .status-badge { font-size:12px; padding:4px 8px; border-radius:999px; }
        /* Mini floating chat */
        .mini-chat-toggle { position:fixed; right:24px; bottom:24px; z-index:1200; }
        .mini-chat-btn { width:56px; height:56px; border-radius:999px; background:#0b4df5; color:#fff; display:flex; align-items:center; justify-content:center; box-shadow:0 8px 24px rgba(11,77,245,0.18); border:none; }
        .mini-chat-badge { position:absolute; right:-6px; top:-6px; background:#ff3b30; color:#fff; font-size:12px; padding:4px 6px; border-radius:999px; box-shadow:0 4px 12px rgba(0,0,0,0.12); }
        .mini-chat-panel { position:fixed; right:24px; bottom:96px; width:360px; max-width:90vw; height:480px; z-index:1200; display:flex; flex-direction:column; box-shadow:0 20px 50px rgba(6,14,40,0.2); border-radius:12px; overflow:hidden; background:#fff; }
        .mini-chat-header { padding:10px 12px; background:linear-gradient(90deg,#0b4df5,#3b82f6); color:#fff; display:flex; align-items:center; justify-content:space-between; }
        .mini-chat-body { padding:10px; flex:1; overflow:auto; background:#f8fbff; }
        .mini-chat-footer { padding:10px; border-top:1px solid #eef6ff; display:flex; gap:8px; align-items:center; }
        .mini-chat-panel.hidden { display:none; }
        .mini-msg .bubble { padding:8px 10px; border-radius:10px; max-width:78%; }
        .mini-msg.user { justify-content:flex-end; }
        .mini-msg.user .bubble { background:linear-gradient(90deg,#3b82f6,#0b4df5); color:#fff; }
        .mini-msg.bot .bubble { background:#fff; color:#0b1a2b; border:1px solid #eef6ff; }
      </style>

      <!-- Full chat page removed: chat is now available exclusively via the bottom-right mini toggle -->

      <section id="page-adminchat" class="page" hidden aria-labelledby="adminChatTitle">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <div>
            <h2 id="adminChatTitle" class="mb-0">Admin — Chat Management (Demo)</h2>
            <div class="muted">Daftar chat per divisi. Assign, balas, upload file, ubah status.</div>
          </div>
          <div>
            <select id="adminFilterDiv" class="form-select form-select-sm w-auto">
              <option value="all">All Divisions</option>
              <option value="Finance">Finance</option>
              <option value="HCIS">HCIS</option>
              <option value="LDD">LDD</option>
            </select>
          </div>
        </div>

        <div class="row g-3">
          <div class="col-md-4">
            <div class="card p-2 card-radius" style="height:520px; overflow:auto">
              <h6 class="mb-2">Chats</h6>
              <ul id="adminChatsList" class="list-group"></ul>
            </div>
          </div>
          <div class="col-md-8">
            <div class="card p-3 card-radius" style="height:520px; display:flex; flex-direction:column">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <div>
                  <h6 id="adminChatTitleSelected">Pilih chat</h6>
                  <div id="adminChatMeta" class="muted small">-</div>
                </div>
                <div class="d-flex gap-2">
                  <button id="adminAssignBtn" class="btn btn-sm btn-outline-primary">Assign to me</button>
                  <select id="adminStatusSel" class="form-select form-select-sm w-auto">
                    <option value="open">Open</option>
                    <option value="pending">Pending</option>
                    <option value="solved">Solved</option>
                  </select>
                </div>
              </div>
              <div id="adminMessages" style="flex:1; overflow:auto; padding:8px; background:#f8fbff; border-radius:8px; border:1px solid #eef6ff"></div>

              <div class="mt-2">
                <div class="d-flex gap-2 mb-2">
                  <input id="adminReplyInput" class="form-control" placeholder="Tulis jawaban...">
                  <input id="adminFile" type="file" class="form-control" style="max-width:240px" />
                  <button id="adminSendBtn" class="btn btn-brand">Kirim</button>
                  <button id="adminOptionsBtn" class="btn btn-outline-secondary" style="margin-left:8px">Options</button>
                </div>
                <div class="small muted">Use <strong>Options</strong> to manage templates, quick replies, auto-reply and broadcast.</div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section id="page-personal" class="page" hidden aria-labelledby="personalTitle">
        <h2 id="personalTitle" class="mb-3 fw-bold">Personal Administration</h2>
        <div class="muted mb-4">Ringkasan data pribadi dan administrasi karyawan</div>

        <div class="card p-4 card-radius shadow-sm border-0">
          <div class="d-flex align-items-center gap-4 mb-4 border-bottom pb-4">
            <img class="rounded-circle shadow"
              src="https://randomuser.me/api/portraits/lego/1.jpg"
              alt="Profile Picture" style="width: 90px; height: 90px; border: 4px solid var(--brand);">
            <div>
              <h4 class="fw-bold mb-0 text-blue-800">Joko Santoso</h4>
              <div class="text-muted small">Senior HR Specialist</div>
              <div class="small text-primary fw-semibold">ID Karyawan: SM-80801</div>
            </div>
          </div>

          <h5 class="fw-bold text-primary mb-3 pb-2 border-bottom">My Profile Details</h5>
          <div class="row g-4">
            
            <div class="col-md-6">
              <p class="mb-1 text-muted small fw-semibold">Email Address:</p>
              <h6 class="fw-semibold text-gray-800">joko.s@smarthcis.com</h6>
            </div>
            <div class="col-md-6">
              <p class="mb-1 text-muted small fw-semibold">Department:</p>
              <h6 class="fw-semibold text-gray-800">Human Capital</h6>
            </div>
            
            <div class="col-md-6">
              <p class="mb-1 text-muted small fw-semibold">Phone Number:</p>
              <h6 class="fw-semibold text-gray-800">+62 811 XXXX 555</h6>
            </div>
            <div class="col-md-6">
              <p class="mb-1 text-muted small fw-semibold">Direct Supervisor:</p>
              <h6 class="fw-semibold text-gray-800">Budi Hartono</h6>
            </div>

            <div class="col-md-6">
              <p class="mb-1 text-muted small fw-semibold">Annual Leave Balance:</p>
              <h6 class="fw-bolder text-success fs-5">12 Days</h6>
            </div>
            <div class="col-md-6">
              <p class="mb-1 text-muted small fw-semibold">Join Date:</p>
              <h6 class="fw-semibold text-gray-800">2020-05-15</h6>
            </div>
            <div class="col-12">
              <p class="mb-1 text-muted small fw-semibold">Home Address:</p>
              <h6 class="fw-semibold text-gray-800">Jl. Merdeka No. 10, Jakarta Pusat</h6>
            </div>
          </div>

          <div class="mt-5 text-end">
            <button class="btn btn-brand px-4 shadow-sm" type="button" onclick="showToast('Info','Fungsi edit data pribadi belum diimplementasikan.','info')">
              <i class="bi bi-pencil-square me-1"></i> Update Personal Data
            </button>
          </div>
        </div>
      </section>

      <section id="page-profile" class="page" hidden>
  <div class="profile-container">
    <div class="profile-banner"></div>
    <div class="profile-card shadow-sm">
      <div class="text-center position-relative">
        <img id="profileAvatar" src="https://randomuser.me/api/portraits/lego/1.jpg"
             alt="User Avatar" class="profile-avatar">
        <input type="file" id="avatarInput" accept="image/*" hidden>
        <button id="btnChangeAvatar" class="btn btn-sm btn-light rounded-pill shadow-sm position-absolute"
          style="top:100%; left:50%; transform:translate(-50%, 10px);">
          <i class="bi bi-camera"></i>
        </button>
      </div>

      <div class="mt-5 text-center">
        <h3 class="fw-bold text-primary">My Profile</h3>
      </div>

      <form id="profileForm" class="mt-3 px-4">
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Full Name</label>
            <input type="text" id="profileName" class="form-control" value="Admin SmartHCIS" readonly>
          </div>
          <div class="col-md-6">
            <label class="form-label">Email Address</label>
            <input type="email" id="profileEmail" class="form-control" value="admin@smarthcis.com" readonly>
          </div>
          <div class="col-md-6">
            <label class="form-label">Role</label>
            <input type="text" id="profileRole" class="form-control" value="System Administrator" readonly>
          </div>
          <div class="col-md-6">
            <label class="form-label">Joined</label>
            <input type="text" id="profileJoin" class="form-control" value="12 March 2023" readonly>
          </div>
        </div>

        <div class="mt-4 text-center">
          <button type="button" id="editBtn" class="btn btn-primary px-4 me-2">
            <i class="bi bi-pencil"></i> Edit Profile
          </button>
          <button type="submit" id="saveBtn" class="btn btn-success px-4 me-2" hidden>
            <i class="bi bi-save"></i> Save
          </button>
          <button type="button" id="cancelBtn" class="btn btn-secondary px-4 me-2" hidden>
            <i class="bi bi-x-circle"></i> Cancel
          </button>
          <button type="button" id="logoutBtn" class="btn btn-outline-danger px-4">
            <i class="bi bi-box-arrow-right"></i> Logout
          </button>
        </div>
      </form>
    </div>
  </div>
</section>

<style>
  #page-profile {
    animation: fadeIn 0.4s ease;
  }

  .profile-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-top: 1rem;
  }

  .profile-banner {
    width: 100%;
    height: 120px;
    background: linear-gradient(90deg, #002b5c, #0056b3);
    border-radius: 0 0 40px 40px;
  }

  .profile-card {
    background: #fff;
    border-radius: 20px;
    padding: 2rem 1rem;
    width: 90%;
    max-width: 700px;
    margin-top: -60px;
  }

  .profile-avatar {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    border: 4px solid white;
    object-fit: cover;
    position: absolute;
    top: -60px;
    left: 50%;
    transform: translateX(-50%);
  }

  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
  }
</style>

<script>
  const editBtn = document.getElementById('editBtn');
  const saveBtn = document.getElementById('saveBtn');
  const cancelBtn = document.getElementById('cancelBtn');
  const profileForm = document.getElementById('profileForm');
  const avatarInput = document.getElementById('avatarInput');
  const profileAvatar = document.getElementById('profileAvatar');
  const btnChangeAvatar = document.getElementById('btnChangeAvatar');

  // Load data dari localStorage jika ada
  window.addEventListener('load', () => {
    const saved = JSON.parse(localStorage.getItem('userProfile'));
    if (saved) {
      document.getElementById('profileName').value = saved.name;
      document.getElementById('profileEmail').value = saved.email;
      document.getElementById('profileRole').value = saved.role;
      document.getElementById('profileJoin').value = saved.joined;
      profileAvatar.src = saved.avatar;
    }
  });

  // Mode Edit
  editBtn.addEventListener('click', () => {
    [...profileForm.querySelectorAll('input')].forEach(input => input.removeAttribute('readonly'));
    editBtn.hidden = true;
    saveBtn.hidden = false;
    cancelBtn.hidden = false;
  });

  // Simpan Perubahan
  profileForm.addEventListener('submit', e => {
    e.preventDefault();
    const data = {
      name: document.getElementById('profileName').value,
      email: document.getElementById('profileEmail').value,
      role: document.getElementById('profileRole').value,
      joined: document.getElementById('profileJoin').value,
      avatar: profileAvatar.src
    };
    localStorage.setItem('userProfile', JSON.stringify(data));
    alert('✅ Profil berhasil disimpan!');
    cancelEditMode();
  });

  // Batal edit
  cancelBtn.addEventListener('click', cancelEditMode);
  function cancelEditMode() {
    [...profileForm.querySelectorAll('input')].forEach(input => input.setAttribute('readonly', true));
    editBtn.hidden = false;
    saveBtn.hidden = true;
    cancelBtn.hidden = true;
  }

  // Ganti avatar
  btnChangeAvatar.addEventListener('click', () => avatarInput.click());
  avatarInput.addEventListener('change', (e) => {
    const file = e.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function (ev) {
        profileAvatar.src = ev.target.result;
      };
      reader.readAsDataURL(file);
    }
  });
</script>


      <section id="page-payroll" class="page" hidden>
        <div class="d-flex justify-content-between align-items-center mb-3">
          <div>
            <h2 class="mb-0">Purchase Requisition</h2>
            <div class="muted">Masukkan harga item untuk PR</div>
          </div>
          <div>
            <button id="exportPR" class="btn btn-brand-outline btn-sm me-2"><i class="bi bi-download"></i> Export CSV</button>
            <button id="btnNewPR" class="btn btn-brand btn-sm"><i class="bi bi-plus-lg"></i> Tambah Item</button>
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

      <section id="page-training" class="page" hidden>
  <h2 class="text-center mb-4 text-primary fw-bold">Training Development</h2>
  <p class="text-center text-muted mb-5">Pelatihan dan pengembangan karyawan untuk meningkatkan kompetensi.</p>

  <div class="training-grid">
    <div class="training-card">
      <div class="training-icon">
        <i class="bi bi-award"></i>
      </div>
      <h5>Leadership Training</h5>
      <p>Durasi: 3 hari</p>
      <button class="btn-training" data-title="Leadership Training" data-desc="Pelatihan ini fokus pada pengembangan kemampuan memimpin tim dan komunikasi efektif dalam organisasi.">Lihat Detail</button>
    </div>

    <div class="training-card">
      <div class="training-icon bg-blue-light">
        <i class="bi bi-bar-chart-line"></i>
      </div>
      <h5>Data Analyst Workshop</h5>
      <p>Durasi: 2 hari</p>
      <button class="btn-training" data-title="Data Analyst Workshop" data-desc="Workshop untuk memperkuat kemampuan analisis data menggunakan tools modern seperti Power BI dan Excel Advanced.">Lihat Detail</button>
    </div>

    <div class="training-card">
      <div class="training-icon bg-green-light">
        <i class="bi bi-person-plus"></i>
      </div>
      <h5>Onboarding New Joiner</h5>
      <p>Durasi: 1 hari</p>
      <button class="btn-training" data-title="Onboarding New Joiner" data-desc="Program pengenalan budaya kerja dan sistem SmartHCIS bagi karyawan baru agar cepat beradaptasi.">Lihat Detail</button>
    </div>
  </div>

  <div id="trainingModal" class="training-modal" hidden>
    <div class="modal-content">
      <span class="close-modal">&times;</span>
      <h4 id="modalTitle"></h4>
      <p id="modalDesc"></p>
    </div>
  </div>
</section>

<style>
  /* Grid Layout */
  .training-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 25px;
    padding: 0 20px;
  }

  .training-card {
    background: linear-gradient(145deg, #ffffff, #f1f6ff);
    border: 1px solid #e1e8f0;
    border-radius: 18px;
    padding: 25px 20px;
    text-align: center;
    transition: all 0.4s ease;
    box-shadow: 0 6px 12px rgba(0, 60, 130, 0.08);
  }

  .training-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 10px 25px rgba(0, 60, 130, 0.18);
    background: linear-gradient(145deg, #f5f9ff, #ffffff);
  }

  .training-icon {
    width: 70px;
    height: 70px;
    background: linear-gradient(135deg, #003d99, #007bff);
    color: #fff;
    font-size: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    margin: 0 auto 15px;
  }

  .bg-blue-light {
    background: linear-gradient(135deg, #007bff, #1e90ff);
  }

  .bg-green-light {
    background: linear-gradient(135deg, #00b894, #00cec9);
  }

  .training-card h5 {
    color: #003366;
    font-weight: 600;
    margin-bottom: 5px;
  }

  .training-card p {
    color: #6c757d;
    margin-bottom: 15px;
  }

  .btn-training {
    background: linear-gradient(90deg, #0056b3, #007bff);
    border: none;
    color: #fff;
    border-radius: 8px;
    padding: 8px 18px;
    cursor: pointer;
    font-weight: 500;
    transition: all 0.3s ease;
  }

  .btn-training:hover {
    background: linear-gradient(90deg, #007bff, #00a2ff);
    transform: translateY(-2px);
  }

  /* Modal Styling */
  .training-modal {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.45);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1050;
    animation: fadeIn 0.4s ease;
  }

  .modal-content {
    background: #fff;
    padding: 25px 30px;
    border-radius: 14px;
    max-width: 480px;
    text-align: center;
    box-shadow: 0 8px 30px rgba(0, 40, 100, 0.2);
    animation: slideUp 0.5s ease;
  }

  .close-modal {
    position: absolute;
    top: 15px;
    right: 22px;
    font-size: 22px;
    color: #555;
    cursor: pointer;
  }

  .modal-content h4 {
    color: #003366;
    margin-bottom: 10px;
  }

  .modal-content p {
    color: #444;
    line-height: 1.6;
  }

  @keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
  }

  @keyframes slideUp {
    from { transform: translateY(40px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
  }
</style>

<script>
  // Training Modal Logic
  const modal = document.getElementById("trainingModal");
  const closeModal = modal.querySelector(".close-modal");
  const modalTitle = document.getElementById("modalTitle");
  const modalDesc = document.getElementById("modalDesc");

  document.querySelectorAll(".btn-training").forEach(btn => {
    btn.addEventListener("click", () => {
      modalTitle.textContent = btn.dataset.title;
      modalDesc.textContent = btn.dataset.desc;
      modal.hidden = false;
    });
  });

  closeModal.addEventListener("click", () => modal.hidden = true);
  modal.addEventListener("click", e => {
    if (e.target === modal) modal.hidden = true;
  });
</script>


      <section id="page-performance" class="page" hidden>
        <h2 class="mb-3">Performance Management</h2>
        <div class="card p-3 card-radius">
          <div class="row">
            <div class="col-lg-6"><h6>Skor Kinerja Bulanan</h6><canvas id="performanceChart" height="180"></canvas></div>
            <div class="col-lg-6"><h6>Top 5 Employee</h6><ol id="topEmployees" class="mt-3"></ol></div>
          </div>
        </div>
      </section>

      <section id="page-validation" class="page" hidden>
        <h2 class="mb-3">Payroll Data Validation</h2>
        <div class="card p-3 card-radius">
          <table class="table table-sm text-center">
            <thead class="table-light"><tr><th>NO</th><th>ITEM CHECK LIST</th><th>TOTAL</th><th>STATUS</th><th>ACTION</th></tr></thead>
            <tbody id="validationFullTBody"></tbody>
          </table>
        </div>
      </section>

      <section id="page-setting" class="page" hidden>
  <div class="page-header mb-4 d-flex align-items-center justify-content-between">
    <div>
      <h2 class="fw-bold mb-1 text-primary">System Setting</h2>
      <p class="text-muted small mb-0">Atur konfigurasi sistem SmartHCIS Anda</p>
    </div>
    <div class="rounded-circle bg-light shadow-sm p-3">
      <i class="fas fa-cog fa-lg text-primary"></i>
    </div>
  </div>

  <div class="card p-4 card-radius shadow-sm border-0" style="background: #ffffff;">
    <form id="settingForm" class="row g-4">
      <div class="col-md-6">
        <label class="form-label fw-semibold">Nama Sistem</label>
        <div class="input-group">
          <span class="input-group-text bg-light"><i class="fas fa-desktop text-primary"></i></span>
          <input id="s_name" class="form-control" placeholder="Contoh: SmartHCIS Production">
        </div>
      </div>

      <div class="col-md-6">
        <label class="form-label fw-semibold">Email Admin</label>
        <div class="input-group">
          <span class="input-group-text bg-light"><i class="fas fa-envelope text-primary"></i></span>
          <input id="s_email" type="email" class="form-control" placeholder="admin@smarthcis.com">
        </div>
      </div>

      <div class="col-md-4">
        <label class="form-label fw-semibold">Mode Sistem</label>
        <div class="input-group">
          <span class="input-group-text bg-light"><i class="fas fa-layer-group text-primary"></i></span>
          <select id="s_mode" class="form-select">
            <option>Production</option>
            <option>Testing</option>
            <option>Development</option>
          </select>
        </div>
      </div>

      <div class="col-12 text-end mt-4">
        <button class="btn btn-primary px-4 shadow-sm" type="submit">
          <i class="fas fa-save me-2"></i> Simpan Setting
        </button>
      </div>
    </form>
  </div>
</section>

<style>
  #page-setting .page-header h2 {
    font-size: 1.6rem;
  }

  #page-setting .card {
    transition: all 0.3s ease;
  }

  #page-setting .card:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 20px rgba(0, 100, 255, 0.08);
  }

  #page-setting .input-group-text {
    border-right: 0;
  }

  #page-setting input:focus,
  #page-setting select:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.15);
  }

  .btn-primary {
    background: linear-gradient(135deg, #0066cc, #0099ff);
    border: none;
  }

  .btn-primary:hover {
    background: linear-gradient(135deg, #005bb5, #008ae6);
  }
</style>


      <section id="page-profile" class="page" hidden>
  <div class="profile-header">
    <div class="profile-banner"></div>
    <div class="profile-avatar">
      <img src="https://i.ibb.co/0n3qZBt/user-blue.png" alt="User Avatar">
    </div>
  </div>

  <div class="profile-card card p-4 shadow-sm fade-in">
    <h2 class="fw-bold text-center mb-3 text-primary">My Profile</h2>
    <div class="row g-3 mb-3">
      <div class="col-md-6">
        <p class="mb-1 text-muted small">Full Name</p>
        <h5 id="profileName" class="fw-semibold">Admin SmartHCIS</h5>
      </div>
      <div class="col-md-6">
        <p class="mb-1 text-muted small">Email Address</p>
        <h5 id="profileEmail" class="fw-semibold">admin@smarthcis.com</h5>
      </div>
      <div class="col-md-6">
        <p class="mb-1 text-muted small">Role</p>
        <h5 class="fw-semibold text-success">System Administrator</h5>
      </div>
      <div class="col-md-6">
        <p class="mb-1 text-muted small">Joined</p>
        <h5 class="fw-semibold">12 March 2023</h5>
      </div>
    </div>

    <div class="text-center">
      <button class="btn btn-primary me-2 px-4"><i class="bi bi-pencil-square"></i> Edit Profile</button>
      <button class="btn btn-outline-danger px-4"><i class="bi bi-box-arrow-right"></i> Logout</button>
    </div>
  </div>
</section>

<style>
/* ===== PROFILE SECTION ===== */
.profile-header {
  position: relative;
  text-align: center;
  margin-bottom: 80px;
}
.profile-banner {
  background: linear-gradient(135deg, #003366, #007bff);
  height: 160px;
  border-radius: 0 0 30px 30px;
  box-shadow: 0 3px 6px rgba(0,0,0,0.2);
}
.profile-avatar {
  position: absolute;
  bottom: -50px;
  left: 50%;
  transform: translateX(-50%);
  border-radius: 50%;
  padding: 5px;
  background: white;
  box-shadow: 0 3px 10px rgba(0,0,0,0.2);
}
.profile-avatar img {
  width: 100px;
  height: 100px;
  border-radius: 50%;
}
.profile-card {
  max-width: 800px;
  margin: 0 auto;
  background: #fff;
  border-radius: 20px;
  border: none;
}
.fade-in {
  animation: fadeIn 0.7s ease;
}
@keyframes fadeIn {
  from {opacity: 0; transform: translateY(10px);}
  to {opacity: 1; transform: translateY(0);}
}
.btn-primary {
  background-color: #007bff;
  border: none;
  border-radius: 10px;
}
.btn-primary:hover {
  background-color: #0056b3;
}
.btn-outline-danger {
  border-radius: 10px;
  transition: all 0.3s;
}
.btn-outline-danger:hover {
  background: #dc3545;
  color: #fff;
}
</style>

  <div class="toast-wrap" id="toastWrap" aria-live="polite" aria-atomic="true"></div>

  <div class="modal fade" id="personModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <form id="personForm" class="modal-content">
        <div class="modal-header"><h5 id="personModalTitle" class="modal-title">Tambah Karyawan</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
        <div class="modal-body">
          <input type="hidden" id="person_index">
          <div class="mb-3"><label class="form-label">NIK</label><input id="person_nik" class="form-control" required></div>
          <div class="mb-3"><label class="form-label">Nama</label><input id="person_name" class="form-control" required></div>
          <div class="mb-3"><label class="form-label">Divisi</label><input id="person_div" class="form-control"></div>
          <div class="mb-3"><label class="form-label">Jabatan</label><input id="person_pos" class="form-control"></div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-brand">Simpan</button></div>
      </form>
    </div>
  </div>

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
        <div class="modal-footer"><button class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button></div>
      </div>
    </div>
  </div>

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
        <div class="modal-footer"><button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-brand">Update</button></div>
      </form>
    </div>
  </div>
  <!-- Mini floating chat toggle (bottom-right) -->
  <div class="mini-chat-toggle" aria-hidden="false">
    <div style="position:relative">
      <button id="miniChatBtn" class="mini-chat-btn" title="Chatbot">
        <i class="bi bi-chat-dots" style="font-size:20px"></i>
      </button>
      <div id="miniChatBadge" class="mini-chat-badge" style="display:none">0</div>
    </div>
  </div>

  <div id="miniChatPanel" class="mini-chat-panel hidden" aria-hidden="true">
    <div class="mini-chat-header">
      <div style="font-weight:700">Chatbot</div>
      <div>
        <button id="miniChatClose" class="btn btn-sm btn-light">Tutup</button>
      </div>
    </div>
    <div class="mini-chat-body">
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px">
        <select id="miniChatDivision" class="form-select form-select-sm" style="width:100%">
          <option value="Finance">Finance</option>
          <option value="HCIS">HCIS</option>
          <option value="LDD">LDD</option>
        </select>
      </div>
      <div id="miniChatMessages" class="mini-chat-body" style="padding:4px; background:transparent"></div>
    </div>
    <div class="mini-chat-footer">
      <select id="miniChatType" class="form-select form-select-sm" style="max-width:120px;margin-right:6px">
        <option value="general">General</option>
        <option value="keluhan">Keluhan</option>
      </select>
      <input id="miniChatInput" class="form-control form-control-sm" placeholder="Tulis pesan..." aria-label="mini chat input">
      <input id="miniChatFile" type="file" class="form-control form-control-sm" style="max-width:140px; margin-left:6px" aria-label="Attach file" />
      <button id="miniChatSendBtn" class="btn btn-sm btn-brand">Kirim</button>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.socket.io/4.6.1/socket.io.min.js"></script>

  <script>
  /* ===========================
     Helpers: toast, format, escape
     =========================== */
  const toastWrap = document.getElementById('toastWrap');
  function showToast(title, msg, type='info', ms=2600){
    const el = document.createElement('div');
    el.className = 'toast-card ' + (type==='success' ? 'toast-success' : (type==='error' ? 'toast-error' : 'toast-info'));
    el.innerHTML = `<div style="font-weight:700;margin-bottom:6px">${title}</div><div style="font-size:13px">${msg}</div>`;
    toastWrap.appendChild(el);
    requestAnimationFrame(()=> el.classList.add('show'));
    setTimeout(()=> { el.classList.remove('show'); setTimeout(()=> el.remove(), 300); }, ms);
  }
  function formatIDR(n){ return new Intl.NumberFormat('id-ID').format(n); }
  function escapeHtml(s=''){ return String(s).replaceAll('&','&amp;').replaceAll('<','&lt;').replaceAll('>','&gt;'); }

  // Socket.IO client (optional realtime)
  const SOCKET_URL = 'http://localhost:3001';
  let socket = null; let socketAvailable = false;
  try{
    if(typeof io !== 'undefined'){
      socket = io(SOCKET_URL, { transports:['websocket','polling'] });
      socket.on('connect', ()=>{ socketAvailable = true; showToast('Realtime','Connected to socket server','success',1200); });
      socket.on('disconnect', ()=>{ socketAvailable = false; showToast('Realtime','Socket disconnected','error',1200); });
      socket.on('new_message', (payload)=>{ handleSocketMessage(payload); });
    }
  }catch(e){ console.warn('Socket init failed', e.message); }

  function handleSocketMessage(payload){
    if(!payload) return;
    // expected payload: { division, chatId, sender, text, attachments }
    const div = payload.division || (payload.chatId ? null : 'Finance');
    const raw = read(KEY_CHAT) || {};
    const data = (function normalize(raw){ const out={}; Object.keys(raw||{}).forEach(k=>{ if(Array.isArray(raw[k])) out[k]={messages:raw[k],meta:{status:'open',assigned:'',rating:null,unread:0}}; else out[k]=raw[k]; }); ['Finance','HCIS','LDD'].forEach(d=>{ if(!out[d]) out[d]={messages:[],meta:{status:'open',assigned:'',rating:null,unread:0}} }); return out; })(raw);
    // If payload has chatId, try to map; here we keep per-division lists
    const targetDiv = payload.division || (div || 'Finance');
    data[targetDiv].messages.push({ from: payload.sender || 'bot', text: payload.text || '', ts: Date.now(), attachments: payload.attachments || [] });
    // if not viewing this division, increment unread
    const viewing = document.querySelector('.nav-link.active')?.dataset?.page === 'chat' && document.getElementById('chatDivision')?.value === targetDiv;
    if(!viewing) data[targetDiv].meta.unread = (data[targetDiv].meta.unread||0) + 1;
    write(KEY_CHAT, data);
    updateMiniBadge();
    // render appropriately
    if(document.querySelector('.nav-link.active')?.dataset?.page === 'chat'){
      const cur = document.getElementById('chatDivision')?.value;
      if(cur === targetDiv) renderChat();
    }
    if(document.querySelector('.nav-link.active')?.dataset?.page === 'adminchat') renderAdminList();
  }

  /* ===========================
     Authentication (demo)
     =========================== */
  const LOGIN_KEY = 'smarthcis_demo_logged';
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
      }, 300);
    } else {
      err.textContent = 'Username atau password salah.';
      showToast('Gagal','Kredensial salah.','error');
    }
  });

  // Enter to login convenience
  ['loginUser','loginPass'].forEach(id => {
    document.getElementById(id).addEventListener('keydown', (e) => { if(e.key === 'Enter') document.getElementById('btnLogin').click(); });
  });

  // Auto-login if flag present
  window.addEventListener('load', () => {
    if(localStorage.getItem(LOGIN_KEY) === '1'){
      loginPage.style.display = 'none';
      app.style.display = 'flex';
      app.setAttribute('aria-hidden','false');
      initAfterLogin();
    }
  });

  /* ===========================
     Navigation (fade + slide)
     =========================== */
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
    // hide all
    document.querySelectorAll('main .page').forEach(p => { p.classList.remove('active'); p.hidden = true; });
    const target = document.getElementById('page-' + id);
    if(!target) return;
    target.hidden = false;
    // allow reflow then show with class -> CSS handles fade/slide
    requestAnimationFrame(()=> target.classList.add('active'));
    // update charts lazily
    if(id === 'performance') renderPerformanceChart();
    if(id === 'chat') renderChat();
    if(id === 'adminchat') renderAdminList();
  }

  // Logout
  document.getElementById('logoutBtn').addEventListener('click', (e) => {
    e.preventDefault();
    localStorage.removeItem(LOGIN_KEY);
    showToast('Logout','Anda telah logout','info');
    setTimeout(()=> location.reload(), 700);
  });

  /* ===========================
     Storage keys & seed data
     =========================== */
  function read(key){ const raw = localStorage.getItem(key); return raw ? JSON.parse(raw) : null; }
  function write(key, val){ localStorage.setItem(key, JSON.stringify(val)); }

  const KEY_PERSON = 'smarthcis_personal';
  const KEY_PR = 'smarthcis_pr';
  const KEY_SURVEY = 'smarthcis_survey';
  const KEY_SETTING = 'smarthcis_setting';
  const KEY_CHAT = 'smarthcis_chat';

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
    write(KEY_SETTING, { name:'SmartHCIS', email:'admin@smarthcis.com', mode:'Production' });
  }
  if(!read(KEY_CHAT)){
    write(KEY_CHAT, { Finance: [], HCIS: [], LDD: [] });
  }

  /* ===========================
     After login initialisation
     =========================== */
  let attendanceChart = null;
  function initAfterLogin(){
    // show default page
    showPage('dashboard');

    // update KPIs
    document.getElementById('k_total').textContent = (read(KEY_PERSON) || []).length;
    document.getElementById('k_training').textContent = (read(KEY_SURVEY) || []).length;

    // render lists & charts
    renderAttendanceChart();
    renderPersonalList();
    renderPRList();
    renderSurveys();
    renderValidation();
    renderPerformanceList();

    // attach listeners for app actions
    attachAppListeners();

    // load settings into form
    const st = read(KEY_SETTING) || {};
    document.getElementById('s_name').value = st.name || '';
    document.getElementById('s_email').value = st.email || '';
    document.getElementById('s_mode').value = st.mode || 'Production';
  }

  function attachAppListeners(){
    // Personal add
    document.getElementById('btnAddPerson')?.addEventListener('click', () => {
      document.getElementById('personForm').reset();
      document.getElementById('person_index').value = '';
      document.getElementById('personModalTitle').textContent = 'Tambah Karyawan';
      new bootstrap.Modal(document.getElementById('personModal')).show();
    });

    // export personal CSV
    document.getElementById('exportPersonal')?.addEventListener('click', () => exportCSV(KEY_PERSON, 'personal.csv'));

    // person form submit (add/edit)
    document.getElementById('personForm')?.addEventListener('submit', (e) => {
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

    // PR total live update
    ['pr_qty','pr_price'].forEach(id => { document.getElementById(id)?.addEventListener('input', updatePRTotalDisplay); });

    // PR add
    document.getElementById('prForm')?.addEventListener('submit', (e) => {
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

    // export PR
    document.getElementById('exportPR')?.addEventListener('click', () => exportCSV(KEY_PR, 'pr_list.csv'));

    // create survey (dummy)
    document.getElementById('createSurvey')?.addEventListener('click', () => {
      const arr = read(KEY_SURVEY) || [];
      arr.push({ title:'Survei Baru', deadline:'- - -', progress:0 });
      write(KEY_SURVEY, arr); renderSurveys(); showToast('Sukses','Survei dibuat (dummy)','success');
    });

    // settings save
    document.getElementById('settingForm')?.addEventListener('submit', (e) => {
      e.preventDefault();
      const d = { name: document.getElementById('s_name').value.trim(), email: document.getElementById('s_email').value.trim(), mode: document.getElementById('s_mode').value };
      write(KEY_SETTING, d); showToast('Sukses','Setting disimpan','success');
    });

    // export demo top-right
    document.getElementById('exportAllBtn')?.addEventListener('click', ()=> {
      exportCSV(KEY_PERSON,'personal.csv');
      exportCSV(KEY_PR,'pr_list.csv');
      showToast('Selesai','Export demo: personal + PR','success');
    });

    // quick new PR focus
    document.getElementById('btnNewPR')?.addEventListener('click', ()=> {
      showPage('payroll');
      document.getElementById('pr_item').focus();
    });

    // Chat listeners
    document.getElementById('chatDivision')?.addEventListener('change', renderChat);
    document.getElementById('chatSendBtn')?.addEventListener('click', sendChat);
    document.getElementById('chatInput')?.addEventListener('keydown', (e) => { if(e.key === 'Enter') sendChat(); });
    document.getElementById('chatClearBtn')?.addEventListener('click', () => {
      if(!confirm('Hapus percakapan untuk divisi ini?')) return;
      const div = document.getElementById('chatDivision').value;
      const raw = read(KEY_CHAT) || {};
      // normalize existing shape then clear messages for selected division
      if(Array.isArray(raw[div])) raw[div] = [];
      else if(raw[div] && raw[div].messages) raw[div].messages = [];
      else raw[div] = [];
      write(KEY_CHAT, raw);
      renderChat();
      showToast('Sukses','Percakapan dibersihkan','success');
    });
  }

  /* ===========================
     Personal CRUD functions
     =========================== */
  function renderPersonalList(){
    const arr = read(KEY_PERSON) || [];
    const tbody = document.getElementById('personalTBody');
    if(!tbody) return;
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
    document.getElementById('k_total').textContent = arr.length;
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
  };

  /* ===========================
     PR functions
     =========================== */
  function updatePRTotalDisplay(){
    const q = +document.getElementById('pr_qty').value || 0;
    const p = +document.getElementById('pr_price').value || 0;
    document.getElementById('pr_total').textContent = formatIDR(q * p);
  }

  function renderPRList(){
    const arr = read(KEY_PR) || [];
    const tbody = document.getElementById('prTBody');
    if(!tbody) return;
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

  document.getElementById('prEditForm')?.addEventListener('submit', (e) => {
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

  /* ===========================
     Surveys & validation rendering
     =========================== */
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
    if(!tbody) return;
    tbody.innerHTML = items.map((it,i)=>{
      const ok = (totals[i] === 0);
      const badge = ok ? '<span class="badge bg-info">OK</span>' : '<span class="badge bg-danger">Not OK</span>';
      return `<tr><td>${i+1}</td><td>${escapeHtml(it)}</td><td>${totals[i]}</td><td>${badge}</td><td><button class="btn btn-sm btn-outline-primary" onclick="alert('View detail: ${escapeHtml(it)}')">View</button></td></tr>`;
    }).join('');
  }

  /* ===========================
     Charts: attendance & performance
     =========================== */
  function renderAttendanceChart(){
    const ctx = document.getElementById('attendanceChart')?.getContext('2d');
    if(!ctx) return;
    if(attendanceChart) attendanceChart.destroy();
    attendanceChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: ['Sen','Sel','Rab','Kam','Jum'],
        datasets: [{ label:'Kehadiran (%)', data:[95,97,93,98,96], borderColor: 'rgba(11,77,245,0.95)', backgroundColor:'rgba(11,77,245,0.12)', fill:true, tension:0.3 }]
      },
      options: { responsive:true, plugins:{ legend:{ display:false } }, scales:{ y:{ beginAtZero:true, max:100 }, x:{ grid:{ display:false } } } }
    });

    document.getElementById('attendanceRange')?.addEventListener('change', function(e){
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
    const el = document.getElementById('topEmployees'); if(el) el.innerHTML = top.map(t=>`<li>${t}</li>`).join('');
  }

  function renderPerformanceChart(){
    const c = document.getElementById('performanceChart'); if(!c) return;
    const ctx = c.getContext('2d');
    new Chart(ctx, {
      type:'bar',
      data:{ labels:['Jan','Feb','Mar','Apr','May','Jun'], datasets:[{ label:'Rata-rata Score', data:[78,81,83,79,85,87], backgroundColor:'rgba(11,77,245,0.82)' }] },
      options:{ responsive:true, plugins:{ legend:{ display:false } }, scales:{ y:{ beginAtZero:true, max:100 } } }
    });
  }

  /* ===========================
     CSV Export utility
     =========================== */
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

  /* ===========================
     Chatbot: render, send, auto-reply
     =========================== */
  // normalize chat storage into object: { Division: { messages:[], meta:{ status, assigned, rating, unread } } }
  function normalizeChat(raw){
    const out = {};
    (raw && typeof raw === 'object') || (raw = {});
    Object.keys(raw).forEach(k => {
      if(Array.isArray(raw[k])) out[k] = { messages: raw[k], meta: { status:'open', assigned:'', rating:null, unread:0 } };
      else if(raw[k] && Array.isArray(raw[k].messages)) out[k] = raw[k];
      else out[k] = { messages: [], meta: { status:'open', assigned:'', rating:null, unread:0 } };
    });
    // ensure default divisions exist
    ['Finance','HCIS','LDD'].forEach(d => { if(!out[d]) out[d] = { messages:[], meta:{ status:'open', assigned:'', rating:null, unread:0, autoReplyEnabled:false, autoReplyTemplate:'' } }; });
    return out;
  }

  function renderChat(){
    const div = document.getElementById('chatDivision')?.value || 'Finance';
    const raw = read(KEY_CHAT) || {};
    const data = normalizeChat(raw);
    // persist normalized shape (helps when upgrading from older shape)
    write(KEY_CHAT, data);
    // join socket room for this division (if available)
    if(socket && socketAvailable){ try{ socket.emit('join', { division: div }); } catch(e){ console.warn('socket join failed', e.message); } }
    const chat = data[div] || { messages: [], meta: { status:'open', assigned:'', rating:null, unread:0 } };
    const el = document.getElementById('chatMessages'); if(!el) return;
    el.innerHTML = chat.messages.map(m => {
      let attachments = '';
      if(m.attachments && m.attachments.length){
        attachments = m.attachments.map(a => `<div><a class=\"attachment-link\" href=\"${a.data}\" download=\"${escapeHtml(a.name)}\">📎 ${escapeHtml(a.name)}</a></div>`).join('');
      }
      const cls = m.from === 'user' ? 'user' : (m.from === 'admin' ? 'bot' : 'bot');
      const typeLabel = m.type && m.type === 'keluhan' ? '<span class=\"badge bg-warning text-dark me-1 small\">Keluhan</span>' : '';
      return `\n        <div class=\"msg ${cls}\">\n          <div class=\"bubble\">${typeLabel}${escapeHtml(m.text || '')}${attachments}</div>\n        </div>`;
    }).join('');
    el.scrollTop = el.scrollHeight;
    // mark bot/admin messages as read locally
    let changed = false;
    chat.messages.forEach(m => { if(m.from !== 'user' && m.status !== 'read'){ m.status = 'read'; changed = true; } });
    if(changed){ data[div] = chat; write(KEY_CHAT, data); }
    // show rating UI if solved and not rated
    const ratingEl = document.getElementById('chatRating'); if(ratingEl){
      ratingEl.innerHTML = '';
      if(chat.meta && chat.meta.status === 'solved'){
        if(!chat.meta.rating){
          ratingEl.innerHTML = `<div class=\"d-flex align-items-center gap-2\"><div class=\"small muted\">Rate support:</div><div id=\"ratingStars\">${[1,2,3,4,5].map(i=>`<button class=\"btn btn-sm btn-outline-secondary\" data-star=\"${i}\">${i}★</button>`).join('')}</div></div>`;
          document.querySelectorAll('#ratingStars button').forEach(b => b.addEventListener('click', (e)=>{
            const v = +e.currentTarget.dataset.star; chat.meta.rating = v; data[div] = chat; write(KEY_CHAT, data); showToast('Thanks','Terima kasih atas rating Anda','success'); renderChat();
          }));
        } else {
          ratingEl.innerHTML = `<div class=\"small muted\">Rating Anda: <strong>${chat.meta.rating}★</strong></div>`;
        }
      }
    }
  }

  function sendChat(){
    const inp = document.getElementById('chatInput'); if(!inp) return;
    const fileInput = document.getElementById('chatFile');
    const txt = inp.value.trim();
    if(!txt && (!fileInput || !fileInput.files || !fileInput.files.length)) return;
    const div = document.getElementById('chatDivision')?.value || 'Finance';
    const raw = read(KEY_CHAT) || {};
    const data = normalizeChat(raw);
    const type = document.getElementById('chatType')?.value || 'general';
    const msg = { from: 'user', text: txt, ts: Date.now(), status: 'sent', attachments: [], type: type };
    const pushAndNotify = () => {
      data[div].messages.push(msg);
      // increment unread for admin view if admin not viewing
      const adminViewing = document.querySelector('.nav-link.active')?.dataset?.page === 'adminchat';
      if(!adminViewing) data[div].meta.unread = (data[div].meta.unread || 0) + 1;
      write(KEY_CHAT, data); renderChat(); updateMiniBadge(); inp.value = ''; if(fileInput) fileInput.value = null;
      showToast('Terkirim','Pesan dikirim ke '+div,'success');
      // if this is a complaint and auto-reply enabled, schedule admin auto-reply
      try{ const meta = data[div].meta || {}; if(msg.type === 'keluhan' && meta.autoReplyEnabled && meta.autoReplyTemplate){ const adminMsg = { from:'admin', text: meta.autoReplyTemplate, ts: Date.now(), status:'sent', attachments:[] }; setTimeout(()=>{ const fresh = normalizeChat(read(KEY_CHAT)||{}); fresh[div].messages.push(adminMsg); fresh[div].meta.unread = (fresh[div].meta.unread||0) + 1; write(KEY_CHAT, fresh); renderChat(); updateMiniBadge(); if(socket && socketAvailable){ try{ socket.emit('send_message', { division: div, sender: 'admin', text: adminMsg.text, attachments: [] }); }catch(e){} } }, 600); } }catch(e){ console.warn('auto-reply check failed', e.message); }
      // emit via socket if available
      if(socket && socketAvailable){
        try{ socket.emit('send_message', { division: div, sender: 'user', text: txt, attachments: msg.attachments, type: msg.type }); }
        catch(e){ console.warn('socket emit failed', e.message); }
      } else {
        // fallback: local bot reply simulation
        setTimeout(()=> botReply(div, txt), 800 + Math.floor(Math.random()*800));
      }
    };
    if(fileInput && fileInput.files && fileInput.files[0]){
      const f = fileInput.files[0];
      const reader = new FileReader();
      reader.onload = function(ev){ msg.attachments.push({ name: f.name, type: f.type, size: f.size, data: ev.target.result }); pushAndNotify(); };
      reader.readAsDataURL(f);
    } else pushAndNotify();
  }

  function botReply(div, userText){
    const canned = { Finance:['Terima kasih. Tim Finance menindaklanjuti.','Mohon lampirkan invoice pendukung.'], HCIS:['HCIS menerima pesan Anda.','Sertakan NIK untuk percepatan.'], LDD:['LDD mencatat kebutuhan teknis Anda.','Mohon jelaskan spesifikasi lebih detail.'] };
    const pool = canned[div] || ['Terima kasih, pesan diterima.'];
    const reply = pool[Math.floor(Math.random()*pool.length)];
    const raw = read(KEY_CHAT) || {};
    const data = normalizeChat(raw);
    const botMsg = { from: 'bot', text: reply, ts: Date.now(), status: 'sent', attachments: [] };
    data[div].messages.push(botMsg);
    // mark unread for user if not viewing
    const viewingUser = document.querySelector('.nav-link.active')?.dataset?.page === 'chat' && document.getElementById('chatDivision')?.value === div;
    if(!viewingUser) data[div].meta.unread = (data[div].meta.unread || 0) + 1;
    write(KEY_CHAT, data); renderChat(); if(!viewingUser){ showToast('Pesan Baru','Ada pesan dari '+div,'info',4000); flashTitle('Pesan baru — '+div); }
    updateMiniBadge();
  }

  /* Mini chat helpers */
  function updateMiniBadge(){
    try{
      const raw = read(KEY_CHAT) || {};
      const data = normalizeChat(raw);
      let total = 0; Object.keys(data).forEach(k=>{ total += (data[k].meta && data[k].meta.unread) ? data[k].meta.unread : 0; });
      const b = document.getElementById('miniChatBadge'); if(!b) return;
      if(total>0){ b.style.display='block'; b.textContent = total>99? '99+': String(total); } else b.style.display='none';
    }catch(e){ console.warn('mini badge update', e.message); }
  }

  function renderMiniChat(){
    const el = document.getElementById('miniChatMessages'); if(!el) return;
    const div = document.getElementById('miniChatDivision')?.value || 'Finance';
    const raw = read(KEY_CHAT) || {};
    const data = normalizeChat(raw);
    const chat = data[div] || { messages: [], meta: { status:'open', assigned:'', rating:null, unread:0 } };
    // render last 40 messages
    const msgs = chat.messages.slice(-40).map(m=>{
      const cls = m.from === 'user' ? 'user' : (m.from === 'admin' ? 'bot' : 'bot');
      let attachments = '';
      if(m.attachments && m.attachments.length){ attachments = m.attachments.map(a=>`<div><a class="attachment-link" href="${a.data}" download="${escapeHtml(a.name)}">📎 ${escapeHtml(a.name)}</a></div>`).join(''); }
      const typeLabel = m.type && m.type === 'keluhan' ? '<span class="badge bg-warning text-dark me-1 small">Keluhan</span>' : '';
      return `<div class="mini-msg ${cls}"><div class="bubble">${typeLabel}${escapeHtml(m.text||'')}${attachments}</div></div>`;
    }).join('');
    el.innerHTML = msgs;
    el.scrollTop = el.scrollHeight;
  }

  function openMiniChat(){
    const panel = document.getElementById('miniChatPanel'); if(!panel) return;
    panel.classList.remove('hidden'); panel.setAttribute('aria-hidden','false'); document.getElementById('miniChatInput')?.focus();
    // mark current division unread -> 0
    try{ const div = document.getElementById('miniChatDivision')?.value || 'Finance'; const raw = read(KEY_CHAT)||{}; const data = normalizeChat(raw); if(data[div]){ data[div].meta.unread = 0; write(KEY_CHAT,data); } }catch(e){}
    renderMiniChat(); updateMiniBadge();
    if(socket && socketAvailable){ try{ socket.emit('join',{ division: document.getElementById('miniChatDivision')?.value || 'Finance' }); } catch(e){} }
  }

  function closeMiniChat(){ const panel = document.getElementById('miniChatPanel'); if(!panel) return; panel.classList.add('hidden'); panel.setAttribute('aria-hidden','true'); }

  // Mini send (supports file attachments)
  function miniSendChat(){
    const inp = document.getElementById('miniChatInput'); if(!inp) return;
    const fileInput = document.getElementById('miniChatFile');
    const txt = inp.value.trim();
    if(!txt && (!fileInput || !fileInput.files || !fileInput.files.length)) return;
    const div = document.getElementById('miniChatDivision')?.value || 'Finance';
    const raw = read(KEY_CHAT) || {};
    const data = normalizeChat(raw);
    const type = document.getElementById('miniChatType')?.value || 'general';
    const msg = { from: 'user', text: txt, ts: Date.now(), status: 'sent', attachments: [], type: type };
    const pushAndNotify = () => {
      data[div].messages.push(msg);
      const adminViewing = document.querySelector('.nav-link.active')?.dataset?.page === 'adminchat';
      if(!adminViewing) data[div].meta.unread = (data[div].meta.unread || 0) + 1;
      write(KEY_CHAT, data);
      renderMiniChat(); inp.value = ''; if(fileInput) fileInput.value = null;
      showToast('Terkirim','Pesan dikirim ke '+div,'success');
      updateMiniBadge();
      // auto-reply for complaints if enabled
      try{ const meta = data[div].meta || {}; if(msg.type === 'keluhan' && meta.autoReplyEnabled && meta.autoReplyTemplate){ const adminMsg = { from:'admin', text: meta.autoReplyTemplate, ts: Date.now(), status:'sent', attachments:[] }; setTimeout(()=>{ const fresh = normalizeChat(read(KEY_CHAT)||{}); fresh[div].messages.push(adminMsg); fresh[div].meta.unread = (fresh[div].meta.unread||0) + 1; write(KEY_CHAT, fresh); renderMiniChat(); updateMiniBadge(); if(socket && socketAvailable){ try{ socket.emit('send_message', { division: div, sender: 'admin', text: adminMsg.text, attachments: [] }); }catch(e){} } }, 600); } }catch(e){ console.warn('auto-reply failed', e.message); }
      if(socket && socketAvailable){ try{ socket.emit('send_message', { division: div, sender: 'user', text: msg.text, attachments: msg.attachments, type: msg.type }); } catch(e){ console.warn('socket emit failed', e.message); } }
      else setTimeout(()=> botReply(div, msg.text), 800 + Math.floor(Math.random()*800));
    };
    if(fileInput && fileInput.files && fileInput.files[0]){
      const f = fileInput.files[0];
      const reader = new FileReader();
      reader.onload = function(ev){ msg.attachments.push({ name: f.name, type: f.type, size: f.size, data: ev.target.result }); pushAndNotify(); };
      reader.readAsDataURL(f);
    } else pushAndNotify();
  }

  // Wire mini controls
  document.addEventListener('click', (e)=>{
    if(e.target && e.target.id === 'miniChatBtn'){
      const panel = document.getElementById('miniChatPanel'); if(panel && !panel.classList.contains('hidden')) closeMiniChat(); else openMiniChat();
    }
  });
  document.getElementById('miniChatClose')?.addEventListener('click', ()=> closeMiniChat());
  document.getElementById('miniChatSendBtn')?.addEventListener('click', ()=> miniSendChat());
  document.getElementById('miniChatDivision')?.addEventListener('change', ()=> renderMiniChat());
  // full-open button removed; mini chat only

  // Initialize badge on load
  setTimeout(()=> updateMiniBadge(), 300);

  // Admin UI functions (demo): list chats, open, reply, assign, status
  let adminSelectedDiv = null;
  function renderAdminList(){
    const raw = read(KEY_CHAT) || {};
    const data = normalizeChat(raw);
    write(KEY_CHAT, data);
    const ul = document.getElementById('adminChatsList'); if(!ul) return; ul.innerHTML = '';
    Object.keys(data).forEach(d => {
      const chat = data[d];
      const last = chat.messages.length ? chat.messages[chat.messages.length-1].text : '-';
      const unread = chat.meta && chat.meta.unread ? chat.meta.unread : 0;
      const li = document.createElement('li'); li.className = 'list-group-item';
      li.innerHTML = `<div>${escapeHtml(d)}<div class=\"small muted\">${escapeHtml(String(last).slice(0,40))}</div></div><div>${unread?('<span class=\"badge bg-danger\">'+unread+'</span>'):''}</div>`;
      li.addEventListener('click', ()=> openAdminSession(d));
      ul.appendChild(li);
    });
  }

  function openAdminSession(div){
    adminSelectedDiv = div; const raw = read(KEY_CHAT) || {}; const data = normalizeChat(raw); const chat = data[div] || { messages:[], meta:{ status:'open', assigned:'', rating:null, unread:0, autoReplyEnabled:false, autoReplyTemplate:'' } };
    // join socket room for admin view
    if(socket && socketAvailable){ try{ socket.emit('join', { division: div }); } catch(e){ console.warn('socket join failed', e.message); } }
    document.getElementById('adminChatTitleSelected').textContent = div;
    document.getElementById('adminChatMeta').innerHTML = `Status: <span class=\"badge bg-secondary\">${chat.meta.status}</span> &nbsp; Assigned: <strong>${escapeHtml(chat.meta.assigned || '-')}</strong>`;
    document.getElementById('adminStatusSel').value = chat.meta.status || 'open';
    // populate auto-reply controls
    const autoEnableEl = document.getElementById('adminAutoReplyEnable');
    const autoInpEl = document.getElementById('adminAutoReplyInput');
    if(autoEnableEl) autoEnableEl.checked = !!chat.meta.autoReplyEnabled;
    if(autoInpEl) autoInpEl.value = chat.meta.autoReplyTemplate || '';
    document.getElementById('adminMessages').innerHTML = chat.messages.map(m=>{
      let att = '';
      if(m.attachments && m.attachments.length) att = m.attachments.map(a=>`<div><a class=\"attachment-link\" href=\"${a.data}\" download=\"${escapeHtml(a.name)}\">📎 ${escapeHtml(a.name)}</a></div>`).join('');
      const who = m.from === 'user' ? '<strong>User</strong>' : (m.from === 'admin' ? '<strong>Admin</strong>' : '<strong>System</strong>');
      const typeLabel = m.type && m.type === 'keluhan' ? '<span class=\"badge bg-warning text-dark me-1 small\">Keluhan</span>' : '';
      return `<div class=\"msg\"><div class=\"bubble\">${who}: ${typeLabel} ${escapeHtml(m.text||'')} ${att}</div></div>`;
    }).join('');
    // mark unread -> 0 and mark messages read
    chat.meta.unread = 0; chat.messages.forEach(m=>{ if(m.status && m.status !== 'read') m.status = 'read'; }); data[div] = chat; write(KEY_CHAT, data); renderAdminList();
  }

  document.getElementById('adminSendBtn')?.addEventListener('click', ()=>{
    const txt = document.getElementById('adminReplyInput')?.value || ''; const fileInput = document.getElementById('adminFile'); if(!adminSelectedDiv) return alert('Pilih chat dulu');
    if(!txt && (!fileInput || !fileInput.files.length)) return;
    const raw = read(KEY_CHAT) || {}; const data = normalizeChat(raw);
    const msg = { from:'admin', text: txt, ts: Date.now(), status:'sent', attachments:[] };
    const pushAdmin = ()=>{ data[adminSelectedDiv].messages.push(msg); data[adminSelectedDiv].meta.unread = (data[adminSelectedDiv].meta.unread||0) + 1; write(KEY_CHAT, data); document.getElementById('adminReplyInput').value = ''; if(fileInput) fileInput.value = null; openAdminSession(adminSelectedDiv); showToast('Sukses','Balasan terkirim','success');
      if(socket && socketAvailable){ try{ socket.emit('send_message', { division: adminSelectedDiv, sender: 'admin', text: msg.text, attachments: msg.attachments }); }catch(e){ console.warn('socket emit failed', e.message); } }
    };
    if(fileInput && fileInput.files && fileInput.files[0]){ const f = fileInput.files[0]; const reader = new FileReader(); reader.onload = function(ev){ msg.attachments.push({ name: f.name, type: f.type, size: f.size, data: ev.target.result }); pushAdmin(); }; reader.readAsDataURL(f); } else pushAdmin();
  });

  document.getElementById('adminAssignBtn')?.addEventListener('click', ()=>{ if(!adminSelectedDiv) return; const raw = read(KEY_CHAT)||{}; const data = normalizeChat(raw); data[adminSelectedDiv].meta.assigned = 'Admin Demo'; write(KEY_CHAT, data); openAdminSession(adminSelectedDiv); showToast('Assigned','Chat diassign pada Anda','success'); });
  document.getElementById('adminStatusSel')?.addEventListener('change', (e)=>{ if(!adminSelectedDiv) return; const raw = read(KEY_CHAT)||{}; const data = normalizeChat(raw); data[adminSelectedDiv].meta.status = e.target.value; write(KEY_CHAT, data); openAdminSession(adminSelectedDiv); showToast('Status','Status chat diubah','success'); });
  document.getElementById('adminUseQuick')?.addEventListener('click', ()=>{ const v = document.getElementById('adminQuickReply')?.value || ''; if(v) document.getElementById('adminReplyInput').value = v; });
  document.getElementById('adminSendQuick')?.addEventListener('click', ()=>{ const v = document.getElementById('adminQuickReply')?.value || ''; if(!v) return; document.getElementById('adminReplyInput').value = v; document.getElementById('adminSendBtn')?.click(); });
  // Auto-reply controls: save changes immediately to meta
  document.getElementById('adminAutoReplyEnable')?.addEventListener('change', (e)=>{
    if(!adminSelectedDiv) return; const raw = read(KEY_CHAT)||{}; const data = normalizeChat(raw); data[adminSelectedDiv].meta.autoReplyEnabled = !!e.target.checked; write(KEY_CHAT, data); openAdminSession(adminSelectedDiv); showToast('Auto-reply','Pengaturan auto-reply disimpan','success');
  });
  // admin auto-reply input handler (saved on change)
  document.getElementById('adminAutoReplyInput')?.addEventListener('change', (e)=>{
    if(!adminSelectedDiv) return; const raw = read(KEY_CHAT)||{}; const data = normalizeChat(raw); data[adminSelectedDiv].meta.autoReplyTemplate = e.target.value || ''; write(KEY_CHAT, data); openAdminSession(adminSelectedDiv); showToast('Auto-reply','Template auto-reply disimpan','success');
  });

  // Admin quick replies and broadcast
  const KEY_CHAT_QUICK = 'smarthcis_chat_quick';

  function ensureAdminStorage(){
    // default quick replies per division
    const defaultQuick = {
      Finance: [
        'Terima kasih, kami akan memproses dokumen Anda dalam 2 hari kerja.',
        'Sudah diterima, mohon tunggu konfirmasi lebih lanjut dari tim Finance.',
        'Mohon lampirkan invoice dan bukti pembayaran terkait.',
        'Jumlah belum sesuai; mohon periksa kembali detail transaksi.'
      ],
      HCIS: [
        'Terima kasih, HR akan menindaklanjuti permintaan Anda.',
        'Mohon lengkapi NIK dan dokumen pendukung.',
        'Permintaan cuti Anda telah diterima dan sedang diproses.',
        'Silakan hubungi HR untuk penjadwalan interview/meeting.'
      ],
      LDD: [
        'Tim teknis mencatat kebutuhan Anda dan akan merespon dalam 1x24 jam.',
        'Mohon jelaskan spesifikasi lebih detail atau lampirkan screenshot/error log.',
        'Permintaan diterima, sedang dalam antrean pengerjaan.',
        'Untuk permintaan integrasi, sertakan flow diagram atau use-case singkat.'
      ]
    };

    const curQuick = read(KEY_CHAT_QUICK);
    if(!curQuick){ write(KEY_CHAT_QUICK, defaultQuick); }
    else { ['Finance','HCIS','LDD'].forEach(d=>{ if(!Array.isArray(curQuick[d]) || curQuick[d].length === 0) curQuick[d] = defaultQuick[d]; }); write(KEY_CHAT_QUICK, curQuick); }
  }

  // templates removed — admin uses quick replies or direct auto-reply input

  function loadAdminQuickReplies(div){ ensureAdminStorage(); const q = read(KEY_CHAT_QUICK)||{}; const sel = document.getElementById('adminQuickReply'); if(!sel) return; sel.innerHTML = '<option value="">Quick reply...</option>'; (q[div]||[]).forEach(t=> sel.appendChild(new Option(t,t))); }

  // add quick reply
  document.getElementById('adminAddQuick')?.addEventListener('click', ()=>{
    if(!adminSelectedDiv) return alert('Pilih chat/divisi dulu'); const v = document.getElementById('adminQuickAddInput')?.value || ''; if(!v) return; const q = read(KEY_CHAT_QUICK)||{}; q[adminSelectedDiv] = q[adminSelectedDiv]||[]; q[adminSelectedDiv].push(v); write(KEY_CHAT_QUICK, q); loadAdminQuickReplies(adminSelectedDiv); document.getElementById('adminQuickAddInput').value=''; showToast('Quick reply','Ditambahkan','success');
  });

  // template management removed — admin sets auto-reply via direct input or uses quick replies

  // Broadcast to all divisions
  document.getElementById('adminBroadcastBtn')?.addEventListener('click', ()=>{
    const v = document.getElementById('adminBroadcastInput')?.value || ''; if(!v) return alert('Isi pesan broadcast'); const raw = read(KEY_CHAT)||{}; const data = normalizeChat(raw); ['Finance','HCIS','LDD'].forEach(d=>{ data[d].messages.push({ from:'admin', text: v, ts: Date.now(), status:'sent', attachments:[], type:'general' }); data[d].meta.unread = (data[d].meta.unread||0) + 1; }); write(KEY_CHAT, data); showToast('Broadcast','Terkirim ke semua divisi','success'); loadAdminQuickReplies(adminSelectedDiv||'Finance'); document.getElementById('adminBroadcastInput').value=''; renderAdminList(); if(socket && socketAvailable){ try{ socket.emit('broadcast', { text: v, sender:'admin' }); }catch(e){} }
  });

  // load quick replies whenever admin opens a session
  const originalOpenAdminSession = openAdminSession;
  window.openAdminSession = function(div){ originalOpenAdminSession(div); loadAdminQuickReplies(div); };

  // open options modal
  document.getElementById('adminOptionsBtn')?.addEventListener('click', ()=>{
    const modalEl = document.getElementById('adminOptionsModal'); if(!modalEl) return;
    const bsModal = new bootstrap.Modal(modalEl);
    // ensure current division's quick replies are loaded
    loadAdminQuickReplies(adminSelectedDiv || 'Finance');
    // sync auto-reply checkbox/input
    const raw = read(KEY_CHAT) || {}; const data = normalizeChat(raw); const meta = (adminSelectedDiv && data[adminSelectedDiv]) ? data[adminSelectedDiv].meta : null;
    if(meta){ document.getElementById('adminAutoReplyEnable').checked = !!meta.autoReplyEnabled; const inp = document.getElementById('adminAutoReplyInput'); if(inp) inp.value = meta.autoReplyTemplate || ''; }
    bsModal.show();
  });

  // initialize admin storages on load
  ensureAdminStorage();

  // document title flash for notifications
  let titleFlashTimer = null; let originalTitle = document.title;
  function flashTitle(msg){ if(titleFlashTimer) return; let showAlt = true; titleFlashTimer = setInterval(()=>{ document.title = showAlt ? msg : originalTitle; showAlt = !showAlt; }, 800); setTimeout(()=>{ clearInterval(titleFlashTimer); titleFlashTimer = null; document.title = originalTitle; }, 6000); }

  /* ===========================
     Initialize when logged in
     =========================== */
  if(localStorage.getItem(LOGIN_KEY) === '1'){
    // if user refreshes while logged in, init UI
    loginPage.style.display = 'none';
    app.style.display = 'flex';
    app.setAttribute('aria-hidden','false');
    initAfterLogin();
  }

  // convenience: close modals with Escape
  document.addEventListener('keydown', (e) => {
    if(e.key === 'Escape'){ document.querySelectorAll('.modal.show').forEach(m => bootstrap.Modal.getInstance(m)?.hide()); }
  });

  // small fallback: update PR total on load if fields present
  window.addEventListener('DOMContentLoaded', () => {
    document.getElementById('pr_qty')?.addEventListener('input', updatePRTotalDisplay);
    document.getElementById('pr_price')?.addEventListener('input', updatePRTotalDisplay);
  });
  </script>
  <!-- Admin Options Modal -->
  <div class="modal fade" id="adminOptionsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Admin Chat Options</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <h6>Quick Replies</h6>
            <div class="d-flex gap-2 mb-2">
              <select id="adminQuickReply" class="form-select form-select-sm w-50">
                <option value="">Quick reply...</option>
              </select>
              <button id="adminUseQuick" class="btn btn-outline-secondary btn-sm">Use</button>
              <button id="adminSendQuick" class="btn btn-sm btn-outline-primary">Send Now</button>
            </div>
            <div class="d-flex gap-2">
              <input id="adminQuickAddInput" class="form-control form-control-sm" placeholder="Tambah quick reply..." />
              <button id="adminAddQuick" class="btn btn-sm btn-outline-primary">Add Quick</button>
            </div>
          </div>

          <hr />

          <div class="mb-3">
            <h6>Auto-reply</h6>
            <div class="d-flex gap-2 align-items-center">
              <input type="checkbox" id="adminAutoReplyEnable" />
              <label for="adminAutoReplyEnable" class="small muted mb-0">Enable auto-reply for current division</label>
            </div>
            <div class="mt-2">
              <textarea id="adminAutoReplyInput" class="form-control form-control-sm" rows="3" placeholder="Tulis isi auto-reply di sini..."></textarea>
            </div>
          </div>

          <hr />

          <div class="mb-3">
            <h6>Broadcast</h6>
            <div class="d-flex gap-2">
              <input id="adminBroadcastInput" class="form-control form-control-sm" placeholder="Broadcast message to all divisions..." />
              <button id="adminBroadcastBtn" class="btn btn-sm btn-warning">Broadcast</button>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</body>
</html>