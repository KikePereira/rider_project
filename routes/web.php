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
    return view('welcome');
});
Route::middleware(['auth'])->group(function () {

//PROFILE
Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

//MOTORBIKE
Route::get('/motorbikes/create', [MotorbikeController::class, 'create'])->name('motorbikes.create');
Route::post('/motorbikes', [MotorbikeController::class, 'store'])->name('motorbikes.store');
Route::delete('/motorbike/{motorbike}', [MotorbikeController::class, 'destroy'])->name('motorbike.destroy');

});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
