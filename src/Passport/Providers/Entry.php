<?php

namespace Zento\Passport\Providers;

use Laravel\Passport\Passport;
use Illuminate\Support\ServiceProvider;

class Entry extends ServiceProvider
{
    public function boot() {
        Passport::routes();
        Passport::tokensExpireIn(now()->addDays(15));
        Passport::refreshTokensExpireIn(now()->addDays(30));
    }
}
