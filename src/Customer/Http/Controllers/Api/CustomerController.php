<?php

namespace Zento\Customer\Http\Controllers\Api;

use Route;
use Request;
use Response;
use Auth;

use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Zento\Customer\Model\ORM\Customer;

class CustomerController extends \App\Http\Controllers\Controller
{
    public function me() {
        return ['status'=>200, 'data'=> Auth::user()];
    }


    public function getCustomer() {
      return $this->tapAcl(function() {
        if ($customer = Customer::find(Route::input('customer_id'))){
          return ['status'=>200, 'data'=> $customer];
        } else {
          return ['status'=>404, 'data'=> null];
        }
      });
    }

    protected function tapAcl(\Closure $callbak) {
      if (Auth::user()->acl(Request::route()->getName())) {
          return \call_user_func($callbak);
      } else {
          return ['status'=>400, 'data'=> ['error'=>'ACL limit']];
      }
    }
}