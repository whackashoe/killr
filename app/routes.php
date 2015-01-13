<?php

Route::get('/',                 ['before' => 'throttle:300,30', 'uses' => 'HomeController@getIndex']);
Route::post('/create',          ['before' => 'throttle:300,30', 'uses' => 'PasteController@create']);
Route::post('/{slug}/create',   ['before' => 'throttle:300,30', 'uses' => 'PasteController@create']);
Route::post('/{slug}/delete',   ['before' => 'throttle:300,30', 'uses' => 'PasteController@delete']);
Route::get('/{slug}/mods.json', ['before' => 'throttle:300,30', 'uses' => 'PasteController@modsJson']);
Route::get('/{slug}/mods',      ['before' => 'throttle:300,30', 'uses' => 'PasteController@mods']);
Route::get('/{slug}/raw',       ['before' => 'throttle:300,30', 'uses' => 'PasteController@getRaw']);
Route::get('/{slug}',           ['before' => 'throttle:300,30', 'uses' => 'PasteController@get']);