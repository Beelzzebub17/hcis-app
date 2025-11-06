<?php
// Hubungkan ke database
include '../config.php';

// Ambil data dari tabel (gunakan nama tabel sesuai database kamu)
$totalKaryawan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM karyawan"))['total'] ?? 0;
$pelatihanAktif = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM pelatihan WHERE status='aktif'"))['total'] ?? 0;
$kehadiranHariIni = mysqli_fetch_assoc(mysqli_query($conn, "SELECT AVG(persentase) as rata FROM kehadiran WHERE tanggal = CURDATE()"))['rata'] ?? 0;
$proyekAktif = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM proyek WHERE status='aktif'"))['total'] ?? 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard HCIS</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<div id="dashboard" class="container py-4">
  <div class="header-card d-flex justify-content-between align-items-center mb-4">
    <div>
      <h3 class="fw-bold mb-1">Dashboard</h3>
      <p class="text-secondary mb-0">Ringkasan performa dan aktivitas sistem</p>
    </div>
    <button class="btn btn-primary btn-sm"><i class="bi bi-download"></i> Export Report</button>
  </div>

  <!-- Statistik Cards -->
  <div class="row g-3 mb-4">
    <div class="col-md-3 col-sm-6">
      <div class="card border-0 shadow-sm p-3 rounded-4">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <p class="text-secondary small mb-1">Total Karyawan</p>
            <h4 class="fw-bold mb-0"><?= $totalKaryawan; ?></h4>
          </div>
          <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-3">
            <i class="bi bi-people fs-4"></i>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-3 col-sm-6">
      <div class="card border-0 shadow-sm p-3 rounded-4">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <p class="text-secondary small mb-1">Pelatihan Aktif</p>
            <h4 class="fw-bold mb-0"><?= $pelatihanAktif; ?> Program</h4>
          </div>
          <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-3">
            <i class="bi bi-award fs-4"></i>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-3 col-sm-6">
      <div class="card border-0 shadow-sm p-3 rounded-4">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <p class="text-secondary small mb-1">Kehadiran Hari Ini</p>
            <h4 class="fw-bold mb-0"><?= number_format($kehadiranHariIni, 2); ?>%</h4>
          </div>
          <div class="bg-success bg-opacity-10 text-success p-3 rounded-3">
            <i class="bi bi-clock-history fs-4"></i>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-3 col-sm-6">
      <div class="card border-0 shadow-sm p-3 rounded-4">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <p class="text-secondary small mb-1">Proyek Aktif</p>
            <h4 class="fw-bold mb-0"><?= $proyekAktif; ?></h4>
          </div>
          <div class="bg-info bg-opacity-10 text-info p-3 rounded-3">
            <i class="bi bi-kanban fs-4"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Grafik dan Aktivitas -->
  <div class="row g-4">
    <!-- Grafik Kehadiran -->
    <div class="col-lg-8">
      <div class="card border-0 shadow-sm p-4 rounded-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h6 class="fw-semibold mb-0">Grafik Kehadiran Karyawan</h6>
          <select class="form-select form-select-sm w-auto">
            <option>Mingguan</option>
            <option>Bulanan</option>
            <option>Tahunan</option>
          </select>
        </div>
        <canvas id="attendanceChart" height="140"></canvas>
      </div>
    </div>

    <!-- Aktivitas Terbaru -->
    <div class="col-lg-4">
      <div class="card border-0 shadow-sm p-4 rounded-4">
        <h6 class="fw-semibold mb-3">Aktivitas Terbaru</h6>
        <ul class="list-group list-group-flush small">
          <li class="list-group-item px-0 d-flex align-items-center">
            <i class="bi bi-person-check text-success me-2"></i> 5 Karyawan baru bergabung hari ini
          </li>
          <li class="list-group-item px-0 d-flex align-items-center">
            <i class="bi bi-award text-warning me-2"></i> Program “Leadership Training” dimulai
          </li>
          <li class="list-group-item px-0 d-flex align-items-center">
            <i class="bi bi-clock text-primary me-2"></i> Revisi jadwal shift malam HRD
          </li>
          <li class="list-group-item px-0 d-flex align-items-center">
            <i class="bi bi-cash-stack text-info me-2"></i> Proses payroll bulan ini selesai
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('attendanceChart');
new Chart(ctx, {
  type: 'line',
  data: {
    labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum'],
    datasets: [{
      label: 'Kehadiran (%)',
      data: [95, 97, 93, 98, 96],
      borderColor: '#2563eb',
      backgroundColor: 'rgba(37,99,235,0.1)',
      fill: true,
      tension: 0.3
    }]
  },
  options: {
    responsive: true,
    plugins: { legend: { display: false } },
    scales: {
      y: { beginAtZero: true, max: 100 },
      x: { grid: { display: false } }
    }
  }
});
</script>

</body>
</html>
