# Alur Prosedur (Business Process Flow)

Berdasarkan dokumen PRD Modul Transparansi dan Manajemen Investasi SIGAP JABAR, berikut adalah alur prosedur sistem:

1. **Registrasi & Login**
   Investor mendaftar dan masuk ke dashboard.

2. **Pengajuan Program**
   KTH menginput data & dokumen program investasi. 
   *Status: `Menunggu Verifikasi Staff BUPM`.*

3. **Verifikasi Staff BUPM**
   Staff mengecek kelengkapan administrasi program. 
   *Jika valid → Status: `Menunggu Persetujuan Kepala BUPM`.*

4. **Persetujuan Kepala BUPM**
   Kepala BUPM me-review dan memberikan persetujuan resmi. 
   *Status: `Active` (tayang di katalog publik untuk investor).*

5. **Pendanaan Investor**
   Investor memilih program, memasukkan nominal pendanaan, dan melakukan pembayaran.

6. **Dana Masuk E-Wallet**
   Verifikasi sistem menambah saldo E-Wallet KTH untuk operasional pelaksanaan proyek di lapangan.

7. **Pelaksanaan & Pelaporan**
   KTH melaksanakan proyek sesuai milestone dan mengunggah Laporan Proyek (dokumentasi lapangan) & Laporan Keuangan secara berkala.

8. **Verifikasi Laporan**
   Staff BUPM memverifikasi laporan proyek, laporan keuangan & keabsahan laba bersih.

9. **Pembagian Keuntungan Otomatis**
   Sistem menghitung bagi hasil berdasarkan laporan keuangan yang telah diverifikasi (Rasio 60% KTH : 40% Investor) dan mengkreditkan ke Saldo Keuntungan Investor secara otomatis.

10. **Penarikan Keuntungan (Dividen)**
    Investor melakukan penarikan saldo dividen ke rekening pribadi.
