<?php

use App\Http\Controllers\CutiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PengajuanTppController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerifikasiCutiController;
use App\Http\Controllers\VerifikasiTppController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RiwayatPangkatController; // <-- Import
use App\Http\Controllers\LaporanController; // <-- Import
use App\Http\Controllers\SatyalancanaController;
use App\Http\Controllers\RiwayatJabatanController;
use App\Http\Controllers\BerkasSatyalancanaController;
use App\Http\Controllers\VerifikasiSatyalancanaController;
use App\Http\Controllers\PensiunController;
use App\Http\Controllers\OpdController;       // <-- Tambahkan ini di bagian atas
use App\Http\Controllers\JabatanController;

/*

|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rute utama, langsung ke halaman login
Route::get('/', function () {
    return redirect()->route('login');
});

// Route::middleware('guest')->group(function () {
//     Route::get('register', [RegisteredUserController::class, 'create'])
//         ->name('register');
//     Route::post('register', [RegisteredUserController::class, 'store']);
// });

// Grup rute yang hanya bisa diakses setelah login
Route::middleware('auth')->group(function () {



    // --- RUTE UMUM (Semua Peran Terautentikasi) ---
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/cuti', [CutiController::class, 'index'])->name('cuti.index');
    Route::get('/cuti/create', [CutiController::class, 'create'])->name('cuti.create');
    Route::post('/cuti', [CutiController::class, 'store'])->name('cuti.store');

    Route::get('berkas-satyalancana/{satyalancana}', [BerkasSatyalancanaController::class, 'create'])
        ->name('berkas-satyalancana.create')
        ->middleware('can:lengkapi berkas satyalancana');

    // Rute untuk menyimpan berkas yang diunggah
    Route::post('berkas-satyalancana/{satyalancana}', [BerkasSatyalancanaController::class, 'store'])
        ->name('berkas-satyalancana.store')
        ->middleware('can:lengkapi berkas satyalancana');

    // Rute untuk kandidat melengkapi berkas
    Route::get('/satyalancana/{satyalancana}/lengkapi-berkas', [BerkasSatyalancanaController::class, 'show'])->name('satyalancana.berkas.show');
    Route::put('/satyalancana/{satyalancana}/lengkapi-berkas', [BerkasSatyalancanaController::class, 'update'])->name('satyalancana.berkas.update');
    Route::get('/satyalancana-saya', [SatyalancanaController::class, 'myProposals'])->name('satyalancana.my-proposals');


    // --- RUTE PEGAWAI (Hak Akses Terpisah) ---
    Route::middleware(['role:Admin|Pengelola|Kepala Bidang|Kepala OPD'])->group(function () {
        Route::get('/pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');
        Route::get('/pegawai/{pegawai}', [PegawaiController::class, 'show'])->name('pegawai.show');
    });


    Route::middleware(['role:Admin'])->group(function () {
        Route::get('/pegawai-create', [PegawaiController::class, 'create'])->name('pegawai.create');
        Route::post('/pegawai', [PegawaiController::class, 'store'])->name('pegawai.store');
        Route::get('/pegawai/{pegawai}/edit', [PegawaiController::class, 'edit'])->name('pegawai.edit');
        Route::put('/pegawai/{pegawai}', [PegawaiController::class, 'update'])->name('pegawai.update');
        Route::delete('/pegawai/delete-all', [PegawaiController::class, 'destroyAll'])->name('pegawai.destroy.all');
        Route::delete('/pegawai/{pegawai}', [PegawaiController::class, 'destroy'])->name('pegawai.destroy');
        Route::get('/pegawai-import', [PegawaiController::class, 'showImportForm'])->name('pegawai.import.form');
        Route::post('/pegawai-import', [PegawaiController::class, 'import'])->name('pegawai.import.store');
        Route::get('/opd/import', [OpdController::class, 'showImportForm'])->name('opd.import.show');
        Route::post('/opd/import', [OpdController::class, 'import'])->name('opd.import.store');
        Route::get('/import-progress', [PegawaiController::class, 'importProgress'])->name('pegawai.import.progress');
    });

    // --- RUTE TPP (Hak Akses Terpisah) ---
    Route::middleware(['role:Admin|Pengelola'])->group(function () {
        Route::get('/pengajuan-tpp/lanjutkan', [PengajuanTppController::class, 'lanjutkanKeForm'])->name('pengajuan-tpp.lanjutkan');
        Route::get('/pengajuan-tpp/buat', [PengajuanTppController::class, 'create'])->name('pengajuan-tpp.create');
        Route::post('/pengajuan-tpp', [PengajuanTppController::class, 'store'])->name('pengajuan-tpp.store');
        Route::get('/pegawai/{pegawai}/riwayat-pangkat/create', [RiwayatPangkatController::class, 'create'])->name('pegawai.riwayat.create');

        // RUTE BARU UNTUK EDIT & UPDATE RIWAYAT PANGKAT
        Route::get('/riwayat-pangkat/{riwayatPangkat}/edit', [RiwayatPangkatController::class, 'edit'])->name('riwayat-pangkat.edit');
        Route::put('/riwayat-pangkat/{riwayatPangkat}', [RiwayatPangkatController::class, 'update'])->name('riwayat-pangkat.update');

        // RUTE BARU UNTUK EDIT & UPDATE RIWAYAT JABATAN
        Route::get('/pegawai/{pegawai}/riwayat-jabatan/create', [RiwayatJabatanController::class, 'create'])->name('pegawai.riwayat-jabatan.create');
        Route::post('/pegawai/{pegawai}/riwayat-jabatan', [RiwayatJabatanController::class, 'store'])->name('pegawai.riwayat-jabatan.store');
        Route::get('/riwayat-jabatan/{riwayatJabatan}/edit', [RiwayatJabatanController::class, 'edit'])->name('riwayat-jabatan.edit');
        Route::put('/riwayat-jabatan/{riwayatJabatan}', [RiwayatJabatanController::class, 'update'])->name('riwayat-jabatan.update');
        Route::delete('/riwayat-jabatan/{riwayatJabatan}', [RiwayatJabatanController::class, 'destroy'])->name('riwayat-jabatan.destroy');

        // Rute untuk menyimpan riwayat (sudah ada)
        Route::post('/pegawai/{pegawai}/riwayat-pangkat', [RiwayatPangkatController::class, 'store'])->name('pegawai.riwayat.store');
        Route::delete('/riwayat-pangkat/{riwayatPangkat}', [RiwayatPangkatController::class, 'destroy'])->name('riwayat-pangkat.destroy');

        Route::resource('pensiun', PensiunController::class);
        Route::get('/pengajuan-tpp/{pengajuanTpp}/edit', [PengajuanTppController::class, 'edit'])->name('pengajuan-tpp.edit');
        Route::put('/pengajuan-tpp/{pengajuanTpp}', [PengajuanTppController::class, 'update'])->name('pengajuan-tpp.update');
    });
    Route::middleware(['role:Admin|Pengelola|Verifikasi TPP'])->group(function () {
        Route::get('/pengajuan-tpp', [PengajuanTppController::class, 'index'])->name('pengajuan-tpp.index');
        Route::get('/pengajuan-tpp/{pengajuanTpp}', [PengajuanTppController::class, 'show'])->name('pengajuan-tpp.show');
        // RUTE BARU UNTUK CETAK PDF
        Route::get('/pengajuan-tpp/{pengajuanTpp}/cetak', [PengajuanTppController::class, 'cetak'])->name('pengajuan-tpp.cetak');; // <-- Tambahkan ini
    });

    Route::middleware(['role:Admin|Pengelola Satyalancana'])->group(function () {
        Route::get('/usulan-satyalancana', [SatyalancanaController::class, 'index'])->name('satyalancana.index');
        Route::post('/usulan-satyalancana', [SatyalancanaController::class, 'store'])->name('satyalancana.store');
        Route::get('verifikasi-satyalancana', [VerifikasiSatyalancanaController::class, 'index'])->name('verifikasi-satyalancana.index');
        Route::get('verifikasi-satyalancana/{satyalancana}', [VerifikasiSatyalancanaController::class, 'show'])->name('verifikasi-satyalancana.show');
        Route::post('verifikasi-satyalancana/{satyalancana}/approve', [VerifikasiSatyalancanaController::class, 'approve'])->name('verifikasi-satyalancana.approve');
        Route::post('verifikasi-satyalancana/{satyalancana}/reject', [VerifikasiSatyalancanaController::class, 'reject'])->name('verifikasi-satyalancana.reject');
    });


    Route::middleware(['role:Admin|Verifikasi TPP'])->group(function () {
        Route::get('/verifikasi-tpp', [VerifikasiTppController::class, 'index'])->name('verifikasi-tpp.index');
        Route::get('/verifikasi-tpp/{pengajuanTpp}', [VerifikasiTppController::class, 'show'])->name('verifikasi-tpp.show');
        Route::post('/verifikasi-tpp/{pengajuanTpp}/setujui', [VerifikasiTppController::class, 'approve'])->name('verifikasi-tpp.approve');
        Route::post('/verifikasi-tpp/{pengajuanTpp}/tolak', [VerifikasiTppController::class, 'reject'])->name('verifikasi-tpp.reject');
        Route::patch('/verifikasi-tpp/{pengajuanTpp}/update-besaran', [VerifikasiTppController::class, 'updateBesaran'])->name('verifikasi-tpp.update-besaran');
    });



    // --- RUTE VERIFIKASI CUTI (Hak Akses Atasan) ---
    Route::middleware(['role:Admin|Kepala Bidang|Kepala OPD'])->group(function () {
        Route::get('/verifikasi-cuti', [VerifikasiCutiController::class, 'index'])->name('verifikasi-cuti.index');
        Route::get('/verifikasi-cuti/{cuti}', [VerifikasiCutiController::class, 'show'])->name('verifikasi-cuti.show');
        Route::post('/verifikasi-cuti/{cuti}/approve', [VerifikasiCutiController::class, 'approve'])->name('verifikasi-cuti.approve');
        Route::post('/verifikasi-cuti/{cuti}/reject', [VerifikasiCutiController::class, 'reject'])->name('verifikasi-cuti.reject');
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/duk/cetak', [LaporanController::class, 'cetakDuk'])->name('laporan.duk.cetak');
        Route::get('/laporan/rekapitulasi-jabatan', [LaporanController::class, 'cetakRekapitulasiJabatan'])->name('laporan.rekapitulasi.jabatan');
        Route::get('/laporan/pensiun/cetak', [LaporanController::class, 'cetakPensiun'])->name('laporan.pensiun.cetak');
    });

    // --- RUTE PENGATURAN (Hanya Admin) ---
    Route::middleware(['can:kelola pengaturan'])->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('opd', OpdController::class);
        Route::resource('jabatan', JabatanController::class);
    });
});

require __DIR__ . '/auth.php';
