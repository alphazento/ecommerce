<?php

namespace Zento\Customer\Http\Controllers\Api;

use Request;
use Psr\Http\Message\ServerRequestInterface;

class PassportController extends \Zento\Passport\Http\Controllers\Api\ZentoPassportController
{
    public function getOrCreateGuest(ServerRequestInterface $request) {
      if ($uuid = Request::header('Guest-Uuid')) {
        if (strlen($uuid) > 36) {
          list($customer, $password) = \Zento\Customer\Model\ORM\Customer::requestDummyCustomer($uuid);
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
    
          return $this->issueToken($request);
        }
      }
      return ['status'=>420,
        'data'=>'Fail to Create Guest'];
    }
}