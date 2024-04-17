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

Route::get('/', [CheckResultController::class, 'show'])->middleware('guest')->name('welcome');
Route::post('check', [CheckResultController::class, 'check'])->middleware('guest')->name('check');
Route::get('result/{RegNo}/{Semester}', [CheckResultController::class, 'showResult'])->name('result');
Route::get('make-payment/{regNo}', [PaymentController::class, 'makePayment'])->name('makePayment')->middleware('makePayment');
Route::post('process-payment', [PaymentController::class, 'processPayment'])->name('processPayment');
Route::get('statement', [PaymentController::class, 'statement'])->name('statement');

Route::get('dashboard', [ResultController::class, 'show'])->middleware('auth')->name('dashboard');
Route::post('store', [ResultController::class, 'store'])->middleware('auth')->name('importResult');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
