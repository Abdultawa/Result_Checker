<?php

use App\Http\Controllers\CheckResultController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResultController;
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

Route::controller(ResultController::class)->middleware('auth')->group(function(){
    Route::post('/delete-results', 'deleteResults')->name('deleteResults');
    Route::get('dashboard', 'show')->name('dashboard');
    Route::post('store', 'store')->name('importResult');
    Route::get('manageUser', 'manageUser')->name('result.manageUser');
    Route::delete('deleteUser/{user}', 'deleteUser')->name('result.deleteUser');
});


Route::controller(CheckResultController::class)->group(function(){
    Route::get('/', 'show')->middleware('guest')->name('welcome');
    Route::post('check', 'check')->middleware('guest')->name('check');
    Route::get('result/{RegNo}/{Semester}/{level}', 'showResult')->name('result');

});

Route::controller(PaymentController::class)->group(function(){
    Route::get('make-payment/{regNo}', 'makePayment')->name('makePayment')->middleware('makePayment');
    Route::post('process-payment', 'processPayment')->name('processPayment');
    Route::get('statement', 'statement')->name('statement');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route::get('/res', [ResultController::class, 'user']);

require __DIR__.'/auth.php';
