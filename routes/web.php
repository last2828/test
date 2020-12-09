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

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'account', 'middleware' => 'auth'], function(){
  Route::resource('deposits', 'DepositController')->except('create');
  Route::get('/wallet/deposits/create', 'DepositController@create')->name('deposits.create');
  Route::resource('wallets', 'WalletController')->except(['update', 'edit']);
  Route::get('/wallet/edit', 'WalletController@edit')->name('wallets.edit');
  Route::put('/wallet/update', 'WalletController@update')->name('wallets.update');

  Route::get('/', 'MainController@index')->name('accounts.index');

  Route::get('/test', 'DepositController@topUpPercents');
});
