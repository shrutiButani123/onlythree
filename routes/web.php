<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ProductController;

use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;


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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [RegisterController::class, 'create'])->name('register')->middleware('guest');
Route::post('/', [RegisterController::class, 'store'])->name('register.store')->middleware('guest');

Route::get('/login', [LoginController::class, 'create'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'store'])->name('login.store')->middleware('guest');

Route::get('/dashboard', [LoginController::class, 'dashboard'])->name('dashboard')->middleware('auth');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('cities/{id}', [RegisterController::class, 'getcities'])->name('cities');

Route::group(['middleware' => 'auth'], function () {
    Route::get('product', [ProductController::class, 'index'])->name('products');
    Route::get('product/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('product/store', [ProductController::class, 'store'])->name('product.store');

    Route::get('product/{id}/edit', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('product/update/{id}', [ProductController::class, 'update'])->name('product.update');

    Route::delete('product/delete/{id}', [ProductController::class, 'destroy'])->name('product.destroy');
    Route::get('product/{id}', [ProductController::class, 'show'])->name('product.show');

    Route::post('product/subcategory', [ProductController::class, 'subCategory'])->name('product.subcategory');
});
// Route::get('/product/export', [ProductController::class, 'export'])->name('product.export');
Route::get('users/export/{date}', [ProductController::class, 'export'])->name('product.export');
