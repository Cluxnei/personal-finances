<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/{startDate}/{endDate}', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/inflow', [HomeController::class, 'storeInflow'])->name('inflow.store');
Route::post('/outflow', [HomeController::class, 'storeOutflow'])->name('outflow.store');
Route::post('/category', [HomeController::class, 'storeCategory'])->name('category.store');

Route::get('/', static function() {
    return redirect()->route('home', [
        'startDate' => now()->startOfMonth()->format('Y-m-d'),
        'endDate' => now()->endOfMonth()->format('Y-m-d'),
    ]);
});
