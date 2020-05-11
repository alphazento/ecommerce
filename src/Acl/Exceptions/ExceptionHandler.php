<?php

namespace Zento\Acl\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler;

class ExceptionHandler extends Handler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Convert an authentication exception into a response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            if ($exception instanceof AclException) {
                return response()->json([
                    'message' => $exception->getMessage(),
                    'code' => 403,
                ], 200);
            } else {
                return response()->json(['message' => $exception->getMessage()], 401);
            }
        } else {
            return redirect()->guest($exception->redirectTo() ?? route('login'));
        }
    }
}
