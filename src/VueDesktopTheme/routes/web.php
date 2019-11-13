<?php
Route::group(
    [
        'prefix' => '/',
        'namespace' => '\Zento\VueDesktopTheme\Http\Controllers',
        'middleware' => ['web']
    ], function () {
    Route::get(
        '/products', 
        ['as' => 'web.get.products', 'uses' => 'ThemeController@products']
    );
});