<?php

namespace Zento\HelloSns\Services;

use Auth;
use Request;
use Validator;
use Config;
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

            $response_type = config(Consts::HELLOSNS_RESPONSE_TYPE, 'token');
            $redirect_uri = url('/zento_hellosns/redirect.html');
            $options = compact('redirect_uri', 'response_type');
            $options['state'] = $this->storeState();

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

    public function connectSessionUser($user, $network) {
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
        return $this->with('user', $localUser)->with('apiGuestToken', BladeTheme::getApiGuestToken($localUser));
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