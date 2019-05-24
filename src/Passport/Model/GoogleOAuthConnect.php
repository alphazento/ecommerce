<?php

namespace Zento\Passport\Model;

use Config;
use Zento\Passport\Passport;

class GoogleOAuthConnect {
  public function googleOauthConnectPassport(ServerRequestInterface $request) {
    $user = Request::get('user');
    if ($this->verifyGoogleToken($user['idToken'], $user['id'])) {
        if ($token= Passport::issueTokenWithouPasswordInPasswordGrantType($request, $user['email'])) {
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
    $client_id = Store::getConfig(Consts::GOOGLE_ACCOUNT_CLIENT_ID);
    $client_id = '624796833023-clhjgupm0pu6vgga7k5i5bsfp6qp6egh.apps.googleusercontent.com';

    $client = new \Google_Client(['client_id' => $client_id]);
    // Specify the CLIENT_ID of the app that accesses the backend
    $payload = $client->verifyIdToken($token);
    if ($payload) {
      return $userid == $payload['sub'];
    }
    return false;
  }
}