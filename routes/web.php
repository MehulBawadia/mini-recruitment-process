<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\AgenciesController;
use App\Http\Controllers\AccountSettingsController;

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
    return redirect(route('login'));
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::middleware('role:hr')->group(function () {
        Route::resource('agencies', AgenciesController::class);
    });

    Route::prefix('account-settings')->name('accountSettings')->group(function () {
        Route::get('/', [AccountSettingsController::class, 'index']);
        Route::put('/update', [AccountSettingsController::class, 'update'])->name('.update');
    });
});

require __DIR__.'/auth.php';
