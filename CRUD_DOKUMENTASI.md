# Dokumentasi CRUD untuk Semua Menu

Dokumentasi ini menjelaskan semua CRUD (Create, Read, Update, Delete) yang telah dibuat untuk setiap menu di aplikasi SmartHCIS.

## ✅ Menu yang Sudah Dibuat CRUD

### 1. Dashboard ✅
- **Status**: Tidak perlu CRUD (tampilan dashboard saja)
- **URL**: `/` (melalui route `ALL::index`)

### 2. Personal Admin ✅
- **Controller**: `app/Controllers/PersonalAdmin.php`
- **Model**: `app/Models/PersonalAdminModel.php`
- **Migration**: `app/Database/Migrations/2025-11-05-100000_CreatePersonalAdminTable.php`
- **Tabel Database**: `personal_admin`

**Routes:**
- `GET /personal-admin` - List semua karyawan
- `GET /personal-admin/create` - Form tambah karyawan
- `POST /personal-admin/store` - Simpan data karyawan
- `GET /personal-admin/edit/{id}` - Form edit karyawan
- `POST /personal-admin/update/{id}` - Update data karyawan
- `GET /personal-admin/delete/{id}` - Hapus data karyawan

**Fields:**
- NIK (required)
- Nama (required)
- Divisi
- Jabatan
- Email
- Phone
- Status (Active/Inactive)

### 3. Purchase Requisition ✅
- **Controller**: `app/Controllers/PurchaseRequisition.php`
- **Model**: `app/Models/PurchaseRequisitionModel.php`
- **Migration**: Sudah ada (`app/Database/Migrations/2025-11-05-084750_CreatePurchaseRequisitionsTable.php`)
- **Tabel Database**: `purchase_requisitions`

**Routes:**
- `GET /purchase-requisition` - List semua PR
- `GET /purchase-requisition/create` - Form tambah PR
- `POST /purchase-requisition/store` - Simpan PR (PR Number otomatis generated)
- `GET /purchase-requisition/edit/{id}` - Form edit PR
- `POST /purchase-requisition/update/{id}` - Update PR
- `GET /purchase-requisition/delete/{id}` - Hapus PR

**Features:**
- PR Number otomatis di-generate saat create
- Format: `PR-YYYYMMDD-XXXX`

### 4. Training Dev ✅
- **Controller**: `app/Controllers/TrainingDev.php`
- **Model**: `app/Models/TrainingDevModel.php`
- **Migration**: `app/Database/Migrations/2025-11-05-100001_CreateTrainingDevTable.php`
- **Tabel Database**: `training_dev`

**Routes:**
- `GET /training-dev` - List semua training
- `GET /training-dev/create` - Form tambah training
- `POST /training-dev/store` - Simpan training
- `GET /training-dev/edit/{id}` - Form edit training
- `POST /training-dev/update/{id}` - Update training
- `GET /training-dev/delete/{id}` - Hapus training

**Fields:**
- Title (required)
- Description
- Duration
- Instructor
- Start Date
- End Date
- Status (Scheduled/Ongoing/Completed/Cancelled)

### 5. Performance ✅
- **Controller**: `app/Controllers/Performance.php`
- **Model**: `app/Models/PerformanceModel.php`
- **Migration**: `app/Database/Migrations/2025-11-05-100002_CreatePerformanceTable.php`
- **Tabel Database**: `performance`

**Routes:**
- `GET /performance` - List semua performance
- `GET /performance/create` - Form tambah performance
- `POST /performance/store` - Simpan performance
- `GET /performance/edit/{id}` - Form edit performance
- `POST /performance/update/{id}` - Update performance
- `GET /performance/delete/{id}` - Hapus performance

**Features:**
- Rating otomatis di-generate berdasarkan score:
  - 90-100: Excellent
  - 80-89: Very Good
  - 70-79: Good
  - 60-69: Fair
  - <60: Poor

### 6. Data Validation ✅
- **Controller**: `app/Controllers/DataValidation.php`
- **Model**: `app/Models/DataValidationModel.php`
- **Migration**: `app/Database/Migrations/2025-11-05-100003_CreateDataValidationTable.php`
- **Tabel Database**: `data_validation`

**Routes:**
- `GET /data-validation` - List semua validation items
- `GET /data-validation/create` - Form tambah validation item
- `POST /data-validation/store` - Simpan validation item
- `GET /data-validation/edit/{id}` - Form edit validation item
- `POST /data-validation/update/{id}` - Update validation item
- `GET /data-validation/delete/{id}` - Hapus validation item

**Features:**
- Status otomatis: "OK" jika total = 0, "Not OK" jika total > 0
- Last check otomatis di-update saat create/update

