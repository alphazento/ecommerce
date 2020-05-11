<?php

namespace Zento\Customer\Http\Controllers\Api;

use Auth;
use Request;
use Response;
use Route;
use Zento\Customer\Model\ORM\Customer;
use Zento\Customer\Providers\Facades\CustomerService;
use Zento\Kernel\Http\Controllers\ApiBaseController;

class CustomerController extends ApiBaseController
{
    protected function _retrieveCustomer()
    {
        return Auth::user();
    }

    /**
     * Get current customer
     * @group Customer
     * @responseModel \Zento\Customer\Model\ORM\Customer
     */
    public function me()
    {
        return $this->withData(Auth::user());
    }

    /**
     * Set current customer's password
     * @group Customer
     * @queryParam old_password required old password min 8
     * @queryParam new_password required new password min 8
     */
    public function setPassword()
    {
        Request::validate(['old_password' => "string|min:8", 'new_password' => "string|min:8"]);

        if (CustomerService::changePassword(Auth::user(), Request::get('old_password'), Request::get('new_password'))) {
            return $this->success();
        } else {
            return $this->error(400);
        }
    }

    /**
     * update customer's details, except email and password
     * @group Customer
     * @urlParam required string customer_id
     * @bodyParam required Json customer's attributes
     * @responseModel \Zento\Customer\Model\ORM\Customer
     */
    public function update()
    {
        if ($customer = $this->_retrieveCustomer()) {
            $attrs = Request::except(['email', 'password']);
            foreach ($attrs as $key => $value) {
                $customer->{$key} = $value;
            }
            $customer->save();
            return $this->withData($customer);
        } else {
            return $this->error(404);
        }
    }

    /**
     * add address
     * @group Customer
     */
    public function addAddress()
    {
        Request::validate([
            'name' => "required|string|max:255",
            'company' => "string|max:255|nullable",
            'address1' => "required|string|max:255",
            'address2' => "string|max:255|nullable",
            'city' => "required|string|max:64",
            'country' => "required|string|max:64",
            'postal_code' => "required|string|max:16",
            'state' => "required|string|max:32",
            'phone' => "required|string|max:32",
        ]);

        if ($user = $this->_retrieveCustomer()) {
            if ($address = CustomerService::addAddress($user, Request::all())) {
                return $this->success(201)->withData($address);
            }
        }
        return $this->error();
    }

    /**
     * get current user all address
     * @group Customer
     */
    public function getAddresses()
    {
        if ($collection = CustomerService::getCustomerAddresses(Auth::user()->id)) {
            return $this->withData($collection);
        } else {
            return $this->success(200, 'no address found.');
        }
    }

    /**
     * get address by id
     * @group Customer
     */
    public function getAddress()
    {
        if ($address = CustomerService::getCustomerAddress(Auth::user()->id,
            Route::input('address_id'))) {
            return $this->withData($address);
        } else {
            return $this->success(200, 'no address found.');
        }
    }

    /**
     * set current user default billing address
     * @group Customer
     */
    public function setDefaultBillingAddress()
    {
        if (CustomerService::setDefaultBillingAddress($this->_retrieveCustomer(), Route::input('address_id'))) {
            return $this->success();
        } else {
            return $this->error(400, 'Fail to set default billing address');
        }
    }

    /**
     * set current user default shipping address
     * @group Customer
     */
    public function setDefaultShippingAddress()
    {
        if (CustomerService::setDefaultShippingAddress($this->_retrieveCustomer(), Route::input('address_id'))) {
            return $this->success();
        } else {
            return $this->error(400, 'Fail to set default billing address');
        }
    }
}
