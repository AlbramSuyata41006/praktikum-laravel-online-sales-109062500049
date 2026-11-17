# 🛒 Laravel Online Sales (E-Commerce Application)

Aplikasi Penjualan Online (E-Commerce) berbasis Laravel dengan arsitektur Multi-Role, Manajemen Inventaris, Shopping Cart, Proses Checkout Transaksional, dan Validasi Pesanan.

Proyek ini dibangun sebagai bentuk pemenuhan Tugas Praktikum Pengembangan Aplikasi Website. Pengembangan dilakukan menggunakan metode *Version Control* (Git) yang terstruktur dan dibagi ke dalam 9 Milestone (M0 - M8).

## ✨ Fitur Utama

### 👥 Multi-Role Authentication
- **Admin:** Memiliki akses ke Dashboard, Manajemen Kategori, Produk, Stok, Ekspedisi, dan Validasi Transaksi.
- **Customer:** Dapat melihat katalog, memasukkan barang ke keranjang, checkout, dan melihat riwayat pesanan.
- Dilengkapi dengan Custom Middleware (`RoleMiddleware`) untuk keamanan rute.

### 📦 Manajemen Inventaris & Produk (Admin)
- Operasi CRUD untuk Kategori dan Produk.
- Mendukung fitur unggah gambar yang terintegrasi dengan `public/storage`.
- **Pencatatan Audit Stok (Stock Movements):** Setiap stok yang masuk (IN) dan keluar (OUT) terekam secara sistematis. Admin tidak dapat merubah stok secara bebas melalui form produk demi menjaga jejak audit.

### 🛍️ Etalase Pelanggan & Keranjang Belanja
- Katalog publik dilengkapi dengan fitur **Pencarian**, **Filter Multi-Kriteria** (Kategori, Harga, Ketersediaan), dan **Sorting**.
- *Shopping Cart* (Keranjang Belanja) dibangun dengan memanfaatkan fitur `Session` yang aman.

### 💳 Checkout & Manajemen Pesanan
- **Database Transaction & Pessimistic Locking (`lockForUpdate`):** Mencegah terjadinya *overselling* ketika dua pelanggan melakukan checkout pada produk dan waktu yang bersamaan.
- **Snapshot Transaksi:** Menyimpan snapshot harga dan nama produk pada tabel `order_items` untuk menjaga validitas riwayat transaksi di masa depan.
- **Workflow Status Pesanan:** Alur validasi ketat oleh Admin (`pending` -> `confirmed` -> `processed` -> `shipped` -> `completed`).
- **Stock Rollback:** Sistem secara otomatis mengembalikan stok (IN) jika pesanan dibatalkan (Cancel).

## 🛠️ Tech Stack
- **Framework:** Laravel 11/12
- **Language:** PHP 8.3+
- **Database:** MySQL / MariaDB
- **Frontend:** Laravel Blade, CSS 

## 🚀 Cara Instalasi & Menjalankan Proyek Lokal

1. **Clone Repository**
   ```bash
   git clone https://github.com/AlbramSuyata41006/praktikum-laravel-online-sales-109062500049.git
   cd praktikum-laravel-online-sales-109062500049
   ```

2. **Install Dependencies**
   ```bash
   composer install
   ```

3. **Konfigurasi Environment**
   - Copy file `.env.example` menjadi `.env`.
   - Sesuaikan konfigurasi database Anda di dalam file `.env`:
     ```env
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=laravel_online_sales
     DB_USERNAME=root
     DB_PASSWORD=
     ```

4. **Generate Application Key & Storage Link**
   ```bash
   php artisan key:generate
   php artisan storage:link
   ```

5. **Jalankan Migrasi & Database Seeder**
   *Penting: Langkah ini akan membuat tabel dan menyuntikkan data awal (Akun Admin, Ekspedisi, dan Produk).*
   ```bash
   php artisan migrate --seed
   ```

6. **Jalankan Server Lokal**
   ```bash
   php artisan serve
   ```
   Akses aplikasi di `http://127.0.0.1:8000`

## 🔐 Akun Default (Testing)

Untuk keperluan pengujian, gunakan kredensial berikut untuk masuk sebagai Admin:
- **Email:** `admin@example.com`
- **Password:** `Admin12345!`

*(Untuk role Customer, silakan lakukan registrasi langsung melalui menu Register pada aplikasi).*

## 🌳 Git Milestones History

Proyek ini dibangun melalui alur Git yang ketat:
- `m0-setup` : Inisialisasi proyek.
- `m1-auth-role` : Setup autentikasi dan middleware.
- `m2-master-product` : Skema dan manajemen katalog.
- `m3-inventory-shipping` : Pergerakan stok dan layanan pengiriman.
- `m4-storefront` : Halaman publik pelanggan.
- `m5-cart` : Integrasi session keranjang belanja.
- `m6-checkout` : Pembuatan order dan *locking* stok.
- `m7-order-admin` : Dashboard validasi admin.
- `m8-final` : QA dan rilis akhir.

---
**Developed with ❤️ by:**
**Albram Diazvilla Suyata** (109062500049) - 9A 
S1 Sistem Informasi - Telkom University Campus Purwokerto (2026)
