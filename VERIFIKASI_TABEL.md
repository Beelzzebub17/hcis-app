# Verifikasi Tabel Database

Dokumen ini memverifikasi bahwa semua tabel dari codingan sudah ada di file `database.sql`.

## ✅ Daftar Tabel yang Sudah Tercakup

### 1. Tabel `users` ✅
- **Migration File**: `app/Database/Migrations/2025-11-05-080456_CreateUsersTable.php`
- **Model**: `app/Models/UserModel.php` (menggunakan tabel `users`)
- **Controller**: `app/Controllers/User.php` (menggunakan `UserModel`)
- **Status**: ✅ **SUDAH ADA** di `database.sql`

**Struktur Field:**
- `id` (INT UNSIGNED, AUTO_INCREMENT, PRIMARY KEY)
- `nama` (VARCHAR 100)
- `email` (VARCHAR 100)
- `password` (VARCHAR 255)
- `created_at` (DATETIME, NULL)
- `updated_at` (DATETIME, NULL)

### 2. Tabel `purchase_requisitions` ✅
- **Migration File**: `app/Database/Migrations/2025-11-05-084750_CreatePurchaseRequisitionsTable.php`
- **Status**: ✅ **SUDAH ADA** di `database.sql`

**Struktur Field:**
- `id` (INT UNSIGNED, AUTO_INCREMENT, PRIMARY KEY)
- `pr_number` (VARCHAR 100)
- `description` (TEXT, NULL)
- `requester` (VARCHAR 100)
- `department` (VARCHAR 100, NULL)
- `total_price` (DECIMAL 15,2, DEFAULT 0.00)
- `status` (VARCHAR 50, DEFAULT 'Pending')
- `created_at` (DATETIME, NULL)
- `updated_at` (DATETIME, NULL)

## 📋 Tabel yang Tidak Digunakan (Tidak Perlu)

### Tabel `factories`
- **File**: `tests/_support/Models/ExampleModel.php`
- **Status**: ❌ **TIDAK DIPERLUKAN** - Ini adalah file untuk testing, bukan bagian dari aplikasi utama

### Model `User.php` (Laravel)
- **File**: `app/Models/User.php`
- **Status**: ❌ **TIDAK DIGUNAKAN** - Ini adalah model Laravel, sedangkan project ini menggunakan CodeIgniter 4. Model yang digunakan adalah `UserModel.php`

## ✅ Kesimpulan

**SEMUA TABEL YANG DIGUNAKAN DI APLIKASI SUDAH TERCAKUP DI FILE `database.sql`**

File `database.sql` sudah berisi:
1. ✅ Tabel `users` - sesuai dengan migration dan digunakan oleh `UserModel`
2. ✅ Tabel `purchase_requisitions` - sesuai dengan migration

## 📝 Cara Verifikasi Manual

Setelah import `database.sql` ke phpMyAdmin, pastikan Anda melihat:

1. **Tabel `users`** dengan 6 kolom:
   - id, nama, email, password, created_at, updated_at

2. **Tabel `purchase_requisitions`** dengan 9 kolom:
   - id, pr_number, description, requester, department, total_price, status, created_at, updated_at

## 🎯 Langkah Selanjutnya

Setelah import database, pastikan konfigurasi database di CodeIgniter sudah benar:

**File**: `app/Config/Database.php` atau file `.env`
```php
'database' => 'hcis_app',  // atau nama database yang Anda buat
'username' => 'root',      // sesuaikan dengan konfigurasi MySQL Anda
'password' => '',          // sesuaikan dengan password MySQL Anda
```

## ⚠️ Catatan Penting

1. **Data Sample**: File `database.sql` berisi data sample (opsional). Jika tidak ingin data sample, hapus bagian `INSERT INTO` sebelum import.

2. **Password Hash**: Password pada data sample menggunakan hash default. Pastikan untuk mengganti password dengan hash yang benar sebelum digunakan di production.

3. **Backup**: Selalu backup database yang sudah ada sebelum melakukan import jika database sudah berisi data penting.

