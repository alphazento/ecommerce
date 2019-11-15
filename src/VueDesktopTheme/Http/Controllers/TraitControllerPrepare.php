<?php

namespace Zento\VueDesktopTheme\Http\Controllers;

use Request;
use BladeTheme;

trait TraitControllerPrepare
{
    protected $apiBase = '/api/v1';
    protected function beforeCallAction($method) {
      $apiGuestToken = sprintf('Guest %s', encrypt(json_encode(Request::user()->toArray())));
      BladeTheme::addGlobalViewData(compact('apiGuestToken'));
    }
}