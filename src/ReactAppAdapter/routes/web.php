<?php
Route::any('{all}', '\Zento\ReactAppAdapter\Http\Controllers\WebController@appServe')
    ->where('all', '^(?!rest).*$');