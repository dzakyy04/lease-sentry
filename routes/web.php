<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\ConceptorController;
use App\Http\Controllers\DashboardController;
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
    Route::get('/dokumen/2020', [Document2020Controller::class, 'index'])->name('document2020.index');
    Route::get('/dokumen/2020/tambah', [Document2020Controller::class, 'create'])->name('document2020.create');
    Route::post('/dokumen/2020/tambah', [Document2020Controller::class, 'store'])->name('document2020.store');
    Route::get('/dokumen/2020/{id}/edit', [Document2020Controller::class, 'edit'])->name('document2020.edit');
    Route::post('/dokumen/2020/{id}/edit', [Document2020Controller::class, 'update'])->name('document2020.update');
    Route::delete('/dokumen/2020/{id}/hapus', [Document2020Controller::class, 'delete'])->name('document2020.delete');
    Route::post('/dokumen/2020/import', [Document2020Controller::class, 'import'])->name('document2020.import');

    // Document2021
    Route::get('/dokumen/2021', [Document2021Controller::class, 'index'])->name('document2021.index');
    Route::get('/dokumen/2021/tambah', [Document2021Controller::class, 'create'])->name('document2021.create');
    Route::post('/dokumen/2021/tambah', [Document2021Controller::class, 'store'])->name('document2021.store');
    Route::get('/dokumen/2021/{id}/edit', [Document2021Controller::class, 'edit'])->name('document2021.edit');
    Route::post('/dokumen/2021/{id}/edit', [Document2021Controller::class, 'update'])->name('document2021.update');
    Route::delete('/dokumen/2021/{id}/hapus', [Document2021Controller::class, 'delete'])->name('document2021.delete');
    Route::post('/dokumen/2021/import', [Document2021Controller::class, 'import'])->name('document2021.import');

    // Document2021
    Route::get('/dokumen/2022', [Document2022Controller::class, 'index'])->name('document2022.index');
    Route::get('/dokumen/2022/tambah', [Document2022Controller::class, 'create'])->name('document2022.create');
    Route::post('/dokumen/2022/tambah', [Document2022Controller::class, 'store'])->name('document2022.store');
    Route::get('/dokumen/2022/{id}/edit', [Document2022Controller::class, 'edit'])->name('document2022.edit');
    Route::post('/dokumen/2022/{id}/edit', [Document2022Controller::class, 'update'])->name('document2022.update');
    Route::delete('/dokumen/2022/{id}/hapus', [Document2022Controller::class, 'delete'])->name('document2022.delete');
    Route::post('/dokumen/2022/import', [Document2022Controller::class, 'import'])->name('document2022.import');

    // Document2021
    Route::get('/dokumen/2023', [Document2023Controller::class, 'index'])->name('document2023.index');
    Route::get('/dokumen/2023/tambah', [Document2023Controller::class, 'create'])->name('document2023.create');
    Route::post('/dokumen/2023/tambah', [Document2023Controller::class, 'store'])->name('document2023.store');
    Route::get('/dokumen/2023/{id}/edit', [Document2023Controller::class, 'edit'])->name('document2023.edit');
    Route::post('/dokumen/2023/{id}/edit', [Document2023Controller::class, 'update'])->name('document2023.update');
    Route::delete('/dokumen/2023/{id}/hapus', [Document2023Controller::class, 'delete'])->name('document2023.delete');
    Route::post('/dokumen/2023/import', [Document2023Controller::class, 'import'])->name('document2023.import');
});
