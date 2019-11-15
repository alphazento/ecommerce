<?php

namespace Zento\Passport\Mixins;

use Illuminate\Support\Str;

class RequestGuestToken {
    public function guestToken() {
       return function()
       {
           $header = $this->header('Authorization', '');
           if (Str::startsWith($header, 'Guest ')) {
               return Str::substr($header, 6);
           }
           return null;
       };
    }
}