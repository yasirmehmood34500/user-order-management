<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
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

// dd('asdads');
Route::get('/', function () {
    return view('auth.login');
});

// Route::get('login', [UserController::class, 'login_page'])->name("login_page");
Route::get('dashboard', [UserController::class, 'dashboard_page'])->name("dashboard_page");

Route::group(['middleware' => ['auth']], function() {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/contacts', [App\Http\Controllers\ContactsController::class, 'index'])->name('contacts');

    //    company
    Route::get('/companies', [App\Http\Controllers\CompanyController::class, 'index'])->name('companies');
    Route::post('/save-company', [App\Http\Controllers\CompanyController::class, 'store'])->name('save.companies');
    Route::get('/edit-company/{id}', [App\Http\Controllers\CompanyController::class, 'edit'])->name('edit.companies');
    Route::post('/update-company/{id}', [App\Http\Controllers\CompanyController::class, 'update'])->name('update.companies');

    Route::get('/buy-orders', [App\Http\Controllers\BuyOrderController::class, 'index'])->name('buy-orders');
    Route::get('/sell-orders', [App\Http\Controllers\SellOrderController::class, 'index'])->name('sell-orders');
    Route::get('/paired-order', [App\Http\Controllers\PairedOrderController::class, 'index'])->name('paired-order');
    Route::get('/acquistion-targets', [App\Http\Controllers\AcqTargetController::class, 'index'])->name('acquistion-targets');
    Route::get('/current-holdings', [App\Http\Controllers\CurrentHoldingController::class, 'index'])->name('current-holdings');
    Route::get('/current-holdings', [App\Http\Controllers\CurrentHoldingController::class, 'index'])->name('current-holdings');

});
