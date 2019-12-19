<?php
Route::group(
    [
        'namespace' => '\Zento\Backend\Http\Controllers\Web',
        'middleware' => ['backend'],
        'prefix' => '/admin',
        'as' => 'admin:system:'
    ], function() {
        Route::get(
            '/', 
            ['as' => 'admin.home', 'uses' => 'SupportController@index']
        );
    }
);
