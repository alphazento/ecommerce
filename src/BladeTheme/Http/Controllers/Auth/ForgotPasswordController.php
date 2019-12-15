<?php

namespace Zento\BladeTheme\Http\Controllers\Auth;

use Zento\BladeTheme\Facades\BladeTheme;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends \App\Http\Controllers\Auth\ForgotPasswordController
{
    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm()
    {
        return BladeTheme::view('auth.passwords.email');
    }
}
