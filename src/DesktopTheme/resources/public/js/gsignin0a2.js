define(["jQuery", "loadingNotification"], function ($, modallayer) {
    var profile = {};
    var toggle = false;
    var callbackWhenSigned = function (p) {
        profile = p || profile;
        var configs = getGlobalConfigValue('google--signin');
        if (!profile.error) {
            modallayer.info('', 5000);
            $.ajax({
                type: "POST",
                url: configs.callback_url,
                data: profile,
                dataType: 'json',
                success: function (data) {
                    if (data.status === 200) {
                        if (data.url) {
                            window.location = data.url;
                        }
                    } else {
                        window.location.reload();
                    }
                },
                error: function (data) {
                    window.location.reload();
                }
            });
        }
    };

    var gsigninprimer = {
        // googleUser: {},
        auth2: {},
        callbackWhenSigned: undefined,
        startApp: function (client_id, currentUserListener, callbackWhenSigned) {
            gapi.load('auth2', function () {
                gsigninprimer.auth2 = gapi.auth2.init({
                    client_id: client_id,
                    cookiepolicy: 'single_host_origin',
                    //scope: 'additional_scope'
                });

                // Listen for sign-in state changes.
                gsigninprimer.auth2.isSignedIn.listen(function (val) {
                    console.log('Signin state changed to ', val);
                });

                // Listen for changes to current user.
                gsigninprimer.auth2.currentUser.listen(currentUserListener);
            });
            gsigninprimer.callbackWhenSigned = callbackWhenSigned;
        },
        attachSignin: function (element) {
            gsigninprimer.auth2.attachClickHandler(element, {},
                function (googleUser) {
                    var profile = googleUser.getBasicProfile();
                    gsigninprimer.callbackWhenSigned({
                        email: profile.getEmail(),
                        firstname: profile.getGivenName(),
                        lastname: profile.getFamilyName(),
                        user_id: profile.getId(),
                        token: googleUser.getAuthResponse().id_token
                    });
                },
                function (error) {
                    console.log('gsignin', error);
                    if (!error || error.error === "popup_closed_by_user") {
                        return;
                    }
                    gsigninprimer.callbackWhenSigned({
                        refresh_error: true,
                        error: "Google sign in unknow error happened.",
                        raw: error
                    });
                });
        }
    };

    var gsignin = {
        inited: false,
        load: function () {
            var configs = getGlobalConfigValue('google--signin');
            if (gsignin.inited) {
                return;
            }
            gsignin.inited = true;
            gsigninprimer.startApp(configs.client_id,
                function (user) {
                    gsigninprimer.attachSignin(document.getElementById('big-gsignin-btn'));
                    if (!user.isSignedIn()) {
                        // gsigninprimer.attachSignin(document.getElementById('big-gsignin-btn'));
                        $('.js-gsignin-dropdown').hide();
                    } else {
                        var prof = user.getBasicProfile();
                        profile = {
                            email: prof.getEmail(),
                            firstname: prof.getGivenName(),
                            lastname: prof.getFamilyName(),
                            user_id: prof.getId(),
                            token: user.getAuthResponse().id_token
                        };
                        if (configs.can_switch_account) {
                            $('.js-gsignin-extern-btn i.fa').show();
                            $('#gsignin-with-btn').text("with " + profile.email);
                            gsigninprimer.attachSignin(document.getElementById('alter-gsignin-btn'));

                            $('#gsignin-with-btn').click(function (e) {
                                e.stopPropagation();
                                e.preventDefault();
                                callbackWhenSigned();
                            });

                            $('#alter-gsignin-btn').click(function (e) {
                                e.stopPropagation();
                            });

                            $('.js-gsignin-extern-btn').click(function (e) {
                                e.stopPropagation();
                                toggle = !toggle;
                                if (toggle) {
                                    $('.js-gsignin-dropdown').show();
                                } else {
                                    $('.js-gsignin-dropdown').hide();
                                }
                            });
                        }
                        // $('#big-gsignin-btn').click(function (e) {
                        //     callbackWhenSigned();
                        // });
                    }
                },
                callbackWhenSigned);
        }
    };
    return gsignin;
});
