<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\ConceptorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\Document2020Controller;
use App\Http\Controllers\Document2021Controller;
use App\Http\Controllers\Document2022Controller;
use App\Http\Controllers\Document2023Controller;

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

Route::get('/', function () {
    return redirect()->route('dashboard.index');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index']);
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    // Reset password
    Route::get('/lupa-password', [AuthController::class, 'forgotPasswordView'])->name('forgot-password.view');
    Route::post('/lupa-password', [AuthController::class, 'forgotPasswordSend'])->name('forgot-password.send');
    Route::get('reset-password/{token}', [AuthController::class, 'resetPasswordView'])->name('reset-password.view');
    Route::post('reset-password', [AuthController::class, 'resetPasswordAction'])->name('reset-password.action');
});

Route::middleware('auth')->group(function () {
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/ubah-password', [AuthController::class, 'changePassword'])->name('change-password.view');
    Route::post('/ubah-password', [AuthController::class, 'updatePassword'])->name('change-password.action');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Hari Libur
    Route::get('/hari-libur', [HolidayController::class, 'index'])->name('holiday.index');
    Route::post('/hari-libur', [HolidayController::class, 'store'])->name('holiday.store');
    Route::get('/hari-libur/{id}', [HolidayController::class, 'getHoliday'])->name('holiday.get');
    Route::post('/hari-libur/{id}/edit', [HolidayController::class, 'update'])->name('holiday.update');
    Route::delete('/hari-libur/{id}/hapus', [HolidayController::class, 'delete'])->name('holiday.delete');

    // Konseptor
    Route::get('/konseptor', [ConceptorController::class, 'index'])->name('conceptor.index');
    Route::post('/konseptor', [ConceptorController::class, 'store'])->name('conceptor.store');
    Route::get('/konseptor/{id}', [ConceptorController::class, 'getConceptor'])->name('conceptor.get');
    Route::post('/konseptor/{id}/edit', [ConceptorController::class, 'update'])->name('conceptor.update');
    Route::delete('/konseptor/{id}/hapus', [ConceptorController::class, 'delete'])->name('conceptor.delete');

    // Document2020
    // Sewa
    Route::get('/dokumen/sewa/2020', [Document2020Controller::class, 'sewaIndex'])->name('document2020.sewa.index');
    Route::get('/dokumen/sewa/2020/tambah', [Document2020Controller::class, 'create'])->name('document2020.sewa.create');

    // Penjualan
    Route::get('/dokumen/penjualan/2020', [Document2020Controller::class, 'penjualanIndex'])->name('document2020.penjualan.index');
    Route::get('/dokumen/penjualan/2020/tambah', [Document2020Controller::class, 'create'])->name('document2020.penjualan.create');

    // Penghapusan
    Route::get('/dokumen/penghapusan/2020', [Document2020Controller::class, 'penghapusanIndex'])->name('document2020.penghapusan.index');
    Route::get('/dokumen/penghapusan/2020/tambah', [Document2020Controller::class, 'create'])->name('document2020.penghapusan.create');

    Route::post('/dokumen/2020/tambah', [Document2020Controller::class, 'store'])->name('document2020.store');
    Route::get('/dokumen/2020/{id}/edit', [Document2020Controller::class, 'edit'])->name('document2020.edit');
    Route::post('/dokumen/2020/{id}/edit', [Document2020Controller::class, 'update'])->name('document2020.update');
    Route::delete('/dokumen/2020/{id}/hapus', [Document2020Controller::class, 'delete'])->name('document2020.delete');
    Route::post('/dokumen/2020/import', [Document2020Controller::class, 'import'])->name('document2020.import');

    // Document2021
    // Sewa
    Route::get('/dokumen/sewa/2021', [Document2021Controller::class, 'sewaIndex'])->name('document2021.sewa.index');
    Route::get('/dokumen/sewa/2021/tambah', [Document2021Controller::class, 'create'])->name('document2021.sewa.create');

    // Penjualan
    Route::get('/dokumen/penjualan/2021', [Document2021Controller::class, 'penjualanIndex'])->name('document2021.penjualan.index');
    Route::get('/dokumen/penjualan/2021/tambah', [Document2021Controller::class, 'create'])->name('document2021.penjualan.create');

    // Penghapusan
    Route::get('/dokumen/penghapusan/2021', [Document2021Controller::class, 'penghapusanIndex'])->name('document2021.penghapusan.index');
    Route::get('/dokumen/penghapusan/2021/tambah', [Document2021Controller::class, 'create'])->name('document2021.penghapusan.create');

    Route::post('/dokumen/2021/tambah', [Document2021Controller::class, 'store'])->name('document2021.store');
    Route::get('/dokumen/2021/{id}/edit', [Document2021Controller::class, 'edit'])->name('document2021.edit');
    Route::post('/dokumen/2021/{id}/edit', [Document2021Controller::class, 'update'])->name('document2021.update');
    Route::delete('/dokumen/2021/{id}/hapus', [Document2021Controller::class, 'delete'])->name('document2021.delete');
    Route::post('/dokumen/2021/import', [Document2021Controller::class, 'import'])->name('document2021.import');

    // Document2022
    // Sewa
    Route::get('/dokumen/sewa/2022', [Document2022Controller::class, 'sewaIndex'])->name('document2022.sewa.index');
    Route::get('/dokumen/sewa/2022/tambah', [Document2022Controller::class, 'create'])->name('document2022.sewa.create');

    // Penjualan
    Route::get('/dokumen/penjualan/2022', [Document2022Controller::class, 'penjualanIndex'])->name('document2022.penjualan.index');
    Route::get('/dokumen/penjualan/2022/tambah', [Document2022Controller::class, 'create'])->name('document2022.penjualan.create');

    // Penghapusan
    Route::get('/dokumen/penghapusan/2022', [Document2022Controller::class, 'penghapusanIndex'])->name('document2022.penghapusan.index');
    Route::get('/dokumen/penghapusan/2022/tambah', [Document2022Controller::class, 'create'])->name('document2022.penghapusan.create');

    Route::post('/dokumen/2022/tambah', [Document2022Controller::class, 'store'])->name('document2022.store');
    Route::get('/dokumen/2022/{id}/edit', [Document2022Controller::class, 'edit'])->name('document2022.edit');
    Route::post('/dokumen/2022/{id}/edit', [Document2022Controller::class, 'update'])->name('document2022.update');
    Route::delete('/dokumen/2022/{id}/hapus', [Document2022Controller::class, 'delete'])->name('document2022.delete');
    Route::post('/dokumen/2022/import', [Document2022Controller::class, 'import'])->name('document2022.import');

    // Document2023
    // Sewa
    Route::get('/dokumen/sewa/2023', [Document2023Controller::class, 'sewaIndex'])->name('document2023.sewa.index');
    Route::get('/dokumen/sewa/2023/tambah', [Document2023Controller::class, 'create'])->name('document2023.sewa.create');

    // Penjualan
    Route::get('/dokumen/penjualan/2023', [Document2023Controller::class, 'penjualanIndex'])->name('document2023.penjualan.index');
    Route::get('/dokumen/penjualan/2023/tambah', [Document2023Controller::class, 'create'])->name('document2023.penjualan.create');

    // Penghapusan
    Route::get('/dokumen/penghapusan/2023', [Document2023Controller::class, 'penghapusanIndex'])->name('document2023.penghapusan.index');
    Route::get('/dokumen/penghapusan/2023/tambah', [Document2023Controller::class, 'create'])->name('document2023.penghapusan.create');

    Route::post('/dokumen/2023/tambah', [Document2023Controller::class, 'store'])->name('document2023.store');
    Route::get('/dokumen/2023/{id}/edit', [Document2023Controller::class, 'edit'])->name('document2023.edit');
    Route::post('/dokumen/2023/{id}/edit', [Document2023Controller::class, 'update'])->name('document2023.update');
    Route::delete('/dokumen/2023/{id}/hapus', [Document2023Controller::class, 'delete'])->name('document2023.delete');
    Route::post('/dokumen/2023/import', [Document2023Controller::class, 'import'])->name('document2023.import');

    // Device
    Route::get('/device', [DeviceController::class, 'index'])->name('device.index');
    Route::post('/device/edit', [DeviceController::class, 'update'])->name('device.update');
});