<?php

namespace Zento\Customer\Services;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Zento\Customer\Model\ORM\Customer;

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
}