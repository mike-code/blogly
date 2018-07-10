<?php

Route::group(['prefix' => 'api', 'as' => 'blog.'], function()
{
    Route::get('/entry', 'BlogController@get')->name('entry');
    Route::get('/entry/{id}', 'BlogController@__notimplemented__');

    Route::group(['middleware' => ['auth']], function()
    {
        Route::post('/entry', 'BlogController@add');
        Route::put('/entry/{id}', 'BlogController@update');
        Route::delete('/entry/{id}', 'BlogController@delete');
    });
});

Route::get('/', function () { return view('index'); })->name('home');
Route::post('/login', 'Auth\LoginController@login')->name('login');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
Route::get('/session', 'UserController@getSessionData')->name('session');
