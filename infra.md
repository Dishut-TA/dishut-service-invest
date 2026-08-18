# Pemetaan Infrastruktur File API (service-invest)

Berdasarkan fitur dan prosedur yang ada, berikut adalah rancangan pemetaan file untuk 4 layer utama (Controller, FormRequest, API Resource, dan Service) yang akan kita bangun:

## 1. Controllers (Layer HTTP / Routing)
Bertugas menerima request dari API dan mengembalikan response.

- `app/Http/Controllers/Api/ProgramInvestasiController.php` (KTH membuat program, Investor melihat katalog)
- `app/Http/Controllers/Api/VerifikasiProgramController.php` (Staff & Kepala BUPM memverifikasi/menyetujui program)
- `app/Http/Controllers/Api/PendanaanController.php` (Investor melakukan pendanaan)
- `app/Http/Controllers/Api/LaporanProyekController.php` (KTH lapor progress, BUPM memverifikasi)
- `app/Http/Controllers/Api/LaporanKeuanganController.php` (KTH lapor keuangan, BUPM memverifikasi)
- `app/Http/Controllers/Api/PenarikanDividenController.php` (Investor menarik dana keuntungan)
- `app/Http/Controllers/Api/WalletController.php` (Melihat saldo E-Wallet KTH & Saldo Dividen Investor)

---

## 2. FormRequests (Layer Validasi)
Bertugas memastikan payload/body dari request HTTP valid sebelum masuk ke Controller.

- `app/Http/Requests/StoreProgramInvestasiRequest.php` (Validasi input KTH, termasuk array milestone & dokumen)
- `app/Http/Requests/VerifyProgramRequest.php` (Validasi input Staff BUPM: status & catatan)
- `app/Http/Requests/StorePendanaanRequest.php` (Validasi nominal pendanaan vs sisa target dana)
- `app/Http/Requests/StoreLaporanProyekRequest.php` (Validasi deskripsi dan bukti foto)
- `app/Http/Requests/VerifyLaporanRequest.php` (Validasi persetujuan laporan)
- `app/Http/Requests/StoreLaporanKeuanganRequest.php` (Validasi angka pendapatan, pengeluaran, dll)
- `app/Http/Requests/StorePenarikanRequest.php` (Validasi rekening tujuan & nominal)

---

## 3. API Resources (Layer Output/Presentasi JSON)
Bertugas membentuk struktur JSON yang rapi, menyembunyikan data sensitif, dan me-load relasi.

- `app/Http/Resources/ProgramInvestasiResource.php` (Menampilkan detail program beserta persentase dana terkumpul)
- `app/Http/Resources/ProgramInvestasiCollection.php` (Untuk list katalog dengan pagination)
- `app/Http/Resources/TransaksiPendanaanResource.php`
- `app/Http/Resources/LaporanProyekResource.php`
- `app/Http/Resources/LaporanKeuanganResource.php`
- `app/Http/Resources/WalletResource.php` (Bisa dipakai KTH / Investor)
- `app/Http/Resources/MutasiWalletResource.php`
- `app/Http/Resources/PenarikanDividenResource.php`

---

## 4. Services / Actions (Layer Business Logic)
Bertugas menangani logika yang kompleks agar Controller tetap tipis (*Clean Controller*). Transaksi database yang rumit wajib masuk ke sini.

- `app/Services/ProgramInvestasiService.php` 
  *(Menangani logic insert ke tabel program, milestone, dan dokumen sekaligus dalam 1 Database Transaction).*
- `app/Services/PendanaanService.php` 
  *(Menangani logic jika pendanaan sukses -> tambah `dana_terkumpul` di program -> insert log mutasi -> tambah saldo `kth_wallet`).*
- `app/Services/DividenCalculatorService.php` 
  *(Menangani logic pembagian 60:40 jika laporan keuangan di-acc, lalu mendistribusikan recehan saldo ke masing-masing `investor_dividen_wallet` sesuai persentase kepemilikan).*
- `app/Services/PenarikanService.php`
  *(Mengecek saldo dividen investor cukup atau tidak sebelum ditarik, serta memotong saldonya).*
