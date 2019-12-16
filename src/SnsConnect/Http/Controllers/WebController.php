<?php

namespace Zento\SnsConnect\Http\Controllers;

use App\Http\Controllers\Controller;

use Auth;
use Quote;
use Route;
use Request;
use Session;
use Socialite;
use Store;
use Config;
use Validator;
use Zento\SnsConnect\Model\Constants;

class WebController extends Controller
{
    const FACEBOOK = 1;
    const GOOGLE = 2;
    const ERR_FORMATER = '%s login error. Please try again later. Or alternatively, login/register using your email address';
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleCallback() {
        $request = Request::instance();
        if (!Store::getConfig(Constants::SOCIALITE_PROVIDER_ENABLED . $provider)) {
            return redirect()->back();
        }

        $jspopup = Request::input('jspopup');
        if(!Auth::isFullLogin()) {
            $this->initServiceConfig($provider);
            Session::flash(sprintf('%s_jspopup', $provider), $jspopup);
            return Socialite::driver($provider)->redirect();
        }
        if ($jspopup) {
            return view('socialite.popup-close', ['hasError' => false, 'url' => route('home')]);
        } else {
            return redirect('/');
        }
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback() {
        $provider = Route::input('provider');
        if (!Store::getConfig(Constants::SOCIALITE_PROVIDER_ENABLED . $provider)) {
            return redirect()->back();
        }

        if ('google' === $provider) {
            return $this->handleGoogleSignIn();
        }

        $jspopup = Session::get(sprintf('%s_jspopup', $provider));
        $hasError = false;
        try {
            if(!Auth::isFullLogin()) {
                $user = Socialite::driver($provider)->user();
                $validator = Validator::make(['email' => $user->email], [
                    'email' => 'required|email|max:255'
                ]);

                if ($validator->fails()) {
                    $hasError = true;
                } else {
                    $localUser = Auth::getProvider()->retrieveByEmail($user->email);
                    if (empty($localUser)) {
                        $nameParts = explode(' ', $user->name);
                        $sns =0;
                        switch($provider) {
                            case 'facebook':
                                $sns =1;
                                break;
                            case 'google':
                                $sns =2;
                                break;
                        }
                        $localUser = User::create([
                            'customers_firstname' => $nameParts[0],
                            'customers_lastname' => $nameParts[count($nameParts)-1],
                            'customers_email_address' => $user->email,
                            'customers_telephone' => '',
                            'customers_newsletter' => 0,
                            'customers_dob' => '1970-01-01 00:00:00',
                            'customers_password' => 'fromfacebook',
                            'sns' => $sns
                        ]);
                    } else {
                        $localUser->sns = 1;
                        $localUser->save();
                    }
                    if (!empty($localUser) && !empty($localUser->customers_id)) {
                        Auth::login($localUser);
                        Session::put('sns', 1);
                    } else {
                        return redirect()->to('/login')->withErrors(['msg', 'The user is blocked.']);
                    }
                }
            }
        } catch (\Exception $e) {
            $hasError = true;
        }

        if ($hasError) {
            //do not return, just use to set errors
            redirect()->to('/login')->withErrors([sprintf(self::ERR_FORMATER, ucfirst($provider))]);
        }

        if ($jspopup) {
            return view('socialite.popup-close', ['hasError' => $hasError, 'url' => $hasError ? route('login') : route('home')]);
        } else {
            return redirect('/');
        }
    }

    /**
     * it's for new google sign in
     *
     * @return void
     */
    protected function handleGoogleSignIn() {
        if (Request::get('refresh_error')) {
            $errors = [Request::get('error', ''), sprintf(self::ERR_FORMATER, 'Google')];
            redirect()->to('/login')->withErrors($errors);
            return ['status'=>401];
        }

        Request::validate([
            'email' => 'email|required|max:255',
            'firstname'=>"required|string",
            'lastname'=>"required|string",
        ]);

        $validator = Validator::make(Request::all(),
            [
                'email' => 'email|required|max:255',
                'firstname'=>"required|string",
                'lastname'=>"required|string",
            ]
        );

        if (!$validator->fails()) {
            if (!$this->verifyGoogleToken(Request::get('token'), Request::get('user_id'))) {
                redirect()->to('/login')->withErrors([sprintf(self::ERR_FORMATER, 'Google')]);
                return ["status" => 401];
            }

            $localUser = Auth::getProvider()->retrieveByEmail(Request::get('email'));
            if (empty($localUser)) {
                $localUser = User::create([
                    'customers_firstname' => Request::get('firstname'),
                    'customers_lastname' => Request::get('lastname'),
                    'customers_email_address' => Request::get('email'),
                    'customers_telephone' => '',
                    'customers_newsletter' => 0,
                    'customers_dob' => '1970-01-01 00:00:00',
                    'customers_password' => 'fromgsignin',
                    'sns' => 2
                ]);
                if ($localUser) {
                    $localUser->save();
                }
            } else {
                $localUser->sns = 2;
                $localUser->save();
            }
            if (!empty($localUser) && !empty($localUser->customers_id)) {
                Auth::login($localUser);
                Session::put('sns', 2);
                $url = route("home");
                if ($quote = Quote::now()) {
                    if (!$quote->isEmpty()) {
                        $url = route('checkout');
                    }
                }
                return ['status' => 200, 'url' => $url];
            } else {
                redirect()->to('/login')->withErrors([sprintf(self::ERR_FORMATER, 'Google')]);
                return ['status'=>401];
            }
        } else {
            $validator->errors()->add($provider, sprintf(self::ERR_FORMATER, ucfirst($provider)));
            redirect()->to('/login')->withErrors($validator);
            return ['status'=>401];
        }
    }

    protected function verifyGoogleToken($token, $userid) {
        $client = new \Google_Client(['client_id' => Store::getConfig(\Zento\SnsConnect\Model\Constants::SOCIALITE_CLIENT_ID . 'google')]);  // Specify the CLIENT_ID of the app that accesses the backend
        $payload = $client->verifyIdToken($token);
        if ($payload) {
          return $userid == $payload['sub'];
        }
        return false;
    }
    /**
     * load provider's config detail from db/cache
     */
    protected function initServiceConfig($provider) {
        $id = Store::getConfig(sprintf('%s%s', Constants::SOCIALITE_CLIENT_ID, $provider));
        $secret = Store::getConfig(sprintf('%s%s', Constants::SOCIALITE_CLIENT_SECRET, $provider));
        $redirect = url(sprintf(Constants::SOCIALITE_REDIRECT_URL, $provider));

        Config::set(sprintf('services.%s.client_id', strtolower($provider)), $id);
        Config::set(sprintf('services.%s.client_secret', strtolower($provider)), $secret);
        Config::set($redirect);
    }
}
