define(['jQuery', 'windowLib'], function($, windowLib) {

    return {

        csrfToken: '',
        stored: false,

        init: function(data) {
            this.csrfToken = data.csrfToken;
            return this;
        },

        run: function() {

            if (!this.stored) {
                var _this = this;
                var retry = 1;
                var this_csrfToken = this.csrfToken;

                setTimeout(storeDeviceId, 500);

                function storeDeviceId() {

                    windowLib.sendMessage('notification', { content: 'Updating...', action: 'info'});

                    var $container = $('#pmnts_id');
                    var deviceId = '';
                    if ($container.length > 0) {
                        deviceId = $container.val();
                    }
                    if (deviceId.length > 0) {
                        $.ajax({
                            url: '/fatzebra/device-id',
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                'fz_device_id': deviceId,
                                '_token': this_csrfToken
                            },
                        })
                        .done(function() {
                            _this.stored = true;
                            windowLib.sendMessage('notification', {action: 'hide'});
                        })
                    } else {
                        if (retry < 10) {
                            retry++;
                            setTimeout(storeDeviceId, 500);
                        } else {
                            $.ajax({
                                url: '/fatzebra/device-id',
                                type: 'POST',
                                dataType: 'json',
                                data: {
                                    'fz_device_id': 'got no device ID in 10 trials',
                                    '_token': this_csrfToken
                                },
                            })
                            .done(function() {
                                _this.stored = true;
                                windowLib.sendMessage('notification', {action: 'hide'});
                            })
                        }
                    }
                }
            }
        }
    };
});
