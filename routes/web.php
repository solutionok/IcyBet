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


/**home */
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');

Auth::routes();

Route::get('getcontacts', ['as'=>'google.import', 'uses'=>'AdjudicatorController@importGoogleContact']);

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');


/** adjudicator */
Route::get('adjudicator', 'AdjudicatorController@index');
Route::post('adjudicator/save-bet', 'AdjudicatorController@saveBet');
Route::get('adjudicator/get-bet/{id}', 'AdjudicatorController@getBet');
Route::post('adjudicator/cancel-bet', 'AdjudicatorController@cancelBet');
Route::post('adjudicator/award', 'AdjudicatorController@award');
Route::get('adjudicator/contactapi', 'AdjudicatorController@importGoogleContact');

/** points */
Route::get('points', 'PointsController@index');
Route::get('points/get-history/{email}', 'PointsController@getHistory');

/** bets */
Route::get('bets', 'BetsController@index');
Route::get('bets/bet-list', 'BetsController@betList');
Route::post('bets/place-bet', 'BetsController@placeBet');
Route::post('bets/invite-myfrinds', 'BetsController@inviteMyfrinds');

/** account */
Route::get('account', 'AccountController@index');
Route::post('account/save', 'AccountController@save');
Route::post('account/cancel', 'AccountController@cancel');
