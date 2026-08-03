<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ConsultationController;
use App\Models\Patient;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AntecedentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware('auth')->group(function(){
    Route::resource('patients', PatientController::class);
});

Route::post('/patients/{patient}/antecedents', [AntecedentController::class, 'store'])->name('antecedents.store');
Route::delete('/patients/{patient}/antecedents/{antecedent}', [AntecedentController::class, 'destroy'])->name('antecedents.destroy');

Route::post('/patients/{patient}/consultations', [ConsultationController::class, 'store'])->name('consultations.store');
Route::delete('/patients/{patient}/consultations/{consultation}', [ConsultationController::class, 'destroy'])->name('consultations.destroy');

Route::get('/patients/{patient}/pdf', [PatientController::class, 'downloadPdf'])->name('patients.pdf');
Route::post('/patients/{patient}/envoyer-pdf', [PatientController::class, 'sendPdfToMedecin'])->name('patients.send-pdf');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('users', UserController::class);
});

require __DIR__.'/auth.php';
