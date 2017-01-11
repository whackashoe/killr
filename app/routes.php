<?php

Route::get('/',                  ['before' => 'throttle:300,30', 'uses' => 'HomeController@getIndex']);
Route::post('/create',           ['before' => 'throttle:300,30', 'uses' => 'PasteController@create']);
Route::post('/{slug}/create',    ['before' => 'throttle:300,30', 'uses' => 'PasteController@create']);
Route::post('/{slug}/delete',    ['before' => 'throttle:300,30', 'uses' => 'PasteController@delete']);
Route::get('/{slug}/mods.json',  ['before' => 'throttle:300,30', 'uses' => 'PasteController@modsJson']);
Route::get('/{slug}/mods',       ['before' => 'throttle:300,30', 'uses' => 'PasteController@mods']);
Route::get('/{slug}/diff/{mod}', ['before' => 'throttle:300,30', 'uses' => 'PasteController@diff']);
Route::get('/{slug}/raw',        ['before' => 'throttle:300,30', 'uses' => 'PasteController@getRaw']);
Route::get('/preview/{slug}',    ['before' => 'throttle:100,3',  'uses' => 'PasteController@get_preview']);
Route::post('/preview',          ['before' => 'throttle:100,3',  'uses' => 'PasteController@create_preview']);
Route::get('/{slug}/demo',       ['before' => 'throttle:300,30', 'uses' => 'PasteController@demo']);
Route::get('/{slug}',            ['before' => 'throttle:300,30', 'uses' => 'PasteController@get']);
