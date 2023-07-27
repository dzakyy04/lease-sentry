<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConceptorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HolidayController;

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
});

Route::middleware('auth')->group(function () {
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Hari Libur
    Route::get('/hari-libur', [HolidayController::class, 'index'])->name('holiday.index');
    Route::post('/hari-libur', [HolidayController::class, 'store'])->name('holiday.store');
    Route::get('/hari-libur/{id}', [HolidayController::class, 'getHoliday'])->name('holiday.get');
    Route::post('/hari-libur/{id}', [HolidayController::class, 'update'])->name('holiday.update');
    Route::delete('/hari-libur/{id}', [HolidayController::class, 'delete'])->name('holiday.delete');

    // Konseptor
    Route::get('/konseptor', [ConceptorController::class, 'index'])->name('conceptor.index');
    Route::post('/konseptor', [ConceptorController::class, 'store'])->name('conceptor.store');
    Route::get('/konseptor/{id}', [ConceptorController::class, 'getConceptor'])->name('conceptor.get');
    Route::post('/konseptor/{id}', [ConceptorController::class, 'update'])->name('conceptor.update');
});
