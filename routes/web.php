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
    return view('welcome');
});

// Route::get('login', [UserController::class, 'login_page'])->name("login_page");
Route::get('dashboard', [UserController::class, 'dashboard_page'])->name("dashboard_page");

Route::group(['middleware' => ['auth']], function() {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    //    company
    Route::get('/companies', [App\Http\Controllers\CompanyController::class, 'index'])->name('companies');
    Route::post('/save-company', [App\Http\Controllers\CompanyController::class, 'store'])->name('save.companies');
    Route::get('/edit-company/{id}', [App\Http\Controllers\CompanyController::class, 'edit'])->name('edit.companies');
    Route::post('/update-company/{id}', [App\Http\Controllers\CompanyController::class, 'update'])->name('update.companies');

//    user
    Route::get('/contacts', [App\Http\Controllers\ContactsController::class, 'index'])->name('contacts');
    Route::post('/save-user', [App\Http\Controllers\ContactsController::class, 'store'])->name('contacts.store');
    Route::post('/update-user/{id}', [App\Http\Controllers\ContactsController::class, 'update'])->name('contacts.update');

    Route::get('/get-buy-orders', [App\Http\Controllers\BuyOrderController::class, 'buyOrders'])->name('buyOrders');
    Route::post('/save-buy-order', [App\Http\Controllers\BuyOrderController::class, 'store'])->name('buy.store');
    Route::post('/pair-buy-order', [App\Http\Controllers\BuyOrderController::class, 'pair'])->name('buy.pair');
    Route::get('/edit-buy-order/{id}', [App\Http\Controllers\BuyOrderController::class, 'edit'])->name('buy.edit');
    Route::post('/update-buy-order/{id}', [App\Http\Controllers\BuyOrderController::class, 'update'])->name('buy.update');

    Route::get('/get-sale-orders', [App\Http\Controllers\SellOrderController::class, 'saleOrders'])->name('sellOrders');
    Route::get('/for-pair-sale-orders', [App\Http\Controllers\SellOrderController::class, 'forPairSellOrders'])->name('forPairSellOrders');
    Route::post('/save-sale-order', [App\Http\Controllers\SellOrderController::class, 'store'])->name('sale.store');
    Route::get('/edit-sale-order/{id}', [App\Http\Controllers\SellOrderController::class, 'edit'])->name('sale.edit');
    Route::post('/update-sale-order/{id}', [App\Http\Controllers\SellOrderController::class, 'update'])->name('sale.update');


    Route::get('/buy-orders', [App\Http\Controllers\BuyOrderController::class, 'index'])->name('buy-orders');
    Route::get('/sell-orders', [App\Http\Controllers\SellOrderController::class, 'index'])->name('sell-orders');
    Route::get('/paired-order', [App\Http\Controllers\PairedOrderController::class, 'index'])->name('paired-order');
    Route::get('paired_order_delete/{id}', [App\Http\Controllers\PairedOrderController::class, 'destroy'])->name('paired-order.destroy');

    Route::get('/acquistion-targets', [App\Http\Controllers\AcqTargetController::class, 'index'])->name('acquistion-targets');
    Route::get('/current-holdings', [App\Http\Controllers\CurrentHoldingController::class, 'index'])->name('current-holdings');
    Route::get('/current-holdings', [App\Http\Controllers\CurrentHoldingController::class, 'index'])->name('current-holdings');

});
