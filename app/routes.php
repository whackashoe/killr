<?php

Route::get('/', 'HomeController@getIndex');
Route::post('/', 'PasteController@create');
Route::get('/{slug}', 'PasteController@get');
Route::post('/{slug}', 'PasteController@delete');
Route::get('/{slug}/mods', 'PasteController@mods');
Route::get('/{slug}/mods.json', 'PasteController@modsJson');