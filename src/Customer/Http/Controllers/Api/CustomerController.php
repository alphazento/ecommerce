<?php

namespace Zento\Customer\Http\Controllers\Api;

use Route;
use Request;
use Response;
use Auth;

use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Zento\Customer\Model\ORM\Customer;
use Zento\Customer\Providers\Facades\CustomerService;

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

    public function activateMe() {
      if (CustomerService::activate(Auth::user())) {
          return ['status'=>200];
      } else {
          return ['status'=>400];
      }
    }

    public function deactivateMe() {
      if (CustomerService::deactivate(Auth::user())) {
          return ['status'=>200];
      } else {
          return ['status'=>400];
      }
    }

    public function activateCustomer() {
      return $this->tapAcl(function() {
        if ($customer = Customer::find(Route::input('customer_id'))){
          if (CustomerService::activate($customer)) {
              return ['status'=>200];
          } else {
              return ['status'=>400];
          }
        } else {
          return ['status'=>404, 'data'=> null];
        }
      });
    }

    public function deactivateCustomer() {
      return $this->tapAcl(function() {
        if ($customer = Customer::find(Route::input('customer_id'))){
          if (CustomerService::deactivate($customer)) {
              return ['status'=>200];
          } else {
              return ['status'=>400];
          }
        } else {
          return ['status'=>404, 'data'=> null];
        }
      });
    }

    public function setMyPassword() {
      Request::validate(['password'=>"string|max:8"]);

      if (CustomerService::setPassword(Auth::user(), Request::get('password'))) {
          return ['status'=>200];
      } else {
          return ['status'=>400];
      }
    }

    public function setCustomerPassword() {
      return $this->tapAcl(function() {
        Request::validate(['password'=>"string|max:8"]);
        if ($customer = Customer::find(Route::input('customer_id'))) {
          if (CustomerService::setPassword(Auth::user(), Request::get('password'))) {
              return ['status'=>200];
          } else {
              return ['status'=>400];
          }
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