<?php

namespace Zento\Passport\Http\Controllers;

use Auth;
use Request;
use Psr\Http\Message\ServerRequestInterface;
use Zento\Passport\Model\GoogleOAuthConnect;
use Zento\Passport\Http\Middleware\GuestToken as GuestTokenMiddleware;
use Zento\Kernel\Http\Controllers\TraitApiResponse;

class ApiController extends \Laravel\Passport\Http\Controllers\AccessTokenController
{
    use TraitApiResponse;

    protected $isRegistering = false;

    public function apiHttpOptions(ServerRequestInterface $request) {
        return '';
    }
    
    public function issueToken(ServerRequestInterface $request)
    {
        $parsedBody = $request->getParsedBody();
        if (!isset($parsedBody['client_id'])) {
            if ($configs = config('passport.defaultclient')) {
                $request = $request->withParsedBody(array_merge($configs, $parsedBody));
            }
        }
        $response = parent::issueToken($request);
        return $this->response([
                'code'=>$response->getStatusCode(),
                'data'=>json_decode($response->getContent(), true)
            ]
        );
    }

    public function refreshToken(ServerRequestInterface $request)
    {
        $parsedBody = $request->getParsedBody();
        if (!isset($parsedBody['client_id'])) {
            if ($configs = config('passport.defaultclient')) {
                $configs['grant_type'] = 'refresh_token';
                $request = $request->withParsedBody(array_merge($configs, $parsedBody));
            }
        }
        $response = parent::issueToken($request);
        return $this->response([
                'code'=>$response->getStatusCode(),
                'data'=>json_decode($response->getContent(), true)
            ]
        );
    }
    
    public function register(ServerRequestInterface $request) {
        $this->isRegistering = true;
        $userModel = config('auth.providers.users.model', \Zento\Passport\Model\User::class);

        //must use app('request') for innerapi request
        $appRequest = app('request');
        $appRequest->validate([
            'name' => 'required|string|max:128',
            'username' => sprintf('required|string|email|max:255|unique:%s,email', (new $userModel)->getTable()),
            'password' => 'required|string|min:8'
        ]);
     
        $customerAttrs = $appRequest->all();
        $customerAttrs['password'] = bcrypt($customerAttrs['password']);
        $customerAttrs['email'] = $customerAttrs['username'];
        $customer = $userModel::create($customerAttrs);
        if ($customer) {
            return $this->issueToken($request);
        }
        return $this->error(400, 'fail to create customer');
    }

    public function logout()
    {
        Auth::user()->token()->revoke();
        return $this->success();
    }

    public function profile() {
        return $this->withData(Auth::user());
    }

    /**
     * generate a guest token
     *
     * @return void
     */
    public function guestToken() {
        if ($user = GuestTokenMiddleware::prepareGuestForApi(Request::instance())) {
            return $this->with('access_token', encrypt(json_encode($user->toArray())))
                ->with('token_type', 'Guest');
        } else {
            return $this->error(401);
        }
    }
}
