<?php

namespace Zento\Customer\Http\Controllers\Api;

use Request;
use Psr\Http\Message\ServerRequestInterface;

class PassportController extends \Zento\Passport\Http\Controllers\Api\ZentoPassportController
{
    public function register(ServerRequestInterface $request) {
      list($customer, $password) = \Zento\Customer\Model\ORM\Customer::createDummyCustomer();
      $user = [
        'username' => $customer->email,
        'password' => $password
      ];
      $parsedBody = $request->getParsedBody();
      if (!isset($parsedBody['client_id'])) {
          if ($configs = config('passport.defaultclient')) {
              $request = $request->withParsedBody(array_merge($user, $configs, $parsedBody));
          }
      }

      $response = parent::issueToken($request);
      return ['status'=>$response->getStatusCode(),
          'data'=>json_decode($response->getContent(), true)];
    }
}