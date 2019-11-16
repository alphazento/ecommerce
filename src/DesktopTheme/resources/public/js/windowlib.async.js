define(['jQuery'], function ($) {
    function bindEvent(element, eventName, eventHandler) {
        if (element.addEventListener) {
            element.addEventListener(eventName, eventHandler, false);
        } else if (element.attachEvent) {
            element.attachEvent("on" + eventName, eventHandler);
        }
    };

    function eventHandler(callbacks, event, errBreak) {
        if (event.data && event.data["type"]) {
            var type = event.data["type"];
            var data = event.data["data"];
            var cbs = callbacks[type] || [];
            var len = cbs.length;
            for (var i = 0; i < len; i++) {
                if (cbs[i](data) && errBreak) {
                    return false;
                }
            }
        }
        return true;
    };

    var messageCallbacks = {};
    var loadedLibs = {};
    var eventBinded = false;

    var windowlib = {
        sendMessage: function (type, data) {
            var load = {
                type: 'pre-' + type,
                data: data
            };
            if (eventHandler(messageCallbacks, {
                    data: load
                }, true)) {
                load.type = type;
                window.postMessage(load, "*");
                load.type = 'post-' + type;
                eventHandler(messageCallbacks, {
                    data: load
                }, false);
            }
            return windowlib;
        },
        onMessage: function (msgType, callback) {
            var callbacks = messageCallbacks[msgType] || [];
            callbacks.push(callback);
            messageCallbacks[msgType] = callbacks;
            return windowlib;
        },
        lzloadRqjsLib: function (name, deps, callback) {
            if (loadedLibs[name] === undefined) {
                loadedLibs[name] = true;
                deps = deps || [];
                deps.push(name);
                if (callback) {
                    requirejs(deps, callback);
                } else {
                    requirejs(deps, function () {});
                }
                return false; //means not been full loaded
            } else {
                return true; //means has been full loaded
            }
        }
    };

    if (!eventBinded) {
        eventBinded = true;
        bindEvent(window, "message", function (e) {
            eventHandler(messageCallbacks, e, false);
        });
    }

    var req = function (method, url, data, onSuccess, onError, message) {
        message = message || "Updating...";
        // var csrfToken = $('meta[name=csrf-token]').attr("content");
        var fnOnSuccess = function (data) {
            windowlib.sendMessage('notification', {
                action: 'hide'
            });
            if (onSuccess !== undefined) {
                onSuccess(data);
            }
        };
        var fnOnError = function (data) {
            windowlib.sendMessage('notification', {
                action: 'hide'
            });
            if (onError !== undefined) {
                onError(data);
            }
        }
        windowlib.sendMessage('notification', {
            action: 'info',
            content: message
        });
        $.ajax({
            type: method,
            url: url,
            data: data,
            dataType: 'json',
            async: !$._ajax_sync_flag,
            success: fnOnSuccess,
            error: fnOnError
        });
        $.ajaxSync(false)
    };

    if ($.ajaxPOST === undefined) {
        $.ajaxPOST = function (url, data, onSuccess, onError) {
            req('POST', url, data, onSuccess, onError);
        };
    }

    if ($.ajaxPUT === undefined) {
        $.ajaxPUT = function (url, data, onSuccess, onError) {
            req('PUT', url, data, onSuccess, onError);
        };
    }

    if ($.ajaxDELETE === undefined) {
        $.ajaxDELETE = function (url, data, onSuccess, onError) {
            req('DELETE', url, data, onSuccess, onError, "Deleting...");
        };
    }
    if ($.ajaxSync === undefined) {
        $.ajaxSync = function (flag) {
            $._ajax_sync_flag = flag
            return $;
        };
    }

    return windowlib;
});
