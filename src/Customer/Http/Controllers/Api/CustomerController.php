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
    protected function isMe() {
      return Route::input('customer_id') === 'me';
    }

    protected function _retrieveCustomer() {
      return $this->isMe() ? Auth::user() : Customer::find(Route::input('customer_id'));
    }

    public function getCustomer() {
      return $this->tapAcl(function() {
        if ($customer = $this->_retrieveCustomer()){
          return ['status'=>200, 'data'=> $customer];
        } else {
          return ['status'=>404, 'data'=> null];
        }
      });
    }

    public function activateCustomer() {
      return $this->tapAcl(function() {
        if ($customer = $this->_retrieveCustomer()){
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
        if ($customer = $this->_retrieveCustomer()){
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

    public function addAddress() {
      return $this->tapAcl(function() {
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

        if ($user = $this->_retrieveCustomer()) {
          if ($address = CustomerService::addAddress($user, Request::all())) {
              return ['status'=>201, 'data'=>$address];
          }
        }
        return ['status'=>400];
      });
    }

    public function getAddresses() {
      return $this->tapAcl(function() {
          if ($collection = CustomerService::getCustomerAddresses($this->isMe() ? Auth::user()->id : Route::input('customer_id'))) {
              return ['status'=>200, 'data'=> $collection];
          } else {
              return ['status'=>200, 'data'=> []];
          }
      });
    }

    public function getAddress() {
      return $this->tapAcl(function() {
        if ($address = CustomerService::getCustomerAddress($this->isMe() ? Auth::user()->id : Route::input('customer_id'), Route::input('address_id'))) {
          return ['status'=>200, 'data'=> $address];
        } else {
          return ['status'=>200, 'data'=> null];
        }
      });
    }

    public function setDefaultBillingAddress() {
      return $this->tapAcl(function() {
        if (CustomerService::setDefaultBillingAddress($this->_retrieveCustomer(), Route::input('address_id'))) {
          return ['status'=>200, 'data'=> null];
        } else {
          return ['status'=>400, 'data'=> 'Fail to set default billing address'];
        }
      });
    }

    public function setDefaultShippingAddress() {
      return $this->tapAcl(function() {
        if (CustomerService::setDefaultShippingAddress($this->_retrieveCustomer(), Route::input('address_id'))) {
            return ['status'=>200, 'data'=> null];
        } else {
            return ['status'=>400, 'data'=> 'Fail to set default billing address'];
        }
      });
    }

    protected function tapAcl(\Closure $callbak) {
      if (Auth::user()->crossUserAcl($this->isMe())) {
          return \call_user_func($callbak);
      } else {
          return ['status'=>400, 'data'=> ['error'=>'ACL limit']];
      }
    }
}