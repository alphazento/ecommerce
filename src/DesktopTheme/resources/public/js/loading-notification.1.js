define(['jQuery'], function ($) {

    var $container = $("#loadingNotification");

    return {
        timeout: 0,
        showLoader: function (timeout, callback) {
            $container.modal({
                backdrop: 'static',
                keyboard: false,
                show: true
            });

            if (timeout !== undefined) {
                var pthis = this;
                if (pthis.timeout) {
                    clearTimeout(pthis.timeout);
                }
                pthis.timeout = setTimeout(function () {
                    pthis.hide();
                    pthis.clear();
                    if (callback !== undefined) {
                        callback();
                    }
                    pthis.timeout = 0;
                }, timeout)
            }
        },

        hide: function () {
            $container.modal('hide');
        },

        appendMessage: function (level, content) {
            $container.find('.modal-body .loading-text').append('<p class="text-' + level + '">' + content + '</p>');
        },

        clear: function () {
            $container.find('.modal-body .loading-text').empty();
        }
    };
});
