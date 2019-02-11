<?php

namespace Zento\Customer;
use Route;

class Routes implements \Zento\Contracts\RouteRule
{
    public function registerApiRoutes(){
        $apiRoutes = [
            'customers.get.me' => [ 'method' => 'get', 'path' => '/me', 'uses' => 'CustomerController@createCart'],
            'customers.put.me' => [ 'method' => 'put', 'path' =>'/me', 'uses' => 'CustomerController@updateMe'],
            'customers.active.me' => [ 'method' => 'put', 'path' =>'/me/activate', 'uses' => 'CustomerController@activateMe'],
            'customers.get.customer' => [ 'method' => 'get', 'path' =>'/{customer_id}', 'uses' => 'CustomerController@getCustomer'],
            'customers.put.customer' => [ 'method' => 'put', 'path' =>'/{customer_id}', 'uses' => 'CustomerController@setCustomer'],
            'customers.active.customer' => [ 'method' => 'put', 'path' =>'/{customer_id}', 'uses' => 'CustomerController@activateCustomer'],
        ];
        Route::group(
            [
                'prefix' => '/rest/v1/customers',
                'namespace' => '\Zento\Customer\Http\Controllers\Api',
                'middleware' => ['setuppassport', 'auth:api']
            ], function () use ($apiRoutes) {
                foreach ($apiRoutes as $name => $route) {
                    if ($route['allow_guest'] ?? false) {
                        Route::{$route['method']}(
                        $route['path'],
                        ['as' => $name, 'uses' => $route['uses']]
                    );
                    }
                }
            });
    }

    public function registerFrontWebRoutes(){

    }

    public function registerAdminWebRoutes(){

    }
}