<?php

namespace Zento\HelloSns\Services;

use Auth;
use Request;
use Validator;
use Config;
use ShareBucket;
use Zento\HelloSns\Consts;
use Zento\BladeTheme\Facades\BladeTheme;
use Illuminate\Support\Str;

class HelloSnsService
{
    const STATE = 'hello_state';
    protected $state;

    protected $zento_portal;

    public function __construct() {
        $this->zento_portal = ShareBucket::get(\Zento\Kernel\Consts::ZENTO_PORTAL, 'front');
    }

    protected function getConfigKey($format) {
        return sprintf($format, $this->zento_portal);
    }

    protected function isGuest() {
        if ($user = Auth::user()) {
            return $user->guest();
        }
        return true;
    }

    public function prepareServices() {
        BladeTheme::appendStubProcessor(function($stub) {
            if ($stub === 'sns_login') {
                echo '<hello-sns></hello-sns>';
            }
        })->registerPreRouteCallAction(function($bladeTheme) {
            //if already login, not use to provide
            if ($this->isGuest()) {
                $response_type = Config::get($this->getConfigKey(Consts::RESPONSE_TYPE), 'token');
                $redirect_uri = url('/zento_hellosns/redirect.html');
                $options = compact('redirect_uri', 'response_type');
                if (Config::get($this->getConfigKey(Consts::CHECK_STATE))) {
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
            }
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
        if (!Config::get($this->getConfigKey(Consts::CHECK_STATE))) {
            return true;
        }

        $stateDataKey = Config::get($this->getConfigKey(Consts::RESPONSE_TYPE), 'token') === 'token' ? 'authResponse' : 'state';
        $state = $request->session()->pull(self::STATE);
        $stateArray = json_decode($request->input($stateDataKey, '{}'), true);
        $inputState = $stateArray['state'] ?? false;
        if (strlen($state) > 0 && $inputState === $state) {
            return $stateArray;
        }
        return false;
    }

    public function connectSessionUser($user, $network) {
        if ($this->isGuest()) {
            $model = Config::get('auth.providers.users.model');
            $localUser = (new $model)->findForPassport($user->email);
            if (empty($localUser)) {
                $attrs = $appRequest->all();
                $attrs['password'] = bcrypt($attrs['password']);
                $attrs['email'] = $attrs['username'];
                $localUser = $model::create($attrs);
            }
            if (!empty($localUser) && !empty($localUser->id)) {
                Auth::login($localUser);
            }
            return [
                true, 
                [
                    'user' => $localUser,
                    'apiGuestToken' => BladeTheme::getApiGuestToken($localUser)
                ]
            ];
        } else {
            if ($user->email === Auth::user()->email) {
                return [true, ['user' => Auth::user()]];
            } else {
                return [false, 'Another user has logged in. Please logout exist user first and log in with your account again.'];
            }
        }
    }

    public function connectApiUser($user, $network) {
        $model = Config::get('auth.providers.users.model');
        $localUser = (new $model)->findForPassport($user->email);
        if (empty($localUser)) {
            return BladeTheme::requestInnerApi('POST', BladeTheme::apiUrl('oauth2/register'), 
                [
                    'name' => $user->name,
                    'username' => $user->email,
                    'password' => Str::random(16)
                ]);
        } else {
            // $localUser->sns = 1;
            $password = 'do_not_check';
            $localUser->password = bcrypt($password);
            return BladeTheme::requestInnerApi('POST', BladeTheme::apiUrl('oauth2/token'), [
                'name' => $user->name,
                'username' => $user->email,
                'password' => $password
            ]);
        }
    }
}