# Sistem Informasi Laporan Laba Rugi 📊

### BUM Desa Kalitinggar Makmur — Unit Usaha Fotokopi Jayadirana

Sistem Informasi Laporan Laba Rugi adalah aplikasi berbasis web yang dibangun untuk mengelola, mengkalkulasi, dan menyajikan laporan keuangan Laba Rugi secara sistematis dan akurat pada **Unit Usaha Fotokopi Jayadirana** di bawah naungan **BUM Desa Kalitinggar Makmur**.

---

## 🚀 Fitur Utama

- 🔐 **Autentikasi & Multi-Role Access**: Hak akses terpisah antara **Admin** (Pengelola Operasional) dan **Direktur** (Pimpinan/Eksekutif).
- 💰 **Manajemen Pendapatan**: Pencatatan data transaksi pendapatan harian/bulanan berdasarkan kategori (Jasa, Penjualan ATK, dan Lain-lain).
- 💸 **Manajemen Pengeluaran**: Pencatatan transaksi pengeluaran operasional (Pembelian Persediaan dan Operasional Lainnya).
- 📈 **Laporan Laba Rugi Otomatis**: Kalkulasi realtime total pendapatan, total pengeluaran, serta Laba/Rugi bersih sesuai periode bulan dan tahun yang dipilih.
- 📄 **Ekspor Dokumen (PDF & Excel)**: Cetak dan unduh lembar laporan laba rugi beserta rincian transaksinya ke dalam format **PDF (A4)** dan **Excel (.xlsx)**.
- 📌 **Status Laporan & Finalisasi**:
    - **Draft**: Laporan masih dapat disesuaikan saat transaksi bertambah.
    - **Final**: Laporan yang telah diverifikasi dan dikunci agar tidak dapat diubah lagi.
    - **Finalisasi Otomatis**: Sistem secara otomatis mengunci laporan bulan sebelumnya pada tanggal 1 bulan berikutnya.
- 📂 **Riwayat Laporan**: Arsip laporan keuangan dari bulan-bulan sebelumnya yang dapat ditinjau kembali kapan saja.
- 👥 **Manajemen Akun / Pengguna**: Pengelolaan data akun staf dan hak akses pengguna.

---

## 👤 Hak Akses Pengguna (User Roles)

| Peran (Role) | Hak Akses & Wewenang                                                                                                                                                                                                                          |
| :----------- | :-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **Admin**    | <ul><li>Input, ubah, dan hapus transaksi Pendapatan & Pengeluaran</li><li>Melihat dan memfilter Laporan Laba Rugi</li><li>Melakukan Finalisasi Laporan</li><li>Mengunduh Laporan (PDF & Excel)</li><li>Mengelola data akun pengguna</li></ul> |
| **Direktur** | <ul><li>Melihat Dashboard Ringkasan Eksekutif</li><li>Melihat & memfilter Laporan Laba Rugi</li><li>Melihat Riwayat Laporan Final</li><li>Mengunduh Laporan (PDF & Excel)</li><li>Mengelola data akun pengguna</li></ul>                      |

---

## 🛠️ Teknologi & Dependensi

- **Framework Core:** Laravel (PHP 8.2+)
- **Database:** MySQL
- **Frontend UI:** Bootstrap 5, Blade Templating Engine, Bootstrap Icons
- **Asset Bundler:** Vite
- **Package Ekspor PDF:** `barryvdh/laravel-dompdf`
- **Package Ekspor Excel:** `maatwebsite/excel`
- **Notifikasi Interactive:** SweetAlert2

---

## ⚙️ Cara Instalasi & Menjalankan Project

### 1. Prasyarat

Pastikan komputer Anda sudah terinstal:

- PHP >= 8.2
- Composer
- Node.js & NPM
- Database Server (MySQL / Laragon / XAMPP)

### 2. Langkah Instalasi

1. **Clone / Download Repository**

    ```bash
    git clone https://github.com/RofiliaRa/Sistem-Informasi-Laporan-Laba-Rugi.git
    cd Sistem-Informasi-Laporan-Laba-Rugi
    ```

2. **Install Dependensi PHP (Composer)**

    ```bash
    composer install
    ```

3. **Install Dependensi Frontend (NPM)**

    ```bash
    npm install
    ```

4. **Konfigurasi Environment (`.env`)**
   Salin `.env.example` menjadi `.env`:

    ```bash
    cp .env.example .env
    ```

    Atur koneksi database pada file `.env`:

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=db_laba_rugi
    DB_USERNAME=root
    DB_PASSWORD=
    ```

5. **Generate Application Key**

    ```bash
    php artisan key:generate
    ```

6. **Jalankan Migration & Seeder**

    ```bash
    php artisan migrate --seed
    ```

7. **Jalankan Web Server & Asset Compiler**
   Buka dua terminal terpisah:
    - Terminal 1 (Laravel Server):
        ```bash
        php artisan serve
        ```
    - Terminal 2 (Vite Compiler):
        ```bash
        npm run dev
        ```

8. Akses aplikasi melalui browser di: `http://127.0.0.1:8000`

---

## 🔑 Akun Default (Seeder)

Setelah menjalankan `php artisan migrate --seed`, Anda dapat berlogin menggunakan akun bawaan berikut:

- **Role Admin:**
    - Email: `admin@gmail.com`
    - Password: `password`
- **Role Direktur:**
    - Email: `direktur@gmail.com`
    - Password: `password`

---

## 📍 Lokasi Unit Usaha

**BUM Desa Kalitinggar Makmur — Unit Usaha Fotokopi Jayadirana**  
Desa Kalitinggar RT 01 RW 03, Karang Malang, Kec. Padamara, Kab. Purbalingga, Jawa Tengah (53372).
