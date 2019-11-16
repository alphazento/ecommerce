<?php
$facebookEnabled = Store::getConfig(\Inkstation\Socialite\Model\Constants::SOCIALITE_PROVIDER_ENABLED . 'facebook');
$googleEnabled = Store::getConfig(\Inkstation\Socialite\Model\Constants::SOCIALITE_PROVIDER_ENABLED . 'google');
$allowGoogleSwitchAccount = $googleEnabled ? Store::getConfig(\Inkstation\Socialite\Model\Constants::ALLOW_SWITCH_GOOGLE_ACCOUNT) : false;
$allowGoogleSwitchAccount = $allowGoogleSwitchAccount ? 1 : 0;
if ($ref = Registry::get('login-connect-ref', 0)) {
    return;
}
Registry::put('login-connect-ref', $ref + 1);

$jsCode = '';
if ($googleEnabled) {
    $jsCode = sprintf('requirejs(["gsignin"], function(gsignin) {
            setGlobalConfigKeyValue("google--signin",{enabled:true,client_id:"%s",callback_url:"%s",can_switch_account: %s,csrf_token: "%s"});
            gsignin.load();});',
        Store::getConfig(\Inkstation\Socialite\Model\Constants::SOCIALITE_CLIENT_ID . 'google'),
        route('social-login-callback', ['provider'=>'google']),
        $allowGoogleSwitchAccount ? 1 : 0,
        csrf_token());
};

if ($facebookEnabled) {
    $jsCode .= 'requirejs(["facebooklogin"], function() {});';
}
?>

@push('rqjs_configs')
    require_add_config("gapi", "https://apis.google.com/js/api:client", { exports: "gapi" });
    require_add_config('gsignin', @asset("/tonercitytheme/assets/js/gsignin0a2"), { deps: ["gapi"], exports:"gsignin" });
    require_add_config("facebooklogin", @resource("/socialite/js/facebooklogin"), { deps: ["jQuery"], exports: "facebooklogin" });
@endpush

@push('rqjs_body')
{!! $jsCode !!}
@endpush

<div class="row text-center" style="{{ Cookie::get('debugjar') == 'social-login' ? '' : ''}}">
    <div class="col">
        @if ($facebookEnabled)
            <button type="button" class=" js-fblogin loginBtn osc__loginBtn loginBtn--facebook"><i class="fa fa-facebook-f pr-1"></i>Continue With Facebook</button>
        @endif
        @if ($googleEnabled)
            <button type="button" class="loginBtn osc__loginBtn loginBtn--google" id="big-gsignin-btn"><i class="fa fa-google pr-1"></i>Continue With Google</button>
        @endif
            <div class="row text-center mt-2 mb-2">
                <div class="col col-sm-5 p-0">
                  <hr class="w-75 osc__hr-login pull-right">
                </div>
                <div class="col col-sm-2 p-0 osc__word-or">
                    OR
                </div>
                <div class="col col-sm-5 p-0">
                    <hr class="w-75 osc__hr-login pull-left">
                </div>
            </div>
    </div>
</div>

