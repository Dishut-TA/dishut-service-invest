# PRODUCT REQUIREMENTS DOCUMENT (PRD)
## MODUL TRANSPARANSI DAN MANAJEMEN INVESTASI

**Versi Dokumen:** 1.0  
**Status:** Final / Ready for Dev  
**Tanggal:** 3 Agustus 2026  

---

# 1. OVERVIEW PRODUK

## 1.1 Nama Sistem
Modul Transparansi dan Manajemen Investasi SIGAP JABAR

## 1.2 Latar Belakang
Pengelolaan program investasi hijau dan rehabilitasi hutan oleh Kelompok Tani Hutan (KTH) saat ini membutuhkan sistem yang terstruktur, transparan, dan terukur. Investor memerlukan kejelasan informasi* mengenai proyek, penggunaan dana, kemajuan lapangan, serta perhitungan bagi hasil keuntungan yang akurat dan otomatis.

Platform SIGAP Jabar hadir untuk menjembatani KTH, Investor, CSR, serta pihak regulator/pengawas (BUPM & PDAS). Modul Transparansi dan Manajemen Investasi ini dikembangkan untuk mengotomatisasi pengajuan program, pencatatan transaksi, penyaluran dana via E-Wallet, pelaporan perkembangan proyek, pelaporan keuangan, hingga pembagian dividen hasil investasi secara transparan dan akuntabel.

---

# 2. TUJUAN SISTEM

## 2.1 Tujuan Utama
Membangun modul investasi dan transparansi keuangan digital yang akuntabel untuk menghubungkan KTH dengan Investor, serta memfasilitasi verifikasi berjenjang oleh Staff BUPM dan Kepala BUPM.

## 2.2 Tujuan Khusus
- Memfasilitasi pengajuan program investasi secara mandiri dan terstruktur oleh KTH.
- Menyediakan mekanisme verifikasi dan persetujuan bertingkat (Staff BUPM & Kepala BUPM) guna menjamin validitas program.
- Menyediakan fasilitas pendanaan bagi Investor beserta pencatatan mutasi transaksi dan E-Wallet secara real-time.
- Menyediakan transparansi pelaksanaan proyek melalui Laporan Proyek (Milestone, Dokumentasi) dan Laporan Keuangan (Pendapatan, Pengeluaran, Laba Bersih).
- Mengotomatisasi kalkulasi dan distribusi pembagian keuntungan (dividen) kepada Investor dan KTH (skema 60% KTH: 40% Investor).

---

# 3. TARGET PENGGUNA

| Aktor / Pengguna | Peran & Tanggung Jawab Utama |
| :--- | :--- |
| **Investor** | Melakukan pendaftaran/login, mendanai program investasi, memantau laporan proyek & keuangan, serta melakukan penarikan saldo keuntungan. |
| **Kelompok Tani Hutan (KTH)** | Mengajukan program investasi, melaksanakan program, serta membuat laporan berkala (proyek & keuangan). |
| **Staff BUPM** | Memeriksa kelengkapan administrasi program investasi, memverifikasi laporan proyek, serta memverifikasi laporan keuangan KTH. |
| **Kepala BUPM** | Melakukan tinjauan akhir dan memberikan persetujuan (*approval*) resmi terhadap program investasi yang diajukan agar berstatus Active. |

---

# 4. KONSEP PRODUK

## 4.1 Konsep Umum
Sistem ini beroperasi berbasis web dengan aliran data terintegrasi antara modul pendaftaran, pendanaan, dompet digital (E-Wallet), pelaporan lapangan, dan kalkulasi otomatis. Setiap pengajuan program investasi oleh KTH melewati dua tahap filter (Verifikasi Staff BUPM dan Persetujuan Kepala BUPM) sebelum dipublikasikan ke katalog Investor. Pembagian bagi hasil dilakukan otomatis oleh sistem setelah Laporan Keuangan Diverifikasi.

---

# 5. FITUR UTAMA SISTEM

## 5.1 Registrasi & Autentikasi Investor
**Fungsi & Fitur Utama:**
- Form pendaftaran akun Investor (Nama, Email, No. Telepon, No. Rekening, Alamat).
- Autentikasi Login aman dan pengelolaan sesi akun.
- Dashboard khusus Investor untuk memantau portofolio pendanaan dan total keuntungan.

## 5.2 Pengajuan & Verifikasi Program Investasi
**Fungsi & Fitur Utama:**
- **Pengajuan KTH:** Input Cover, Nama Investasi, Target Funding, % Keuntungan, Batas Waktu, Deskripsi, Milestone, Dokumen Perjanjian, Bisnis Plan, dan Template Perjanjian.
- **Verifikasi Staff BUPM:** Pemeriksaan data dengan keluaran status `REVISI` atau `MENUNGGU PERSETUJUAN KEPALA BUPM`.
- **Persetujuan Kepala BUPM:** Review akhir dengan keluaran status `ACTIVE` (otomatis tayang di katalog investor).

