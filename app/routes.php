<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
Route::get('/test', function() {
    return View::make('test');
});

Route::get('/', 'HomeController@getIndex');
Route::post('/', 'PasteController@create');
Route::get('/{slug}', 'PasteController@get');
Route::post('/{slug}', 'PasteController@delete');