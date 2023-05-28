<?php

use App\Http\Controllers\DiagnosesController;
use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::view('about', 'about')->name('about');

    Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');

    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    //! Lieutenant
    Route::get('all_lieutenant', [PatientController::class, 'index'])->name('lieutenant.index');
    Route::post('store', [PatientController::class, 'store'])->name('lieutenant.store');
    Route::post('update', [PatientController::class, 'update'])->name('lieutenant.update');
    Route::get('destroy/{id}', [PatientController::class, 'destroy'])->name('lieutenant.destroy');
    //! Diagnoses Routes
    Route::get('diagnoses/{id}', [DiagnosesController::class, 'index'])->name('diagnoses.index');
    Route::post('create', [DiagnosesController::class, 'create'])->name('diagnoses.create');
    Route::get('destroydiagnoses/{id}', [DiagnosesController::class, 'destroy'])->name('diagnoses.destroy');
    Route::post('updatediagnoses', [DiagnosesController::class, 'update'])->name('diagnoses.update');
});
