<?php

Route::group(['prefix' => 'api', 'as' => 'blog.entry.'], function()
{
    Route::get('/entry', 'BlogController@get')->name('get');

    Route::group(['middleware' => ['auth']], function()
    {
        Route::get('/delete/{id}', 'BlogController@delete')->name('delete');
        Route::post('/add', 'BlogController@add')->name('add');
    });

});

Route::get('/', function ()
{
    return view('blog.entries');
})->name('home');

Route::post('/login', 'Auth\LoginController@login')->name('login');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
