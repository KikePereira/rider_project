<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MotorbikeController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth/login');
});
Route::middleware(['auth'])->group(function () {

//PROFILE
Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::get('/profile/{motorbike}/confirm-delete', [ProfileController::class, 'confirmDelete'])->name('profile.confirm-delete');
Route::delete('/profile/{id}', [ProfileController::class, 'destroy'])->name('profile.destroy');
Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
Route::get('/profile/update', [ProfileController::class, 'edit'])->name('profile.edit');

Route::get('/motorbike/{id}/edit', [MotorbikeController::class, 'edit'])->name('motorbike.edit');
Route::put('/motorbike/{id}', [MotorbikeController::class, 'update'])->name('motorbike.update');


//MOTORBIKE
Route::delete('/motorbike/{motorbike}', [MotorbikeController::class, 'destroy'])->name('motorbike.destroy');

});

Route::get('/motorbike/{motorbike}/confirm-delete', [MotorbikeController::class, 'confirmDelete'])->name('motorbike.confirm-delete');


Route::group(['middleware' => ['auth', 'check.motorbike']], function () {
    Route::get('/motorbikes/create', [MotorbikeController::class, 'create'])->name('motorbikes.create');
    Route::post('/motorbikes', [MotorbikeController::class, 'store'])->name('motorbikes.store');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
