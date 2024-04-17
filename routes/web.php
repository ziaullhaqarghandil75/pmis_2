<?php

use App\Http\Controllers\AccountSetting\PermissionCategoryController;
use App\Http\Controllers\AccountSetting\PermissionController;
use App\Http\Controllers\plan\DepratmentController;
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
Route::resource('/permission', PermissionController::class);
Route::resource('/permission_category', PermissionCategoryController::class);
Route::resource('/role', PermissionController::class);
Route::resource('/department', DepratmentController::class);

// Route::get('/permission', [PermissionController::class, 'index'])->name('permission.index');
// Route::resource('/role', ::class);
// Route::resource('/user', PermissionController::class);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
