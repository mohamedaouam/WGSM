<?php

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
/// auth routes 
/*
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');
*/


Route::get('/', 'WiGSV@index');
Route::get('/AcheterWiGSV','BController@buy')->name('Buy');
//Auth::routes();
//Route::get('login', ['middleware' => 'control', 'uses' => 'Auth\LoginController@showLoginForm'] )->name('login');
Route::group(['middleware' => 'control'], function(){
	Auth::routes();
});
//post requests
Route::post('/Clients','WiGSV@addClient')->name('addClient');
Route::post('/Client','WiGSV@upClient')->name('upClient');
Route::post('/Stocks', 'WiGSV@addStocks')->name('addStocks');
Route::post('/Models', 'WiGSV@addModel')->name('addModel');
Route::post('/Model/Update', 'WiGSV@upModel')->name('upModel');
Route::post('/Objet', 'WiGSV@upObjet')->name('upObjet');
Route::post('/ElementO', 'WiGSV@addEl')->name('addEl');
// get requests
Route::get('/Factures/Objets', 'WiGSV@factures')->name('factures');
Route::get('/Stocks', 'WiGSV@stocks')->name('stocks');
Route::get('/Models', 'WiGSV@models')->name('models');
Route::get('/ElementO/{id}', 'WiGSV@delEl')->name('delEl');
Route::get('/Model/{id}/Objets', 'WiGSV@modelObj')->name('modelObj');
Route::get('/Clients', 'WiGSV@clients')->name('clients');
Route::get('/DeleteClient/{id}','WiGSV@delClient')->name('deleteC');
Route::get('/DeleteObjet/{id}','WiGSV@delObjet')->name('deleteO');
Route::get('/Model/{id}/Delete', 'WiGSV@delModel')->name('delModel');
Route::get('/Factures/Models', 'WiGSV@facturesM')->name('facturesM');

Route::get('/Client/{id}/{name}','WiGSV@client')->name('client');
Route::get('/Objet/{id}/{name}','WiGSV@objet')->name('objet');
Route::get('/Home', 'WiGSV@index')->name('home');
//PUT requests
Route::put('/Stocks', 'WiGSV@enstocker')->name('enstocker');

Auth::routes();

