# Sistem Manajemen Stok Minimarket (Laravel)

Folder ini adalah **"overlay"**: hanya berisi file yang kita tulis (model, controller, view, migrasi, route, CSS).
Kerangka Laravel-nya dibuat dulu lewat Composer, lalu isi folder ini disalin menimpa proyek baru.

## 1. Requirement

| Kebutuhan | Versi / Keterangan |
|---|---|
| PHP | **8.3 atau lebih baru** (Laravel 13). Jika terpaksa memakai PHP 8.2, pasang Laravel 12: `composer create-project laravel/laravel:^12.0 stok-minimarket` |
| Ekstensi PHP | `mbstring`, `openssl`, `pdo_mysql` (atau `pdo_pgsql`), `tokenizer`, `xml`, `ctype`, `json`, `fileinfo`, `gd` (untuk PDF) |
| Composer | 2.x |
| Database | MySQL 8 / MariaDB 10.6+ atau PostgreSQL 14+ |
| Web server | `php artisan serve` untuk pengembangan; Nginx/Apache untuk produksi |
| Browser | Chrome atau Edge terbaru |
| Node.js / npm | **Tidak diperlukan** (CSS ditulis langsung di `public/css/app.css`) |
| Paket tambahan | `barryvdh/laravel-dompdf` (ekspor laporan ke PDF, FR-16) |
| Produksi | HTTPS (NFR-05), backup database terjadwal tiap minggu (NFR-02) |

Alternatif paling mudah di Windows: pasang **Laragon** atau **XAMPP** (PHP 8.3+) lalu Composer.

## 2. Langkah instalasi

```bash
# 1) Buat proyek Laravel baru
composer create-project laravel/laravel stok-minimarket
cd stok-minimarket

# 2) Pasang paket PDF
composer require barryvdh/laravel-dompdf

# 3) Salin isi folder overlay ini ke dalam proyek, pilih "timpa / replace" jika ditanya.
#    (app/, database/, public/, resources/, routes/, tests/)

# 4) Buat database kosong, mis. stok_minimarket, lalu edit file .env:
#    DB_CONNECTION=mysql
#    DB_HOST=127.0.0.1
#    DB_PORT=3306
#    DB_DATABASE=stok_minimarket
#    DB_USERNAME=root
#    DB_PASSWORD=
#    SESSION_DRIVER=database
#    SESSION_LIFETIME=15        # auto logout 15 menit tidak aktif (NFR-04)
#    APP_LOCALE=id
#    APP_TIMEZONE=Asia/Jakarta  # jika belum ada di config/app.php, ubah 'timezone' di sana

# 5) Buat tabel
php artisan migrate

# 6) (Opsional) data contoh produk dan supplier
php artisan db:seed --class=DemoSeeder

# 7) Jalankan
php artisan serve
```

Buka http://127.0.0.1:8000, klik **Registrasi** untuk membuat akun Admin, lalu **Masuk**.

## 3. Pemetaan SRS ke aplikasi

| SRS | Lokasi |
|---|---|
| FR-1..5 Produk | `ProductController`, `resources/views/products` |
| FR-6..8 Supplier | `SupplierController`, `resources/views/suppliers` |
| FR-9..11 PO | `PurchaseOrderController`, `resources/views/purchase-orders` |
| FR-12..13 Registrasi/Login | `AuthController`, `resources/views/auth` |
| FR-14..16 Laporan | `ReportController`, `resources/views/reports` |
| NFR-03, NFR-11 stok hanya bertambah lewat penerimaan PO | `PurchaseOrderController@receive` (transaksi DB + lock) |
| NFR-10 PO tidak dihapus | `PurchaseOrderController@cancel` (hanya ubah status) |

## 4. Catatan produksi

- Aktifkan HTTPS di web server (NFR-05).
- Jadwalkan backup database mingguan, mis. `mysqldump` lewat cron (Linux) atau Task Scheduler (Windows) (NFR-02).
- Registrasi saat ini terbuka untuk siapa saja yang bisa membuka halamannya. Setelah akun admin dibuat, sebaiknya route `/registrasi` dinonaktifkan atau dibatasi.
