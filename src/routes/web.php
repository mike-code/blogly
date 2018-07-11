<?php

Route::group(['prefix' => 'api'], function()
{
    Route::get('/entry', 'BlogController@getAll')->name('blog.entry');
    Route::get('/entry/{id}', 'BlogController@get');

    Route::post('/login', 'Auth\LoginController@login')->name('login');
    Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

    Route::group(['middleware' => ['auth']], function()
    {
        Route::get('/session', 'UserController@getSessionData')->name('session');

        Route::post('/entry', 'BlogController@add');
        Route::put('/entry/{id}', 'BlogController@update');
        Route::delete('/entry/{id}', 'BlogController@delete');
    });
});

Route::get('/', function () { return view('index'); })->name('home');
