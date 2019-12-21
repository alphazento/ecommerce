<?php
Route::group(
    [
        'prefix' => '/payment/',
        'namespace' => '\Zento\PaymentGateway\Http\Controllers',
        'middleware' => ['web']
    ], function () {
        Route::post(
            '/prepayment/{method}', 
            ['as'=>'payment.pre', 'uses'=>'UtilityController@prePayment']
        );
        Route::post(
            '/cancelpay/{method}', 
            ['as'=>'payment.cancel', 'uses'=>'UtilityController@cancelPayment']
        );
        Route::post(
            '/postpay/{method}/{token}', 
            ['as'=>'payment.postpay', 'uses'=>'UtilityController@postPayment']
        );
        Route::get(
            '/postpay/{method}/{token}', 
            ['as'=>'payment.postpay', 'uses'=>'UtilityController@postPayment']
        );
    }
);