### 7. System Setting ✅
- **Controller**: `app/Controllers/SystemSetting.php`
- **Model**: `app/Models/SystemSettingModel.php`
- **Migration**: `app/Database/Migrations/2025-11-05-100004_CreateSystemSettingsTable.php`
- **Tabel Database**: `system_settings`

**Routes:**
- `GET /system-setting` - List semua settings
- `GET /system-setting/create` - Form tambah setting
- `POST /system-setting/store` - Simpan setting
- `GET /system-setting/edit/{id}` - Form edit setting
- `POST /system-setting/update/{id}` - Update setting
- `GET /system-setting/delete/{id}` - Hapus setting

**Features:**
- Setting key harus unique
- Bisa menyimpan konfigurasi sistem dalam key-value format

### 8. Profile ✅
- **Status**: Tidak perlu CRUD terpisah (sudah ada di view `All.php`)
- **Note**: Profile menggunakan data dari tabel `users`

### 9. Logout ✅
- **Status**: Tidak perlu CRUD (hanya fungsi logout)

## 📁 Struktur File yang Dibuat

### Migrations
- `app/Database/Migrations/2025-11-05-100000_CreatePersonalAdminTable.php`
- `app/Database/Migrations/2025-11-05-100001_CreateTrainingDevTable.php`
- `app/Database/Migrations/2025-11-05-100002_CreatePerformanceTable.php`
- `app/Database/Migrations/2025-11-05-100003_CreateDataValidationTable.php`
- `app/Database/Migrations/2025-11-05-100004_CreateSystemSettingsTable.php`

### Models
- `app/Models/PersonalAdminModel.php`
- `app/Models/PurchaseRequisitionModel.php`
- `app/Models/TrainingDevModel.php`
- `app/Models/PerformanceModel.php`
- `app/Models/DataValidationModel.php`
- `app/Models/SystemSettingModel.php`

### Controllers
- `app/Controllers/PersonalAdmin.php`
- `app/Controllers/PurchaseRequisition.php`
- `app/Controllers/TrainingDev.php`
- `app/Controllers/Performance.php`
- `app/Controllers/DataValidation.php`
- `app/Controllers/SystemSetting.php`

### Views
Setiap menu memiliki 3 view:
- `app/Views/{menu}/index.php` - List data
- `app/Views/{menu}/create.php` - Form create
- `app/Views/{menu}/edit.php` - Form edit

**Directories:**
- `app/Views/personal_admin/`
- `app/Views/purchase_requisition/`
- `app/Views/training_dev/`
- `app/Views/performance/`
- `app/Views/data_validation/`
- `app/Views/system_setting/`

## 🗄️ Database

File `database.sql` sudah diupdate dengan semua tabel baru. Untuk import:

1. Buka phpMyAdmin
2. Pilih database
3. Import file `database.sql`

Atau jalankan migration:
```bash
php spark migrate
```

## 🔧 Cara Menggunakan

### 1. Setup Database
```bash
# Import database.sql ke phpMyAdmin
# atau
php spark migrate
```

### 2. Akses Menu CRUD
- Personal Admin: `http://localhost/personal-admin`
- Purchase Requisition: `http://localhost/purchase-requisition`
- Training Dev: `http://localhost/training-dev`
- Performance: `http://localhost/performance`
- Data Validation: `http://localhost/data-validation`
- System Setting: `http://localhost/system-setting`

### 3. Fitur Umum
- Semua halaman menggunakan layout yang sama (`layout.php`)
- Flash message untuk notifikasi sukses
- Validasi form di sisi client dan server
- Confirmation dialog sebelum delete
- Responsive design dengan Bootstrap 5

## 📝 Catatan Penting

1. **Session Flashdata**: Semua controller menggunakan `session()->setFlashdata()` untuk notifikasi
2. **Validation**: Form validation dilakukan di controller dan view
3. **Security**: Semua input menggunakan `esc()` untuk XSS protection
4. **Timestamps**: Semua model menggunakan `useTimestamps = true`
5. **Error Handling**: Semua controller memiliki error handling untuk data tidak ditemukan

## 🚀 Next Steps

1. Tambahkan authentication/authorization jika diperlukan
2. Tambahkan pagination untuk list yang panjang
3. Tambahkan search/filter untuk setiap menu
4. Tambahkan export (Excel/PDF) jika diperlukan
5. Tambahkan validasi lebih ketat di controller

## 📞 Support

Jika ada masalah atau pertanyaan, pastikan:
1. Database sudah diimport dengan benar
2. Routes sudah terdaftar di `app/Config/Routes.php`
3. Model dan Controller sudah dibuat dengan benar
4. View file ada di folder yang sesuai

