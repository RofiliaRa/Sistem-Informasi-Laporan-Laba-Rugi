# DOKUMENTASI REVISI STRUKTUR LAPORAN LABA RUGI & LAPORAN MUTASI KAS (2 TAB)

### Unit Usaha Fotokopi Jayadirana — BUM Desa Kalitinggar Makmur

---

## 📋 1. Pendahuluan & Latar Belakang

Dokumen ini disusun sebagai panduan teknis dan operasional untuk melakukan **revisi perancangan ulang (redesign)** pada modul **Laporan Laba Rugi** dan **Laporan Mutasi Saldo Kas** di Sistem Informasi Laporan Laba Rugi Unit Usaha Fotokopi Jayadirana.

Berdasarkan kebutuhan antarmuka (UI/UX) dan standar akuntansi, halaman laporan disajikan dalam **2 Tab Navigasi Terpisah**:

1. **Tab 1: Laporan Laba Rugi** (Format Multi-Step baku SAK sesuai sampel gambar rujukan).
2. **Tab 2: Laporan Mutasi & Total Kas Tersedia** (Menampilkan Modal Tahunan BUM Desa, Akumulasi Kas Periode Sebelumnya, Tambahan Laba Bersih, dan Total Kas Akhir).

---

## 🎯 2. Perbandingan & Struktur 2 Tab

| Komponen               | Tab 1: Laporan Laba Rugi                                                                                                                                                                          | Tab 2: Mutasi & Total Kas Tersedia                                                              |
| :--------------------- | :------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ | :---------------------------------------------------------------------------------------------- |
| **Fokus Utama**        | Mengukur kinerja operasional & profitabilitas usaha                                                                                                                                               | Memantau kecukupan & fisik uang kas riil unit usaha                                             |
| **Metode Perhitungan** | Multi-Step: Pendapatan $\rightarrow$ HPP $\rightarrow$ Laba Kotor $\rightarrow$ Beban Usaha $\rightarrow$ Laba Usaha $\rightarrow$ Laba Sebelum Pajak $\rightarrow$ PPh $\rightarrow$ Laba Bersih | Mutasi Kas: Modal Tahunan BUM Desa + Akumulasi Kas Periode Sebelumnya + Laba Bersih Periode Ini |
| **Komponen Data**      | Rincian Pendapatan, HPP (Stok Awal/Akhir), dan Beban Operasional                                                                                                                                  | Modal Awal Tahun, Saldo Kas Lalu, Laba Bersih, Total Kas Akhir                                  |
| **Elemen UI**          | Nav-Tab 1: Bootstrap Tab "Laporan Laba Rugi"                                                                                                                                                      | Nav-Tab 2: Bootstrap Tab "Mutasi & Saldo Kas"                                                   |

---

## 📊 3. Spesifikasi Tampilan & Hirarki per Tab

### 🔷 TAB 1: LAPORAN LABA RUGI

```text
LAPORAN LABA RUGI
PERIODE PER [TANGGAL / BULAN / TAHUN]

Pendapatan Usaha
  Pendapatan Jasa ........................................... Rp xxx.xxx
  Pendapatan ATK dan Lain-Lain ............................... Rp xxx.xxx
Total Pendapatan ............................................ Rp xxx.xxx

Harga Pokok Penjualan (HPP)
  Persediaan Awal ........................................... Rp xxx.xxx
  Pembelian ................................................. Rp xxx.xxx
  Persediaan Akhir .......................................... (Rp xxx.xxx)
Total Harga Pokok Penjualan ................................. Rp xxx.xxx
Laba Kotor .................................................. Rp xxx.xxx

Beban Usaha
  Beban Pembelian Barang .................................... Rp xxx.xxx
  Beban Operasional :
    Beban Upah Pekerja ...................................... Rp xxx.xxx
    Beban Listrik ........................................... Rp xxx.xxx
    Beban Internet .......................................... Rp xxx.xxx
Total Beban Usaha ........................................... Rp xxx.xxx
Laba Usaha .................................................. Rp xxx.xxx

Pendapatan Di Luar Usaha
  Pendapatan Bunga .......................................... Rp xxx.xxx
Laba Bersih Sebelum Pajak ................................... Rp xxx.xxx
PPh ......................................................... Rp xxx.xxx
Laba Bersih Setelah Pajak ................................... Rp xxx.xxx
```

---

### 🔷 TAB 2: LAPORAN MUTASI & TOTAL KAS TERSEDIA

```text
LAPORAN MUTASI & TOTAL KAS TERSEDIA
PERIODE PER [TANGGAL / BULAN / TAHUN]

Sumber Kas Awal Periode:
  1. Modal Disetor / Modal Awal Tahun BUM Desa .............. Rp xxx.xxx
  2. Akumulasi Saldo Kas Periode Sebelumnya .................. Rp xxx.xxx
Total Saldo Kas Awal Periode ................................. Rp xxx.xxx

Mutasi Hasil Operasional Periode Ini:
  + Laba / (Rugi) Bersih Periode Ini (dari Tab 1) ........... Rp xxx.xxx

-------------------------------------------------------------------------
TOTAL KAS TERSEDIA (SALDO KAS AKHIR PERIODE) ................. Rp xxx.xxx
=========================================================================
```

### 📐 Formulasi Matematika Akuntansi & Kas:

#### Tab 1 (Laba Rugi):

