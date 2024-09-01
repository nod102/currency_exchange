<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth:web'])->group(function () {
    Route::resource('currencies', CurrencyController::class);
    Route::resource('currency_exchange', CurrencyExchangController::class)->except(['create', 'index', 'edit']);
    Route::resource('currency_amount', CurrencyAmountController::class);

    Route::get('currencies/currency_exchange/create/{currency_id}', [App\Http\Controllers\CurrencyExchangController::class, 'create'])->name('currencies.currency_exchange.create');
    Route::get('currencies/currency_exchange/index/{currency_id}', [App\Http\Controllers\CurrencyExchangController::class, 'index'])->name('currencies.currency_exchange.index');
    Route::get('currencies/currency_exchange/edit/{currency_id}/{currency_exchange_id}', [App\Http\Controllers\CurrencyExchangController::class, 'edit'])->name('currencies.currency_exchange.edit');
});
