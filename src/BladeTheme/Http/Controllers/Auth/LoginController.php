<?php

namespace Zento\BladeTheme\Http\Controllers\Auth;

use Zento\BladeTheme\Facades\BladeTheme;
use Zento\Kernel\Http\Controllers\TraitApiResponse;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends \App\Http\Controllers\Auth\LoginController
{
    use TraitApiResponse;

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return BladeTheme::breadcrumb('/login', 'Sign In')->view('auth.login');
    }

    public function login(Request $request) {
        try {
            return parent::login($request);
        } catch (ValidationException $e) {
            if($request->ajax()){
                return $this->error(422)->wrapValidationExceptionMessage($e);
            } else {
                throw $e;
            }
        }
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        if($request->ajax()){
            return $this->withData($user);
        }
    }
}