1. $$\text{Total Pendapatan} = \text{Pendapatan Jasa} + \text{Pendapatan ATK dan Lain-Lain}$$
2. $$\text{Total HPP} = \text{Persediaan Awal} + \text{Pembelian} - \text{Persediaan Akhir}$$
3. $$\text{Laba Kotor} = \text{Total Pendapatan} - \text{Total HPP}$$
4. $$\text{Total Beban Usaha} = \text{Beban Pembelian Barang} + \text{Beban Upah} + \text{Beban Listrik} + \text{Beban Internet}$$
5. $$\text{Laba Usaha} = \text{Laba Kotor} - \text{Total Beban Usaha}$$
6. $$\text{Laba Sebelum Pajak} = \text{Laba Usaha} + \text{Pendapatan Di Luar Usaha}$$
7. $$\text{Laba Bersih Setelah Pajak} = \text{Laba Sebelum Pajak} - \text{PPh}$$

#### Tab 2 (Mutasi Kas):

8. $$\text{Total Saldo Kas Awal} = \text{Modal Tahunan BUM Desa} + \text{Akumulasi Saldo Kas Periode Sebelumnya}$$
9. $$\text{Total Kas Akhir Periode} = \text{Total Saldo Kas Awal} + \text{Laba Bersih Setelah Pajak (dari Tab 1)}$$

---

## 🛠️ 4. Rencana Implikasi Teknis & Interface (2 Tab)

### A. Tampilan Navigasi Tab (`index.blade.php`)

Menggunakan komponen **Bootstrap 5 Nav Tabs**:

```html
<ul
    class="nav nav-tabs custom-laporan-tabs mb-4"
    id="laporanTab"
    role="tablist"
>
    <li class="nav-item" role="presentation">
        <button
            class="nav-link active fw-bold"
            id="laba-rugi-tab"
            data-bs-toggle="tab"
            data-bs-target="#laba-rugi"
            type="button"
            role="tab"
        >
            <i class="bi bi-file-text me-2"></i>Laporan Laba Rugi
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button
            class="nav-link fw-bold"
            id="mutasi-kas-tab"
            data-bs-toggle="tab"
            data-bs-target="#mutasi-kas"
            type="button"
            role="tab"
        >
            <i class="bi bi-wallet2 me-2"></i>Mutasi & Total Kas Tersedia
        </button>
    </li>
</ul>

<div class="tab-content" id="laporanTabContent">
    <div class="tab-pane fade show active" id="laba-rugi" role="tabpanel">
        <!-- Konten Tab 1: Laporan Laba Rugi -->
    </div>
    <div class="tab-pane fade" id="mutasi-kas" role="tabpanel">
        <!-- Konten Tab 2: Mutasi & Total Kas Tersedia -->
    </div>
</div>
```

### B. Database & Schema Migration

Atribut pendukung pada tabel `laporans`:

- `modal_tahunan` (decimal 15,2) — Modal disetor BUM Desa tahun berjalan.
- `saldo_kas_awal` (decimal 15,2) — Akumulasi kas bulan-bulan sebelumnya.
- `persediaan_awal` (decimal 15,2)
- `persediaan_akhir` (decimal 15,2)
- `hpp` (decimal 15,2)
- `laba_kotor` (decimal 15,2)
- `laba_usaha` (decimal 15,2)
- `pendapatan_non_usaha` (decimal 15,2)
- `pph` (decimal 15,2)
- `laba_bersih_setelah_pajak` (decimal 15,2)
- `total_kas_akhir` (decimal 15,2) — Saldo kas riil di akhir bulan.

### C. Logic Controller (`LaporanController.php`)

- Menghitung variabel Laba Rugi untuk Tab 1.
- Menghitung akumulasi kas modal tahunan + saldo bulan lalu + laba bersih periode ini untuk Tab 2.
- Menyiapkan data untuk kedua tab dalam satu panggil view.

---

## 🧪 5. Simulasi Perhitungan Data (Contoh 2 Tab)

Misalkan pada **Tahun 2026**, BUM Desa memberikan modal usaha sebesar **Rp 50.000.000**.
Akumulasi saldo kas s.d. **Juli 2026** adalah **Rp 12.000.000**.

### 🔹 Hasil Perhitungan TAB 1 (Laporan Laba Rugi Agustus 2026):

- Total Pendapatan: Rp 11.700.000
- Total HPP: Rp 2.700.000
- **Laba Kotor:** Rp 9.000.000
- Total Beban Usaha: Rp 3.200.000
- **Laba Usaha:** Rp 5.800.000
- Pendapatan Bunga: Rp 50.000
- PPh: Rp 50.000
- **Laba Bersih Setelah Pajak (Agustus 2026): Rp 5.800.000**

### 🔹 Hasil Perhitungan TAB 2 (Mutasi & Total Kas Tersedia Akhir Agustus 2026):

- Modal Awal Tahun 2026: Rp 50.000.000
- Akumulasi Saldo Kas s.d. Juli 2026: Rp 12.000.000
    - $\Rightarrow \mathbf{\text{Total Saldo Kas Awal} = \text{Rp } 62.000.000}$
- Laba Bersih Agustus 2026 (dari Tab 1): + Rp 5.800.000
    - $\Rightarrow \mathbf{\text{TOTAL KAS TERSEDIA PER AKHIR AGUSTUS 2026} = \text{Rp } 67.800.000}$

---

## 📌 6. Kesimpulan & Langkah Selanjutnya

Penggunaan 2 Tab ini merupakan solusi UI/UX terbaik karena memisahkan kinerja operasional (Laba Rugi) dengan posisi keuangan kas riil secara rapi dan profesional.

Langkah pengerjaan berikutnya yang direkomendasikan:

1. Pembaruan migrasi database (`laporans`).
2. Pembaruan controller (`LaporanController.php`).
3. Pembuatan struktur 2 Tab di `index.blade.php`.
4. Pembaruan cetakan PDF DomPDF & Excel Export.
