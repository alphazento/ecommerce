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
      Request::validate(['old_password'=>"string|max:8", 'new_password'=>"string|max:8"]);

      if (CustomerService::changePassword(Auth::user(), Request::get('old_password'), Request::get('new_password'))) {
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

    public function addMyAddress() {
      return $this->addAddress(Auth::user());
    }

    public function addCustomerAddress() {
      if ($customer = Customer::find(Route::input('customer_id'))) {
          return $this->addAddress($customer);
      } else {
        return ['status'=>404, 'data'=> 'customer not found'];
      }
    }

    protected function addAddress($user) {
      return $this->tapAcl(function() use ($user) {
        Request::validate([
          'firstname'=>"required|string|max:80",
          'middlename'=>"string|max:80|nullable",
          'lastname'=>"required|string|max:80",
          'company'=>"string|max:128|nullable",
          'address1'=>"required|string|max:255",
          'address2'=>"string|max:255|nullable",
          'city'=>"required|string|max:64",
          'country'=>"required|string|max:64",
          'postal_code'=>"required|string|max:16",
          'state'=>"required|string|max:32",
          'phone'=>"required|string|max:32"
        ]);

        if ($address = CustomerService::addAddress($user, Request::all())) {
            return ['status'=>200, 'data'=>$address];
        } else {
            return ['status'=>400];
        }
      });
    }

    public function getMyAddresses() {
      if ($collection = CustomerService::getCustomerAddresses(Auth::user()->id)) {
        return ['status'=>200, 'data'=> $collection];
      } else {
        return ['status'=>200, 'data'=> []];
      }
    }

    public function getMyAddress() {
      if ($address = CustomerService::getCustomerAddress(Auth::user()->id, Route::input('id'))) {
        return ['status'=>200, 'data'=> $address];
      } else {
        return ['status'=>200, 'data'=> null];
      }
    }

    public function setMyDefaultBillingAddress() {
      if (CustomerService::setDefaultBillingAddress(Auth::user(), Route::input('id'))) {
        return ['status'=>200, 'data'=> null];
      } else {
        return ['status'=>400, 'data'=> 'Fail to set default billing address'];
      }
    }

    public function setMyDefaultShippingAddress() {
      if (CustomerService::setDefaultShippingAddress(Auth::user(), Route::input('id'))) {
        return ['status'=>200, 'data'=> null];
      } else {
        return ['status'=>400, 'data'=> 'Fail to set default billing address'];
      }
    }


    protected function tapAcl(\Closure $callbak) {
      if (Auth::user()->acl(Request::route()->getName())) {
          return \call_user_func($callbak);
      } else {
          return ['status'=>400, 'data'=> ['error'=>'ACL limit']];
      }
    }
}