<?php

namespace Zento\Customer\Services;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Zento\Customer\Model\ORM\Customer;
use Zento\Customer\Model\ORM\CustomerAddress;

class CustomerService
{
  public function find($id) {
    return Customer::find($id);
  }

  public function findByEmail($email) {
    return Customer::where('email', $email)->first();
  }

  public function activate(\Illuminate\Foundation\Auth\User $user) {
    $user->is_active = true;
    return $user->update();
  }

  public function deactivate(\Illuminate\Foundation\Auth\User $user) {
    $user->is_active = false;
    return $user->update();
  }

  public function setPassword(\Illuminate\Foundation\Auth\User $user, string $password) {
    $user->password = bcrypt($password);
    return $user->update();
  }

  public function changePassword(\Illuminate\Foundation\Auth\User $user, string $oldPassword, string $newPassword) {
    $user->password = bcrypt($newPassword);
    return $user->update();
  }

  public function addAddress(\Illuminate\Foundation\Auth\User $user, array $address_attributes) {
      return CustomerAddress::create($address_attributes);
  }

  public function setDefaultBillingAddress(\Illuminate\Foundation\Auth\User $user, $address_id) {
    if ($address = CustomerAddress::find($address_id)) {
      if($address->customer_id == $user->id) {
        $user->default_billing_address_id = $address_id;
        return true;
      }
    }
    return false;
  }

  public function setDefaultShippingAddress(\Illuminate\Foundation\Auth\User $user, $address_id) {
    if ($address = CustomerAddress::find($address_id)) {
      if($address->customer_id == $user->id) {
        $user->default_shipping_address_id = $address_id;
        return true;
      }
    }
    return false;
  }

  public function updateCustomerAddress($address_id, array $address_attributes) {
    if ($address = CustomerAddress::find($address_id)) {
      unset($address_attributes['id']);
      unset($address_attributes['customer_id']);
    }
  }
}