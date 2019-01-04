<?php
Route::group(
    [
        'namespace' => '\Zento\Backend\Http\Controllers',
        'middleware' => ['adminapi'],
        'prefix' => '/backend/rest/v1/',
    ], function() {
    }
);
