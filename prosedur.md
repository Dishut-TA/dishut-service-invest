# Alur Prosedur (Business Process Flow)

Berdasarkan dokumen PRD Modul Transparansi dan Manajemen Investasi SIGAP JABAR, berikut adalah alur prosedur khusus untuk **service-invest**.
*(Catatan: Autentikasi dan Manajemen User seperti Registrasi & Login ditangani oleh microservice terpisah yaitu `service-user`).*

1. **Pengajuan Program Investasi**
   KTH menginput data & dokumen program investasi. 
   *Status: `Menunggu Verifikasi Staff BUPM`.*

2. **Verifikasi Staff BUPM**
   Staff mengecek kelengkapan administrasi program. 
   *Jika valid → Status: `Menunggu Persetujuan Kepala BUPM`.*

3. **Persetujuan Kepala BUPM**
   Kepala BUPM me-review dan memberikan persetujuan resmi. 
   *Status: `Active` (tayang di katalog publik untuk investor).*

4. **Pendanaan oleh Investor**
   Investor memilih program, memasukkan nominal pendanaan, dan melakukan pembayaran.

5. **Dana Masuk E-Wallet KTH**
   Verifikasi sistem menambah saldo E-Wallet KTH untuk operasional pelaksanaan proyek di lapangan.

6. **Pelaksanaan & Pelaporan Proyek**
   KTH melaksanakan proyek sesuai milestone dan mengunggah Laporan Proyek (dokumentasi lapangan) & Laporan Keuangan secara berkala.

7. **Verifikasi Laporan**
   Staff BUPM memverifikasi laporan proyek, laporan keuangan & keabsahan laba bersih.

8. **Pembagian Keuntungan Otomatis**
   Sistem menghitung bagi hasil berdasarkan laporan keuangan yang telah diverifikasi (Rasio 60% KTH : 40% Investor) dan mengkreditkan ke Saldo Keuntungan Investor secara otomatis.

9. **Penarikan Keuntungan (Dividen)**
   Investor melakukan penarikan saldo dividen ke rekening pribadi.
