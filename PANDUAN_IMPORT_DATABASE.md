# Panduan Import Database ke phpMyAdmin

File ini berisi panduan lengkap untuk mengimport struktur database ke phpMyAdmin.

## File yang Dibutuhkan
- `database.sql` - File SQL yang berisi struktur tabel dan data sample

## Cara Import ke phpMyAdmin

### Metode 1: Import Melalui Interface phpMyAdmin

1. **Buka phpMyAdmin**
   - Akses phpMyAdmin melalui browser (biasanya: `http://localhost/phpmyadmin` atau `http://localhost:8080/phpmyadmin`)

2. **Buat Database Baru (jika belum ada)**
   - Klik pada tab "Databases" atau "Database"
   - Masukkan nama database (contoh: `hcis_app`)
   - Pilih collation: `utf8mb4_general_ci`
   - Klik "Create" atau "Buat"

3. **Pilih Database**
   - Klik pada database yang baru dibuat dari daftar di sidebar kiri

4. **Import File SQL**
   - Klik tab "Import" di menu atas
   - Klik tombol "Choose File" atau "Pilih File"
   - Pilih file `database.sql` yang ada di folder project Anda
   - Pastikan format file adalah "SQL"
   - Klik tombol "Go" atau "Kirim" untuk memulai import

5. **Verifikasi**
   - Setelah import selesai, Anda akan melihat pesan sukses
   - Cek di sidebar kiri, pastikan tabel `users` dan `purchase_requisitions` sudah muncul

### Metode 2: Import Melalui Command Line (MySQL)

Jika Anda lebih suka menggunakan command line, ikuti langkah berikut:

```bash
# Masuk ke MySQL
mysql -u root -p

# Buat database
CREATE DATABASE hcis_app CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

# Keluar dari MySQL
exit;

# Import file SQL
mysql -u root -p hcis_app < database.sql
```

Atau untuk Windows dengan Laragon:

```bash
# Buka terminal/command prompt di folder project
cd C:\laragon\www\hcis-app - Copy

# Import menggunakan MySQL dari Laragon
C:\laragon\bin\mysql\mysql-8.0.30\bin\mysql.exe -u root hcis_app < database.sql
```

### Metode 3: Copy-Paste SQL (Alternatif)

1. Buka file `database.sql` dengan text editor
2. Copy semua isi file
3. Buka phpMyAdmin
4. Pilih database yang ingin digunakan
5. Klik tab "SQL"
6. Paste SQL yang sudah di-copy
7. Klik "Go" atau "Kirim"

## Struktur Tabel

### Tabel: `users`
- `id` - Primary key (INT, auto increment)
- `nama` - Nama user (VARCHAR 100)
- `email` - Email user (VARCHAR 100)
- `password` - Password ter-hash (VARCHAR 255)
- `created_at` - Tanggal dibuat (DATETIME)
- `updated_at` - Tanggal diupdate (DATETIME)

### Tabel: `purchase_requisitions`
- `id` - Primary key (INT, auto increment)
- `pr_number` - Nomor Purchase Requisition (VARCHAR 100)
- `description` - Deskripsi (TEXT)
- `requester` - Pemohon (VARCHAR 100)
- `department` - Departemen (VARCHAR 100, nullable)
- `total_price` - Total harga (DECIMAL 15,2)
- `status` - Status (VARCHAR 50, default: 'Pending')
- `created_at` - Tanggal dibuat (DATETIME)
- `updated_at` - Tanggal diupdate (DATETIME)

## Konfigurasi Database di CodeIgniter

Setelah database diimport, pastikan konfigurasi di `app/Config/Database.php` sesuai:

```php
public array $default = [
    'hostname' => 'localhost',
    'username' => 'root',        // Sesuaikan dengan username MySQL Anda
    'password' => '',            // Sesuaikan dengan password MySQL Anda
    'database' => 'hcis_app',    // Nama database yang sudah dibuat
    'DBDriver' => 'MySQLi',
    'charset'  => 'utf8mb4',
    'DBCollat' => 'utf8mb4_general_ci',
];
```

Atau lebih baik lagi, gunakan file `.env` untuk konfigurasi:

```env
database.default.hostname = localhost
database.default.database = hcis_app
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi
database.default.charset = utf8mb4
database.default.DBCollat = utf8mb4_general_ci
```

## Troubleshooting

### Error: "Table already exists"
- Jika tabel sudah ada, hapus dulu tabel yang lama atau ubah `CREATE TABLE IF NOT EXISTS` menjadi `CREATE TABLE` di file SQL

### Error: "Access denied"
- Pastikan username dan password MySQL Anda benar
- Pastikan user memiliki hak akses untuk membuat database dan tabel

### Error: "Unknown database"
- Pastikan database sudah dibuat terlebih dahulu sebelum import
- Atau uncomment baris `CREATE DATABASE` di file SQL

## Catatan Penting

1. **Password pada data sample** menggunakan hash default. Pastikan untuk mengganti password dengan hash yang benar sebelum digunakan di production.

2. **Data sample** bersifat opsional. Jika tidak ingin memasukkan data sample, hapus bagian `INSERT INTO` di file SQL.

3. **Backup database** sebelum melakukan import jika database sudah berisi data penting.

## Testing

Setelah import selesai, Anda bisa test koneksi database dengan menjalankan:

```bash
php spark migrate
```

Atau test langsung dari aplikasi CodeIgniter Anda.