## 5.3 Pendanaan & E-Wallet KTH
**Fungsi & Fitur Utama:**
- Katalog investasi aktif bagi Investor dengan kalkulator estimasi imbal hasil.
- Pembayaran pendanaan terintegrasi dengan verifikasi otomatis/manual.
- **E-Wallet KTH:** Dana pendanaan otomatis masuk ke Dompet Dana KTH setelah transaksi berhasil.
- Penarikan Dana KTH untuk operasional pelaksanaan proyek di lapangan.

## 5.4 Pelaporan Proyek & Keuangan
**Fungsi & Fitur Utama:**
- **Laporan Proyek:** KTH mengunggah foto kegiatan, milestone, dan status capaian. Diverifikasi oleh Staff BUPM.
- **Laporan Keuangan:** KTH menginput Pendapatan, Pengeluaran, dan Laba Bersih per periode. Diverifikasi oleh Staff BUPM.

## 5.5 Kalkulasi Keuntungan Otomatis & Penarikan Dividen
**Fungsi & Fitur Utama:**
- Sistem mengambil Laba Bersih yang telah terverifikasi, lalu membagi sesuai rasio (60% KTH: 40% Investor).
- Keuntungan Investor dibagikan secara proporsional berdasarkan persentase kepemilikan modal masing-masing.
- Kredit otomatis ke Saldo Keuntungan Investor tanpa perlu pengajuan klaim manual.
- Penarikan Saldo Keuntungan oleh Investor ke rekening bank terdaftar.

---


# 7. KONSEP USER INTERFACE (UI)

## 7.1 Gaya Visual & Palet Warna
Visual mengusung tema *Modern Industrial Dashboard & Clean Green Investment* yang memberikan kesan profesional, aman, dan ramah lingkungan.

- **Primary:** `#0F172A` (Deep Slate)
- **Secondary:** `#334155` (Slate)
- **Accent:** `#10B981` (Emerald)
- **Warning:** `#F59E0B` (Amber)
- **Danger:** `#EF4444` (Red)

## 7.2 Tipografi & Layout
- **Font Utama:** Inter / Helvetica Neue (Bersih, modern, dan sangat nyaman dibaca pada tabel data).
- **Layout:** Sidebar di sebelah kiri untuk navigasi utama, Topbar berisi profil, notifikasi, dan status peran, serta Main Content menggunakan sistem grid responsif.

---

# 8. RANCANGAN HALAMAN (MOCKUP GUIDELINES)

## 8.1 Landing Page & Detail Investasi
- **Landing Page / Explore:** Menampilkan banner pendorong investasi hijau, statistik platform, dan kartu katalog program investasi aktif.
- **Detail Program Investasi:** Menampilkan foto proyek, indikator progress dana terkumpul, target dana, persentase keuntungan, periode kontrak, dokumen legalitas, dan tombol "Investasi Sekarang".

## 8.2 Form Pengajuan Program (Multi-Step Form)
- **Step 1 (Informasi Dasar):** Upload Cover, Nama Program, Lokasi, Target Dana, Batas Waktu, Deskripsi.
- **Step 2 (Milestone & Legalitas):** Input tahapan proyek, upload dokumen perjanjian, template kontrak, dan rencana bisnis.
- **Step 3 (Metode & Konfirmasi):** Setting nomor rekening penampung KTH dan konfirmasi akhir pengajuan.

## 8.3 Dashboard Investor & Isi Saldo
- **Dashboard Investor:** Ringkasan total pendanaan, total keuntungan terkumpul, daftar portofolio aktif, dan grafik pertumbuhan modal.
- **Form Isi Saldo / Pendanaan:** Input nominal investasi, estimasi bagi hasil otomatis, detail metode pembayaran/transfer, dan unggah bukti transaksi.

## 8.4 Laporan Proyek & Laporan Keuangan Detail
- **Halaman Laporan Proyek:** Tabel laporan perkembangan fisik, milestone terlampaui, galeri foto dokumentasi lapangan, dan status verifikasi BUPM.
- **Halaman Laporan Keuangan:** Rincian komponen Pendapatan, Pengeluaran, Laba Bersih, alokasi bagi hasil, serta bukti lampiran nota transaksi.


# 11. STRUKTUR BASIS DATA (ERD REFERENCES)

