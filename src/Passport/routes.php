<?php

Route::post(
  '/oauth/zento_token', 
  ['uses' => '\Zento\Passport\Http\Controllers\ZentoPassportController@issueToken']
);
