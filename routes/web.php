<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PendapatanController;
use App\Http\Controllers\Admin\PengeluaranController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\RiwayatLaporanController;
use App\Http\Controllers\Admin\AkunController;
use App\Http\Controllers\Direktur\DashboardController as DirekturDashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| REDIRECT AWAL
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    return redirect()->route('login');

});

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.post');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | DASHBOARD
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('admin.dashboard');

        /*
        |--------------------------------------------------------------------------
        | PENDAPATAN
        |--------------------------------------------------------------------------
        */

        Route::get('/pendapatan', [PendapatanController::class, 'index'])
            ->name('admin.pendapatan.index');

        Route::post('/pendapatan', [PendapatanController::class, 'store'])
            ->name('admin.pendapatan.store');

        Route::put('/pendapatan/{pendapatan}', [PendapatanController::class, 'update'])
            ->name('admin.pendapatan.update');

        Route::delete('/pendapatan/{pendapatan}', [PendapatanController::class, 'destroy'])
            ->name('admin.pendapatan.destroy');

        /*
        |--------------------------------------------------------------------------
        | PENGELUARAN
        |--------------------------------------------------------------------------
        */

        Route::get('/pengeluaran', [PengeluaranController::class, 'index'])
            ->name('admin.pengeluaran.index');

        Route::post('/pengeluaran', [PengeluaranController::class, 'store'])
            ->name('admin.pengeluaran.store');

        Route::put('/pengeluaran/{pengeluaran}', [PengeluaranController::class, 'update'])
            ->name('admin.pengeluaran.update');

        Route::delete('/pengeluaran/{pengeluaran}', [PengeluaranController::class, 'destroy'])
            ->name('admin.pengeluaran.destroy');

        /*
        |--------------------------------------------------------------------------
        | LAPORAN LABA RUGI
        |--------------------------------------------------------------------------
        */

        Route::get('/laporan', [LaporanController::class, 'index'])
            ->name('admin.laporan.index');

        Route::get('/laporan/pdf', [LaporanController::class, 'downloadPdf'])
            ->name('admin.laporan.pdf');

        Route::get('/laporan/excel', [LaporanController::class, 'downloadExcel'])
            ->name('admin.laporan.excel');

        /*
        |--------------------------------------------------------------------------
        | RIWAYAT LAPORAN
        |--------------------------------------------------------------------------
        */

        Route::get('/riwayat-laporan', [RiwayatLaporanController::class, 'index'])
            ->name('admin.riwayat.index');

        /*
        |--------------------------------------------------------------------------
        | HAPUS LAPORAN
        |--------------------------------------------------------------------------
        */

        Route::delete('/riwayat-laporan/{laporan}', [RiwayatLaporanController::class, 'destroy'])
            ->name('admin.riwayat.destroy');

        /*
|--------------------------------------------------------------------------
| FINALISASI LAPORAN
|--------------------------------------------------------------------------
*/
Route::put('/riwayat-laporan/{laporan}/finalisasi', [RiwayatLaporanController::class, 'finalisasi'])
    ->name('admin.riwayat.finalisasi');

/*
|--------------------------------------------------------------------------
| KELOLA AKUN
|--------------------------------------------------------------------------
*/
Route::resource('akun', AkunController::class)
    ->names('admin.akun');
    });

/*
|--------------------------------------------------------------------------
| DIREKTUR
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:direktur'])
    ->prefix('direktur')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | DASHBOARD
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard', [DirekturDashboardController::class, 'index'])
            ->name('direktur.dashboard');

        /*
        |--------------------------------------------------------------------------
        | RIWAYAT LAPORAN
        |--------------------------------------------------------------------------
        */

        Route::get('/riwayat-laporan', [RiwayatLaporanController::class, 'index'])
            ->name('direktur.riwayat.index');

    /*
|--------------------------------------------------------------------------
| LAPORAN LABA RUGI
|--------------------------------------------------------------------------
*/

Route::get('/laporan', [LaporanController::class, 'index'])
    ->name('direktur.laporan.index');

Route::get('/laporan/pdf', [LaporanController::class, 'downloadPdf'])
    ->name('direktur.laporan.pdf');

Route::get('/laporan/excel', [LaporanController::class, 'downloadExcel'])
    ->name('direktur.laporan.excel');

    /*
|--------------------------------------------------------------------------
| KELOLA AKUN
|--------------------------------------------------------------------------
*/

Route::resource('akun', AkunController::class)
    ->names('direktur.akun');

     });