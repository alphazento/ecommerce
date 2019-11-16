<script src=@resource("/theme/js/require.js")></script>
<script src=@resource("/theme/js/require-config.js")></script>

<script>
    var global_configs = {catchError:true};
    var requirejs_err = false;
    function setGlobalConfigKeyValue(key, value) {
        global_configs[key] = value;
    }
    function getGlobalConfigValue(key) {
        return global_configs[key];
    }

    require_add_config("jQuery", @asset("/tonercitytheme/assets/js/jquery-3.4.1.min"), {
        deps: [],
        exports: 'jQuery'
    });

    require_add_config("bootstrap", @asset("/tonercitytheme/assets/js/bootstrap4.3.1.min"), {
        deps: ['jQuery'],
        exports: "bootstrap"
    });

    require_add_config("findprinter", @asset("/tonercitytheme/assets/js/find-printer"), {
        deps: ['jQuery'],
        exports: 'findprinter'
    });

    require_add_config("logservice", @asset("/tonercitytheme/assets/js/logreq"), {
        deps: ['jQuery'],
        exports: 'logservice'
    });
    require_add_config("ajaxlogin", @asset("/tonercitytheme/assets/js/ajaxlogin"), {
        deps: ['jQuery'],
        exports: 'ajaxlogin'
    });
    require_add_config("jquery.validate", @resource("/theme/js/jquery.validate.min"), {
        deps: ['jQuery'],
        exports: 'jquery.validate'
    });
    require_add_config("typeahead", @asset("/tonercitytheme/assets/js/bootstrap3-typeahead"), {
        deps: ['jQuery'],
        exports: 'typeahead'
    });
    require_add_config("mobileCommon", @asset("/tonercitytheme/assets/js/mobile-common"), {
        deps: ['jQuery'],
        exports: 'mobileCommon'
    });

    require_add_config('windowLib', @asset("/tonercitytheme/assets/js/windowlib"), {
        deps: [],
        exports: 'windowLib'
    });

    require_add_config("loadingNotification", @asset("/tonercitytheme/assets/js/notification-modal"), {
        deps: ['jQuery'],
        exports: 'loadingNotification'
    });

    require_add_config("zohoChat", @asset("/tonercitytheme/assets/js/zoho-chat"), {
        deps: [],
        exports: 'zohoChat'
    });

    require_add_config("lodash", @asset("/tonercitytheme/assets/js/lodash.min"), {
        deps: [],
        exports: 'lodash'
    });

    @stack('rqjs_configs')

    (function(require) {
        console.log('global_require_config', global_require_config);
        require.config(global_require_config);
        requirejs.onError = function (err) {
            if (err) {
                requirejs_err = err;
                console.log('requirejs_err', requirejs_err);
            }
        };
        requirejs(["jQuery", "bootstrap", "ajaxlogin", "findprinter", "mobileCommon", "logservice", 'loadingNotification', 'zohoChat'], function ($, ajaxlogin) {
            console.log('init');
        });
        @stack('rqjs_body')
    })(require);
</script>
