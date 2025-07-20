<?php

use App\Http\Controllers\ProfileController;
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
    
    // Token management routes
    Route::resource('tokens', App\Http\Controllers\TokenController::class);
    Route::patch('/tokens/{token}/regenerate', [App\Http\Controllers\TokenController::class, 'regenerate'])->name('tokens.regenerate');
    Route::patch('/tokens/{token}/toggle', [App\Http\Controllers\TokenController::class, 'toggle'])->name('tokens.toggle');
});

require __DIR__.'/auth.php';
