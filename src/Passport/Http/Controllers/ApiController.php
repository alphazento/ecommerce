<?php

namespace Zento\Passport\Http\Controllers;

use Auth;
use Psr\Http\Message\ServerRequestInterface;
use Request;
use Zento\Kernel\Http\Controllers\TraitApiResponse;
use Zento\Passport\Consts;
use Zento\Passport\Http\Middleware\GuestToken as GuestTokenMiddleware;

class ApiController extends \Laravel\Passport\Http\Controllers\AccessTokenController
{
    use TraitApiResponse;

    protected $isRegistering = false;

    public function apiHttpOptions(ServerRequestInterface $request)
    {
        return '';
    }

    /**
     * issue client token
     * @group Passport
     * @bodyParam username string required
     * @bodyParam password string required
     * @response {
     * "token_type": "Bearer",
     * "expires_in": 1296000,
     * "access_token": ""
     * "refresh_token": ""
     * }
     * @response 401{
     * }
     */
    public function issueToken(ServerRequestInterface $request)
    {
        $parsedBody = $request->getParsedBody();
        if (!isset($parsedBody['client_id'])) {
            if ($configs = config(Consts::CONFIG_KEY_PASSPORT_DEFAULT_CLIENT)) {
                $request = $request->withParsedBody(array_merge($configs, $parsedBody));
            }
        }
        $response = parent::issueToken($request);
        return $this->response([
            'code' => $response->getStatusCode(),
            'data' => json_decode($response->getContent(), true),
        ]
        );
    }

    /**
     * refresh a client token
     * @group Passport
     */
    public function refreshToken(ServerRequestInterface $request)
    {
        $parsedBody = $request->getParsedBody();
        if (!isset($parsedBody['client_id'])) {
            if ($configs = config(Consts::CONFIG_KEY_PASSPORT_DEFAULT_CLIENT)) {
                $configs['grant_type'] = 'refresh_token';
                $request = $request->withParsedBody(array_merge($configs, $parsedBody));
            }
        }
        $response = parent::issueToken($request);
        return $this->response([
            'code' => $response->getStatusCode(),
            'data' => json_decode($response->getContent(), true),
        ]
        );
    }

    /**
     * register a Passport user
     * @group Passport
     * @bodyParam username string required email, max255
     * @bodyParam password string required min 8
     * @bodyParam name string required max 128
     * @response {
     * "token_type": "Bearer",
     * "expires_in": 1296000,
     * "access_token": ""
     * "refresh_token": ""
     * }
     */
    public function register(ServerRequestInterface $request)
    {
        $this->isRegistering = true;
        $userModel = config('auth.providers.users.model', \Zento\Passport\Model\User::class);

        //must use app('request') for innerapi request
        $appRequest = app('request');
        $appRequest->validate([
            'name' => 'required|string|max:128',
            'username' => sprintf('required|string|email|max:255|unique:%s,email', (new $userModel)->getTable()),
            'password' => 'required|string|min:8',
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

    /**
     * logout current Passport user
     * @group Passport
     */
    public function logout()
    {
        Auth::user()->token()->revoke();
        return $this->success();
    }

    /**
     * get current passport user's profile
     * @group Passport
     */
    public function profile()
    {
        return $this->withData(Auth::user());
    }

    /**
     * generate a guest token to support some business
     * @group Passport
     * @return void
     */
    public function guestToken()
    {
        if ($user = GuestTokenMiddleware::prepareGuestForApi(Request::instance())) {
            return $this->with('access_token', encrypt(json_encode($user->toArray())))
                ->with('token_type', 'Guest');
        } else {
            return $this->error(401);
        }
    }
}
