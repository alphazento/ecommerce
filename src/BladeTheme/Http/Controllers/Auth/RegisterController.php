<?php

namespace Zento\BladeTheme\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use ShareBucket;
use Zento\BladeTheme\Facades\BladeTheme;
use Zento\Customer\Model\ORM\Customer;
use Zento\Kernel\Http\Controllers\TraitApiResponse;

class RegisterController extends \App\Http\Controllers\Auth\RegisterController
{
    use TraitApiResponse;

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return BladeTheme::breadcrumb('/register', 'Sign Up')->view('auth.register');
    }

    public function register(Request $request)
    {
        try {
            return parent::register($request);
        } catch (ValidationException $e) {
            if ($request->ajax()) {
                return $this->error(422)->wrapValidationExceptionMessage($e);
            } else {
                throw $e;
            }
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return Customer::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'store_id' => ShareBucket::get('store_id', 0),
        ]);
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        if ($request->ajax()) {
            return $this->withData($user);
        }
    }
}
