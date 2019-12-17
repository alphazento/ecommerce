<?php

namespace Zento\HelloSns\Services;

use Auth;
use Request;
use Zento\HelloSns\Consts;
use Zento\BladeTheme\Facades\BladeTheme;
use Illuminate\Support\Str;

class HelloSnsService
{
    const STATE = 'hello_state';
    protected $state;

    public function prepareServices() {
        BladeTheme::appendStubProcessor(function($stub) {
            if ($stub === 'sns_login') {
                echo '<hello-sns></hello-sns>';
            }
        })->registerPreRouteCallAction(function($bladeTheme) {
            //if already login, not use to provide
            $user = Auth::user();
            if (!$user || !$user->guest()) {
                return;
            }

            $response_type = config(Consts::HELLOSNS_RESPONSE_TYPE, 'code');
            $redirect_uri = route('hellosns.callback');
            $options = compact('redirect_uri', 'response_type');
            if ($response_type === 'code') {
                $options['state'] = $this->storeState();
            }

            // prepare cateogry tree for category menus
            $bladeTheme->addGlobalViewData(
                [
                    'consts' => [
                        'hellosns' => [
                            'services' => [
                                [
                                    'service' => 'facebook',
                                    'client_id' => '158217231362602',
                                    'color' => '#5168A4',
                                    'icon' => 'mdi-facebook',
                                    'title' => 'Continue With Facebook',
                                    'active' => true
                                ],
                                [
                                    'service' => 'linkedin',
                                    'client_id' => '158217231362602',
                                    'color' => '#278CAE',
                                    'icon' => 'mdi-linkedin',
                                    'title' => 'Continue With Linkedin',
                                    'active' => true
                                ],
                                [
                                    'service' => 'google',
                                    'client_id' => '158217231362602',
                                    'color' => '#278CAE',
                                    'icon' => 'mdi-google',
                                    'title' => 'Continue With Google',
                                    'active' => false
                                ]
                            ],
                            'options' => $options
                        ]
                    ]
                ]
            );
        });
        return $this;
    }

    public function storeState() {
        if (!$this->state) {
            if ($state = Request::session()->get(self::STATE)) {
                $this->state = $state;
                return $state;
            }
            $this->state = Str::random(40);
        }
        Request::session()->put(self::STATE, $this->state);
        return $this->state;
    }

    /**
     * Determine if the current request / session has a mismatching "state".
     *
     * @return bool
     */
    public function hasValidState($request)
    {
        $state = $request->session()->pull(self::STATE);
        $stateArray = json_decode($request->input('state', '{}'), true);
        $inputState = $stateArray['state'] ?? false;
        if (strlen($state) > 0 && $inputState === $state) {
            return $stateArray;
        }
        return false;
    }

    public function getNetwork(&$state) {
        return $state['network'] ?? false;
    }
}