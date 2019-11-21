<?php

namespace Zento\Passport\Http\Controllers;

use Auth;
use Request;
use Psr\Http\Message\ServerRequestInterface;
use Zento\Passport\Model\GoogleOAuthConnect;
use Zento\Passport\Http\Middleware\GuestToken as GuestTokenMiddleware;
use Zento\Kernel\Http\Controllers\TraitApiResponse

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

    public function issueTokenConnectGoogle(ServerRequestInterface $request) {
        return (new GoogleOAuthConnect)->googleOauthConnectPassport($request, $this);
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

        // Request::validate([
        //     'name' => 'required|string|max:255',
        //     'username' => sprintf('required|string|email|max:255|unique:%s,email', (new $userModel)->getTable()),
        //     'password' => 'required|string|min:6'
        // ]);
     
        $customerAttrs = Request::all();
        $customerAttrs['password'] = bcrypt($customerAttrs['password']);
        $customerAttrs['store_id'] = 0;
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

    public function guestToken() {
        //if has session
        if ($user = GuestTokenMiddleware::prepareGuestForApi(Request::instance())) {
            return $this->with('access_token', encrypt(json_encode($user->toArray())))
                ->with('token_type', 'Guest');
        } else {
            return $this->error(401);
        }
    }
}
