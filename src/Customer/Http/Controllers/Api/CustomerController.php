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
use Zento\Kernel\Http\Controllers\ApiBaseController;

class CustomerController extends ApiBaseController
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
          return $this->withData($customer);
        } else {
          return $this->error(404);
        }
      });
    }
    public function activateCustomer() {
      return $this->tapAcl(function() {
        if ($customer = $this->_retrieveCustomer()){
          if (CustomerService::activate($customer)) {
              return $this->success();
          } else {
            return $this->error(400);
          }
        } else {
          return $this->error(404);
        }
      });
    }

    public function deactivateCustomer() {
      return $this->tapAcl(function() {
        if ($customer = $this->_retrieveCustomer()){
          if (CustomerService::deactivate($customer)) {
            return $this->success();
          } else {
            return $this->error(400);
          }
        } else {
          return $this->error(404);
        }
      });
    }

    public function setMyPassword() {
      Request::validate(['old_password'=>"string|max:8", 'new_password'=>"string|max:8"]);

      if (CustomerService::changePassword(Auth::user(), Request::get('old_password'), Request::get('new_password'))) {
          return $this->success();
      } else {
          return $this->error(400);
      }
    }

    public function setCustomerPassword() {
      return $this->tapAcl(function() {
        Request::validate(['password'=>"string|max:8"]);
        if ($customer = Customer::find(Route::input('customer_id'))) {
          if (CustomerService::setPassword(Auth::user(), Request::get('password'))) {
            return $this->success();
          } else {
            return $this->error(400);
          }
        } else {
          return $this->error(404);
        }
      });
    }

    public function addAddress() {
      return $this->tapAcl(function() {
        Request::validate([
          'name'=>"required|string|max:255",
          'company'=>"string|max:255|nullable",
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
            return $this->success(201)->withData($address);
          }
        }
        return $this->error();
      });
    }

    public function getAddresses() {
      return $this->tapAcl(function() {
          if ($collection = CustomerService::getCustomerAddresses($this->isMe() ? Auth::user()->id : Route::input('customer_id'))) {
            return $this->withData($collection);
          } else {
            return $this->success(200, 'no address found.');
          }
      });
    }

    public function getAddress() {
      return $this->tapAcl(function() {
        if ($address = CustomerService::getCustomerAddress($this->isMe() ? Auth::user()->id : Route::input('customer_id'), Route::input('address_id'))) {
          return $this->withData($address);
        } else {
          return $this->success(200, 'no address found.');
        }
      });
    }

    public function setDefaultBillingAddress() {
      return $this->tapAcl(function() {
        if (CustomerService::setDefaultBillingAddress($this->_retrieveCustomer(), Route::input('address_id'))) {
          return $this->success();
        } else {
          return $this->error(400, 'Fail to set default billing address');
        }
      });
    }

    public function setDefaultShippingAddress() {
      return $this->tapAcl(function() {
        if (CustomerService::setDefaultShippingAddress($this->_retrieveCustomer(), Route::input('address_id'))) {
          return $this->success();
        } else {
          return $this->error(400, 'Fail to set default billing address');
        }
      });
    }

    protected function tapAcl(\Closure $callbak) {
      if (Auth::user()->crossUserAcl($this->isMe())) {
          return \call_user_func($callbak);
      } else {
          return $this->error(400, 'ACL limit');
      }
    }
}