<?php
Route::group(
    [
        'namespace' => '\Zento\Backend\Http\Controllers',
        'middleware' => ['adminapi'],
        'prefix' => '/rest/v1/backend',
    ], function() {
    }
);
