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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/check/{link}','ApiEntryController@store');



Route::get('/sniff', 'CodeSnifferController@CreateLog');


Route::get('/donation', 'donationPayPalController@view');


Route::group(['prefix' => 'queues', 'namespace' => 'Queues'], function() {
    Route::get('startTestProcess', 'StartTestProcessController')
         ->name('queues.startTestProcess');

});
