define(['jQuery'], function ($) {
    // Source: https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/assign#Polyfill
    if (typeof Object.assign !== 'function') {
        Object.defineProperty(Object, "assign", {
            value: function assign(target, varArgs) {
                'use strict';
                if (target === null || target === undefined) {
                    throw new TypeError('Cannot convert undefined or null to object');
                }

                var to = Object(target);

                for (var index = 1; index < arguments.length; index++) {
                    var nextSource = arguments[index];

                    if (nextSource !== null && nextSource !== undefined) {
                        for (var nextKey in nextSource) {
                            // Avoid bugs when hasOwnProperty is shadowed
                            if (Object.prototype.hasOwnProperty.call(nextSource, nextKey)) {
                                to[nextKey] = nextSource[nextKey];
                            }
                        }
                    }
                }
                return to;
            },
            writable: true,
            configurable: true
        });
    }

    function eventHandler(callbacks, data, errBreak, isExtra) {
        var rawData = data;
        if (data && data["type"]) {
            var type = data["type"];
            var data = data["data"];
            var cbs = callbacks[type] || [];
            var len = cbs.length;
            if (len === 0 && isExtra) {
                var newData = {};
                Object.assign(newData, rawData);
                pushToWait(newData);
            }
            for (var i = 0; i < len; i++) {
                var ret = cbs[i](data);
                if (ret && errBreak) {
                    eventHandler(callbacks, {
                        type: type + '-error',
                        data: {
                            error: ret,
                            origin: data
                        }
                    }, false);
                    return false;
                }
            }
        }
        return true;
    };


    function pushToWait(data) {
        var msgType = data["type"];
        if (waitHandlerMessages[msgType] === undefined) {
            waitHandlerMessages[msgType] = [];
        }
        waitHandlerMessages[msgType].push(data);
    };

    function handleWaitMessages(msgType) {
        if (waitHandlerMessages[msgType] !== undefined) {
            var messages = waitHandlerMessages[msgType];
            var len = messages.length;
            if (len > 0) {
                for (var i = 0; i < len; i++) {
                    eventHandler(messageCallbacks, messages[i], true, false)
                }
                waitHandlerMessages[msgType] = [];
            }
        }
    }

    var messageCallbacks = {};
    var waitHandlerMessages = {};
    var loadedLibs = {};


    var windowlib = {
        sendMessage: function (type, data) {
            var load = {
                type: 'pre-' + type,
                data: data
            };
            if (eventHandler(messageCallbacks, load, true)) {
                load.type = type;
                eventHandler(messageCallbacks, load, false, true);
                load.type = 'post-' + type;
                eventHandler(messageCallbacks, load, false);
                return true;
            }
            return false;
        },
        onMessage: function (msgType, callback) {
            var callbacks = messageCallbacks[msgType] || [];
            callbacks.push(callback);
            messageCallbacks[msgType] = callbacks;
            handleWaitMessages(msgType);
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

    var req = function (method, url, data, onSuccess, onError, message) {
        message = message || "Updating...";
        var fnOnSuccess = function (data) {
            var hideNow = true;
            if (onSuccess !== undefined) {
                hideNow = !onSuccess(data);
            }
            if (hideNow) {
                windowlib.sendMessage('notification', {
                    action: 'hide'
                });
            }
        };
        var fnOnError = function (xhr) {
            if (onError !== undefined) {
                onError(xhr);
            }
            windowlib.sendMessage('notification', {
                action: 'hide'
            });
        }
        windowlib.sendMessage('notification', {
            action: 'info',
            content: message
        });
        var async = !$._ajax_sync_flag;
        $.ajaxSync(false);
        $.ajax({
            type: method,
            url: url,
            data: data,
            dataType: 'json',
            async: async,
            success: fnOnSuccess,
            error: fnOnError
        });
    };

    if ($.ajaxGET === undefined) {
        $.ajaxGET = function (url, onSuccess, onError, message) {
            req('GET', url, null, onSuccess, onError, message);
        };
    }

    if ($.ajaxPOST === undefined) {
        $.ajaxPOST = function (url, data, onSuccess, onError, message) {
            req('POST', url, data, onSuccess, onError, message);
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
