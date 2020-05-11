<?php

namespace Zento\BladeTheme\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Zento\BladeTheme\Facades\BladeTheme;
use Zento\Kernel\Http\Controllers\TraitApiResponse;

class ForgotPasswordController extends \App\Http\Controllers\Auth\ForgotPasswordController
{
    use TraitApiResponse;
    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm()
    {
        return BladeTheme::view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        try {
            return parent::sendResetLinkEmail($request);
        } catch (ValidationException $e) {
            if ($request->ajax()) {
                return $this->error(422)->wrapValidationExceptionMessage($e);
            } else {
                throw $e;
            }
        }
    }

    /**
     * Get the response for a successful password reset link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkResponse(Request $request, $response)
    {
        if ($request->ajax()) {
            return $this->success(200, trans($response));
        } else {
            return parent::sendResetLinkResponse($request, $response);
        }
    }

    /**
     * Get the response for a failed password reset link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        if ($request->ajax()) {
            return $this->error(422, trans($response));
        } else {
            return parent::sendResetLinkFailedResponse($request, $response);
        }
    }
}
