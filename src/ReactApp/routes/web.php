<?php
Route::get('{all}', '\Zento\ReactApp\Http\Controllers\WebController@appServe')
    ->where('all', '^(?!rest).*$');