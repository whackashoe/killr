<?php

Route::get('/',                 ['before' => 'throttle:300,30', 'uses' => 'HomeController@getIndex']);
Route::post('/',                ['before' => 'throttle:300,30', 'uses' => 'PasteController@create']);
Route::get('/{slug}',           ['before' => 'throttle:300,30', 'uses' => 'PasteController@get']);
Route::post('/{slug}',          ['before' => 'throttle:300,30', 'uses' => 'PasteController@delete']);
Route::get('/{slug}/mods',      ['before' => 'throttle:300,30', 'uses' => 'PasteController@mods']);
Route::get('/{slug}/mods.json', ['before' => 'throttle:300,30', 'uses' => 'PasteController@modsJson']);