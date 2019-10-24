<?php
Route::group(
    [
        'prefix' => '/',
        'namespace' => '\Zento\VueDesktopTheme\Http\Controllers',
        'middleware' => ['web']
    ], function () {
    Route::get(
        '/', 
        ['as' => 'root', 'uses' => 'ThemeController@home']
    );

    Route::get(
        '/home', 
        ['as' => 'home', 'uses' => 'ThemeController@home']
    );

    Route::get(
        '/products', 
        ['as' => 'web.get.products', 'uses' => 'ThemeController@products']
    );

    Route::get(
        'about', 
        ['as' =>'get.about', 'uses' => 'ThemeController@about']
    );

    Route::get(
        'news', 
        ['as' =>'get.news', 'uses' => 'ThemeController@news']
    );

    Route::get(
        'news_c', 
        ['as' =>'get.news_c', 'uses' => 'ThemeController@news_c']
    );

    Route::get(
        'contact', 
        ['as' =>'get.contact', 'uses' => 'ThemeController@contact']
    );

    Route::get(
        'cooperation', 
        ['as' =>'get.cooperation', 'uses' => 'ThemeController@cooperation']
    );
});