<?php

namespace Zento\Passport\Model;

use Config;
use Request;
use Zento\Passport\Passport;
use Psr\Http\Message\ServerRequestInterface;

class GoogleOAuthConnect {
  public function googleOauthConnectPassport(ServerRequestInterface $request, $issuer) {
    $user = Request::get('user');
    if ($this->verifyGoogleToken($user['idToken'], $user['id'])) {
        if ($token= Passport::issueTokenWithouPasswordInPasswordGrantType($request, $user['email'], $issuer)) {
            return $token;
        }
    }
    return response('not authed', 401);
  }

  /**
   * validate google account with remote server
   *
   * @param string $token
   * @param string $userid
   * @return void
   */
  protected function verifyGoogleToken($token, $userid) {
    // $client_id = Config::get(Consts::GOOGLE_ACCOUNT_CLIENT_ID);
    $client_id = '212041113546-ujdudnc4j4a7hrgd6fittjr7rvvs3cfd.apps.googleusercontent.com';

    $client = new \Google_Client(['client_id' => $client_id]);
    // Specify the CLIENT_ID of the app that accesses the backend
    $payload = $client->verifyIdToken($token);
    if ($payload) {
      return $userid == $payload['sub'];
    }
    return false;
  }
}