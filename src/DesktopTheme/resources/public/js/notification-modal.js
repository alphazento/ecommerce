define(['jQuery', 'windowLib', 'bootstrap'], function ($, windowLib) {
    var notif_modal = {
        timeout: 0,
        hide_callback: undefined,
        _show: function (timeout, callback) {
            var $container = $("#loadingNotification");
            if ($container.length <= 0) {
                return;
            }
            timeout = timeout || 0;
            $container.modal({
                backdrop: 'static',
                keyboard: false,
                show: true
            });
            this.hide_callback = callback;
            var pthis = this;
            if (timeout && timeout > 0) {
                if (pthis.timeout) {
                    clearTimeout(pthis.timeout);
                    pthis.timeout = 0;
                }
                pthis.timeout = setTimeout(function () {
                    pthis.hide();
                    pthis.clear();
                }, timeout)
            } else {
                if (pthis.timeout) {
                    clearTimeout(pthis.timeout);
                }
            }
        },

        info: function (content, timeout, callback) {
            this.clear();
            this.append('info', content);
            this._show(timeout, callback);
        },

        warn: function (content, timeout, callback) {
            this.clear();
            this.append('warn', content);
            this._show(timeout, callback);
        },

        error: function (content, timeout, callback) {
            this.clear();
            this.append('danger', content);
            this._show(timeout, callback);
        },

        hide: function () {
            if (this.hide_callback !== undefined) {
                this.hide_callback();
            }
            var $container = $("#loadingNotification");
            if ($container.length) {
                $container.modal('hide');
            }
            this.hide_callback = undefined;
        },

        append: function (level, content) {
            var $container = $("#loadingNotification");
            if ($container.length) {
                $container.find('.modal-body .loading-text').append('<p class="text-' + level + '">' + content + '</p>');
                if (level === 'danger') {
                    $container.find('.notifier__btn-confirm').show();
                } else {
                    $container.find('.notifier__btn-confirm').hide();
                }
            }
        },

        clear: function () {
            var $container = $("#loadingNotification");
            if ($container.length) {
                $container.find('.modal-body .loading-text').empty();
            }
        }
    };

    windowLib.onMessage('notification', function (data) {
        switch (data['action']) {
            case 'hide':
                notif_modal.hide();
                break;
            case 'info':
                notif_modal.info(data['content'], data['timeout']);
                break;
            case 'warn':
                notif_modal.warn(data['content'], data['timeout']);
                break;
            case 'error':
                notif_modal.error(data['content'], data['timeout']);
                break;
        }
    });

    var $container = $("#loadingNotification");
    $container.find('.notifier__btn-confirm').click(function () {
        notif_modal.hide();
    });

    return notif_modal;
});
