<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\UserController;


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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('/logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('logout');

Route::resource('product', ProductController::class);
Route::post('/request_topup/{id}', [WalletController::class, 'request_topup'])->name('request_topup');
Route::post('/withdraw-from-bank', [WalletController::class, 'withdrawFromBank']);
Route::post('withdrawNow', [WalletController::class, 'withdrawNow'])->name('withdrawNow');      
Route::post('/withdraw-from-bank', [WalletController::class, 'withdrawFromBank']);
Route::post('/topup-from-bank', [WalletController::class, 'topupFromBank']);
Route::post('/addToCart', [TransactionController::class, 'addToCart'])->name('addToCart');
Route::get('/download{order_code}',[TransactionController::class,'download'])->name('download');
Route::post('/payNow', [TransactionController::class, 'payNow'])->name('payNow');
Route::post('TopUpNow', [WalletController::class, 'TopUpNow'])->name('TopUpNow');
Route::get('/topup', [WalletController::class, 'topup'])->name('topup');
Route::get('/withdraw', [WalletController::class, 'withdraw'])->name('withdraw');


Route::resource('user', UserController::class);
