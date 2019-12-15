<?php

namespace Zento\BladeTheme\Http\Controllers\Auth;

use Zento\BladeTheme\Facades\BladeTheme;

class ResetPasswordController extends \App\Http\Controllers\Auth\ResetPasswordController
{
    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string|null  $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showResetForm(Request $request, $token = null)
    {
        return BladeTheme::view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }
}
