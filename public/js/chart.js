// Pastikan elemen canvas sudah ada di halaman
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
