<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\BuyOrderController;
use App\Http\Controllers\SellOrderController;
use App\Http\Controllers\PairedOrderController;
use App\Http\Controllers\AcqTargetController;
use App\Http\Controllers\CurrentHoldingController;
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

Route::get('/home', [HomeController::class, 'index'])->name('home_page');
Route::get('/contacts', [ContactsController::class, 'index'])->name('contact_page');
Route::get('/companies', [CompanyController::class, 'index'])->name('company_page');
Route::get('/buy-orders', [BuyOrderController::class, 'index'])->name('buy_order_page');
Route::get('/sell-orders', [SellOrderController::class, 'index'])->name('sell_order_page');
Route::get('/paired-order', [PairedOrderController::class, 'index'])->name('paired_order_page');
Route::get('/acquistion-targets', [AcqTargetController::class, 'index'])->name('acquistion_target_page');
Route::get('/current-holdings', [CurrentHoldingController::class, 'index'])->name('current_holding_page');
