<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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

Route::get('/', [HomeController::class, 'index'])->name('dashboard');
Route::get('/detail/{encode_id}', [HomeController::class, 'show'])->name('detail');
Route::get('/all', [HomeController::class, 'all'])->name('all');
Route::get('/all-load', [HomeController::class, 'all_load'])->name('all_load');
Route::get('/search', [HomeController::class, 'search'])->name('search');