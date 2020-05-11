<?php

namespace Zento\Customer\Services;

use Zento\Customer\Model\ORM\Customer;
use Zento\Customer\Model\ORM\CustomerAddress;

class CustomerService
{
    public function find($id)
    {
        return Customer::find($id);
    }

    public function findByEmail($email)
    {
        return Customer::where('email', $email)->first();
    }

    public function activate(\Illuminate\Foundation\Auth\User $user)
    {
        $user->active = true;
        return $user->update();
    }

    public function deactivate(\Illuminate\Foundation\Auth\User $user)
    {
        $user->active = false;
        return $user->update();
    }

    public function setPassword(\Illuminate\Foundation\Auth\User $user, string $password)
    {
        $user->password = bcrypt($password);
        return $user->update();
    }

    public function changePassword(\Illuminate\Foundation\Auth\User $user, string $oldPassword, string $newPassword)
    {
        $user->password = bcrypt($newPassword);
        return $user->update();
    }

    public function addAddress(\Illuminate\Foundation\Auth\User $user, array $address_attributes)
    {
        $address_attributes['customer_id'] = $user->id;
        $address = new CustomerAddress($address_attributes);
        if ($existAddress = CustomerAddress::where('hash', $address->uniqueHash())->where('active', 1)->first()) {
            return $existAddress;
        } else {
            $address->save();
            return $address;
        }
    }

    public function setDefaultBillingAddress(\Illuminate\Foundation\Auth\User $user, $address_id)
    {
        if ($address = CustomerAddress::find($address_id)) {
            if ($address->customer_id == $user->id) {
                $user->default_billing_address_id = $address_id;
                $user->update();
                return true;
            }
        }
        return false;
    }

    public function setDefaultShippingAddress(\Illuminate\Foundation\Auth\User $user, $address_id)
    {
        if ($address = CustomerAddress::find($address_id)) {
            if ($address->customer_id == $user->id) {
                $user->default_shipping_address_id = $address_id;
                $user->update();
                return true;
            }
        }
        return false;
    }

    public function updateCustomerAddress($address_id, array $address_attributes)
    {
        if ($address = CustomerAddress::find($address_id)) {
            unset($address_attributes['id']);
            unset($address_attributes['customer_id']);
        }
    }

    public function getCustomerAddresses($customer_id, $only_active = true)
    {
        return CustomerAddress::where('customer_id', $customer_id)
            ->whereIn('active', $only_active ? [1] : [0, 1])
            ->get();
    }

    public function getCustomerAddress($customer_id, $address_id, $only_active = true)
    {
        return CustomerAddress::where('customer_id', $customer_id)
            ->where('id', $address_id)
            ->whereIn('active', $only_active ? [1] : [0, 1])
            ->first();
    }
}
