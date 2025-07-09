<?php

use App\Http\Controllers\DataPegawaiController;
use App\Http\Controllers\JenisSuratController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SuratKeluarController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/welcome', function () {
    return view('welcome');
});

Route::group(['prefix' => 'login'], function () {
    Route::get('/', [LoginController::class, 'login'])->name('login')->middleware('guest');
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::post('/login/aksi_login', [LoginController::class, 'aksi_login'])->name('aksi_login')->middleware('guest');
});
Route::group(['middleware' => 'cekstatus'], function () {
    Route::get('/', function () {
    return view('dashboard_admin.main');
});
  Route::get('/dashboard_admin', function () {
        return view('dashboard_admin.main');
    })->name('dashboard-admin'); 
//   
    Route::group(['prefix' => 'jenis-surat'], function () {
        Route::get('/', [JenisSuratController::class, 'index'])->name('data-jenis-surat');
        Route::post('/add-jenis-surat', [JenisSuratController::class, 'addJenisSurat'])->name('form-add-jenis-surat');
        Route::post('/store-jenis-surat', [JenisSuratController::class, 'store'])->name('store-jenis-surat');
        Route::post('/delete-jenis-surat', [JenisSuratController::class, 'destroy'])->name('destroy-jenis-surat');
    });
    Route::group(['prefix' => 'data-pegawai'], function () {
        Route::get('/', [DataPegawaiController::class, 'index'])->name('data-pegawai');
        Route::post('/add-data-pegawai', [DataPegawaiController::class, 'addDataPegawai'])->name('form-add-data-pegawai');
        Route::post('/detail-data-pegawai', [DataPegawaiController::class, 'detailDataPegawai'])->name('detail-data-pegawai');
        Route::post('/store-data-pegawai', [DataPegawaiController::class, 'store'])->name('store-data-pegawai');
        Route::post('/delete-data-pegawai', [DataPegawaiController::class, 'destroy'])->name('destroy-data-pegawai');
    });
   Route::group(['prefix' => 'surat-keluar'], function () {
        Route::get('/', [SuratKeluarController::class, 'index'])->name('data-surat-keluar');
        Route::post('/add-surat-keluar', [SuratKeluarController::class, 'addSuratKeluar'])->name('form-add-surat-keluar');
        Route::post('/detail-surat-keluar', [SuratKeluarController::class, 'detailSuratKeluar'])->name('detail-surat-keluar');
        Route::post('/cek-kepala-arsip-surat-keluar', [SuratKeluarController::class, 'cekKepalaArsip'])->name('cek-kepala-surat-keluar');
        Route::post('/cek-direktur-surat-keluar', [SuratKeluarController::class, 'cekDirektur'])->name('cek-direktur-surat-keluar');
        Route::get('/laporan-surat-keluar', [SuratKeluarController::class, 'laporan'])->name('laporan-surat-keluar');
        Route::get('/laporan-surat-disimpan', [SuratKeluarController::class, 'suratDisimpan'])->name('laporan-surat-disimpan');
        Route::get('/cetak-laporan', [SuratKeluarController::class, 'cetakLaporan'])->name('cetak-laporan');
       Route::get('/cetak-per-surat/{id}', [SuratKeluarController::class, 'cetakSuratKeluar'])
     ->name('cetak-per-surat-keluar');
        Route::post('/store-surat-keluar', [SuratKeluarController::class, 'store'])->name('store-surat-keluar');
        Route::post('/delete-surat-keluar', [SuratKeluarController::class, 'destroy'])->name('destroy-surat-keluar');
    });
    Route::group(['prefix' => 'surat-masuk'], function () {
        Route::get('/', [SuratKeluarController::class, 'suratMasuk'])->name('data-surat-masuk');
         Route::get('/cetak-laporan-surat-masuk', [SuratKeluarController::class, 'cetakLaporanSuratMasuk'])->name('cetak-laporan-surat-masuk');
         Route::get('/cetak-per-surat-masuk/{id}', [SuratKeluarController::class, 'cetakSuratMasuk'])
     ->name('cetak-per-surat-masuk');
    });
});