<?php

namespace Zento\SnsConnect\Model;

class Constants {
    const SOCIALITE_PROVIDER_ENABLED = 'socialite/enabled/';
    const SOCIALITE_CLIENT_ID = 'socialite/client/id/';
    const SOCIALITE_CLIENT_SECRET = 'socialite/client/secret/';
    const SOCIALITE_REDIRECT_URL = '/login/%s/callback';
    const ALLOW_SWITCH_GOOGLE_ACCOUNT = 'socialite/google/allow_switch_account';
}