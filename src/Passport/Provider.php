<?php

namespace Zento\Passport;

use ShareBucket;
use Zento\Passport\Http\Middleware\GuestToken as GuestTokenMiddleware;

use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\RequestGuard;

use League\OAuth2\Server\ResourceServer;
use Laravel\Passport\Passport;
use Laravel\Passport\TokenRepository;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\Guards\TokenGuard;

class Provider extends \Illuminate\Support\ServiceProvider
{
    public function register() 
    {
        $this->registerGuard();
    }
    /**
     * Register the token `guard.
     *
     * @return void
     */
    protected function registerGuard()
    {
        Auth::extend('passport', function ($app, $name, array $config) {
            return tap($this->makeGuard($config), function ($guard) {
                $this->app->refresh('request', $guard, 'setRequest');
            });
        });
    }

    /**
     * Make an instance of the token guard.
     *
     * @param  array  $config
     * @return \Illuminate\Auth\RequestGuard
     */
    protected function makeGuard(array $config)
    {
        return new RequestGuard(function ($request) use ($config) {
            if ($user = (new TokenGuard(
                $this->app->make(ResourceServer::class),
                Auth::createUserProvider($config['provider']),
                $this->app->make(TokenRepository::class),
                $this->app->make(ClientRepository::class),
                $this->app->make('encrypter')
            ))->user($request)) {
                $user->acl($request);
            }
            if (!$user) {
                if (env('APP_ENV') === 'local' && env('IGNORE_AUTH_API')) {
                    ShareBucket::put(GuestTokenMiddleware::ALLOW_GUEST_API, true);
                }
                //add a guest api token and generate a guest user
                $user = GuestTokenMiddleware::prepareGuestForApi($request);
                // $user->acl($request);
            }
            return $user;
        }, $this->app['request']);
    }

    public function boot() {
        Passport::routes();
        Passport::tokensCan([
            'Profile' => 'Access your profile',
            'Email'   => 'Access your Email',
        ]);
        Passport::tokensExpireIn(now()->addDays(15));
        // Passport::tokensExpireIn(now()->addMinutes(60));
        Passport::refreshTokensExpireIn(now()->addDays(30));
    }
}
