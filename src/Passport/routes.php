<?php

Route::post(
  '/rest/v1/oauth/zento_token', 
  ['uses' => '\Zento\Passport\Http\Controllers\ZentoPassportController@issueToken']
)->middleware('cors');