Berdasarkan rancangan *Entity Relationship Diagram* (ERD), tabel-tabel utama yang menyusun modul ini adalah:
- **`USERS`:** Menyimpan data identitas akun dasar dan *role* (Investor, KTH, Staff BUPM, Kepala BUPM, CSR).
- **`INVESTOR`:** Detail profil investor (`nama_investor`, `alamat`, `no_telepon`, `no_rekening`).
- **`KTH`:** Detail Kelompok Tani Hutan (`nama`, `koordinator`, `jumlah_anggota`, `no_rekening`).
- **`PROGRAM_INVESTASI`:** Menyimpan data proyek (`nama_program`, `kategori_usaha`, `dana_target`, `dana_terkumpul`, `persentase_keuntungan`, `periode_kontrak`, `status`).
- **`TRANSAKSI_INVESTOR`:** Pencatatan pendanaan (`tanggal_investasi`, `nominal`, `persentase_kepemilikan`, `status`).
- **`MILESTONE` & `DOKUMEN`:** Rincian tahapan kerja dan berkas legalitas/rencana bisnis.
- **`LAPORAN_PROYEK` & `LAPORAN_KEUANGAN`:** Pelaporan berkala fisik dan finansial (`total_pemasukan`, `total_pengeluaran`, `laba_bersih`, `dividen_investor`, `status`).
- **`KEUNTUNGAN_INVESTOR` & `PENARIKAN_INVESTASI`:** Pencatatan hasil bagi dividen dan mutasi pencairan dana.

---

# 12. ALUR SISTEM (BUSINESS PROCESS FLOW)

1. **Registrasi & Login:** Investor mendaftar dan masuk ke dashboard.
2. **Pengajuan Program:** KTH menginput data & dokumen program investasi. Status: `Menunggu Verifikasi Staff BUPM`.
3. **Verifikasi Staff BUPM:** Staff mengecek kelengkapan. Jika valid → Status: `Menunggu Persetujuan Kepala BUPM`.
4. **Persetujuan Kepala BUPM:** Kepala BUPM me-review dan menyetujui → Status: `Active` (tayang publik).
5. **Pendanaan Investor:** Investor memilih program, memasukkan nominal, dan melakukan pembayaran.
6. **Dana Masuk E-Wallet:** Verifikasi sistem menambah saldo E-Wallet KTH untuk operasional proyek.
7. **Pelaksanaan & Pelaporan:** KTH melaksanakan proyek dan mengunggah Laporan Proyek & Keuangan.
8. **Verifikasi Laporan:** Staff BUPM memverifikasi laporan keuangan & laba bersih.
9. **Pembagian Keuntungan Otomatis:** Sistem menghitung bagi hasil (60% KTH: 40% Investor) dan mengkreditkan ke Saldo Keuntungan Investor secara otomatis.
10. **Penarikan Keuntungan:** Investor melakukan penarikan saldo dividen ke rekening pribadi.

---

# 13. NON-FUNCTIONAL REQUIREMENTS

- **Performa:** Waktu muat halaman dashboard dan pencarian katalog < 2 detik.
- **Keamanan Data:** Enkripsi data sensitif (password, no. rekening), perlindungan terhadap SQL Injection, XSS, dan CSRF.
- **Transparansi & Akuntabilitas:** Semua log transaksi dan pelaporan *audit-trail* tersimpan secara permanen dan tidak dapat diubah (*immutable log*).
- **Skalabilitas:** Arsitektur REST API mendukung integrasi masa depan dengan aplikasi mobile atau *payment gateway* eksternal.

---

# 14. PRIORITAS MVP (MINIMUM VIABLE PRODUCT)

## 14.1 Wajib Ada (Must Have)
- Manajemen Akun & Auth (Investor, KTH, BUPM).
- Pengajuan & Verifikasi 2-Tingkat Program Investasi (Staff & Kepala BUPM).
- Katalog Program Investasi & Alur Pendanaan Investor.
- E-Wallet KTH & Pencatatan Mutasi Transaksi.
- Modul Pelaporan Proyek & Pelaporan Keuangan.
- Kalkulasi & Distribusi Otomatis Keuntungan (60% KTH: 40% Investor).

## 14.2 Pengembangan Tahap Berikutnya (Nice to Have)
- Integrasi Payment Gateway Otomatis (Virtual Account / QRIS).
- Notifikasi Push Real-Time via WhatsApp/Email.
- Analitik Prediktif AI untuk Risiko Usaha KTH.
- Aplikasi Mobile Native (Android / iOS).

---

# 15. TARGET HASIL DEMO

Pada saat pengujian/demo produk, *stakeholders* dan penguji dapat:
- Melihat alur lengkap dari pendaftaran investor hingga memilih program investasi hijau.
- Simulasi KTH mengunggah pengajuan program dan melihat proses verifikasi berjenjang BUPM secara *real-time*.
- Melihat dana masuk ke E-Wallet KTH setelah pendanaan berhasil.
- Simulasi penginputan Laporan Keuangan dan mengamati kalkulasi pembagian keuntungan 60:40 berjalan secara otomatis.
- Melihat saldo keuntungan bertambah pada akun Investor dan melakukan simulasi penarikan dana.
