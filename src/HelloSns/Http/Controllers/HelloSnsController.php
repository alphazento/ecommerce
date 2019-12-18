<?php

namespace Zento\HelloSns\Http\Controllers;


use Auth;
use Socialite;
use Illuminate\Http\Request;
use Zento\HelloSns\Facades\HelloSnsService;
use Zento\Kernel\Http\Controllers\ApiBaseController;

class HelloSnsController extends ApiBaseController
{
    protected function accountConnect(Request $request, $grantTyep) {
        if ($network = $request->input('network')) {
            if ($authResponse = $request->input('authResponse')) {
                if ($token = $authResponse['access_token']) {
                    if ($user = Socialite::driver($network)->userFromToken($token)) {
                        if ($grantTyep === 'token') {
                            return HelloSnsService::connectApiUser($user, $network);
                        } else {
                            return HelloSnsService::connectSessionUser($user, $network);
                        }
                    }
                }
            }
        }
        return $this->error(422, 'Invalid parameters.');
    }

    public function tokenAccountConnect(Request $request) {
        return $this->accountConnect($request, 'token');
    }

    public function sessionAccountConnect(Request $request) {
        return $this->accountConnect($request, 'session');
    }
}
