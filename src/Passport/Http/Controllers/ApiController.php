<?php

namespace Zento\Passport\Http\Controllers;

use Auth;
use Request;
use Psr\Http\Message\ServerRequestInterface;
use Zento\Passport\Model\GoogleOAuthConnect;

class ApiController extends \Laravel\Passport\Http\Controllers\AccessTokenController
{
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
        return ['status'=>$response->getStatusCode(),
            'data'=>json_decode($response->getContent(), true)];
    }

    public function issueTokenConnectGoogle(ServerRequestInterface $request) {
        return (new GoogleOAuthConnect)->googleOauthConnectPassport($request);
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
        return ['status'=>$response->getStatusCode(),
            'data'=>json_decode($response->getContent(), true)];
    }

    public function register(ServerRequestInterface $request) {
        $this->isRegistering = true;
        $userModel = config('auth.providers.users.model', \Zento\Passport\Model\User::class);

        // Request::validate([
        //     'firstname' => 'required|string|max:64',
        //     'middlename' => 'string|max:64',
        //     'lastname' => 'required|string|max:64',
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
        return ['status'=>420, 'data' => 'fail to create customer'];
    }

    public function logout()
    {
        Auth::user()->token()->revoke();
        return ['status'=>200, 'data' => 'Successfully logged out'];
    }

    public function profile() {
        return ['status' => 200, 'data' => Auth::user()];
    }
}
