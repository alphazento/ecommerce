<?php

namespace Zento\HelloSns;

class Consts {
    const SERVICES = 'hellosns.services';
    const ENABLED = 'hellosns.%s.enabled';
    const RESPONSE_TYPE = 'hellosns.%s.response_type';
    const ALLOW_SERVICES = 'hellosns.%s.allow_services';
    const CHECK_STATE = 'hellosns.%s.check_state';

    //only allow 
    const ALLOW_CREATE_ACCOUNT = 'hellosns.%s.allow_create_account';

    const FACEBOOK_SERVICE = 'services.facebook';
    const TWITTER_SERVICE = 'services.twitter';
    const LINKEDIN_SERVICE = 'services.linkedin';
    const GOOGLE_SERVICE = 'services.google';
    const GITHUB_SERVICE = 'services.github';
    const GITLAB_SERVICE = 'services.gitlab';
    const BITBUCKET_SERVICE = 'services.bitbucket';
}