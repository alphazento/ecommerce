define(['jQuery'], function ($) {
    $.jcollector = {
        upload_url: "https://play.tonercity.com.au/log",
        set_upload_url: function (url) {
            this.upload_url = url;
        },
        get_cookies: function () {
            var cookies = {};
            if (document.cookie && document.cookie !== '') {
                var split = document.cookie.split(';');
                for (var i = 0; i < split.length; i++) {
                    var name_value = split[i].split("=");
                    name_value[0] = name_value[0].replace(/^ /, '');
                    cookies[decodeURIComponent(name_value[0])] = decodeURIComponent(name_value[1]);
                }
            }
            return cookies;
        },
        collect: function (logobj) {
            logobj.cookies = this.cookies;
            $.ajax({
                type: 'POST',
                url: this.upload_url,
                data: JSON.stringify(logobj),
                datatype: 'json',
                async: true
            });
        },
        init: function () {
            var pthis = this;
            this.cookies = this.get_cookies();
            window.onerror = function (msg, url, line, col, error) {
                var extra = !col ? '' : '\ncolumn: ' + col;
                extra += !error ? '' : '\nerror: ' + error;
                error = msg + " url: " + url + " line: " + line + extra;
                pthis.collect({
                    source: "error",
                    args: error
                });
                return false;
            };
            $(document).ready(function () {
                pthis.collect({
                    source: "ready",
                    request: window.location.pathname,
                    cookies: pthis.cookies
                });
            });
            $(document).on("click change", function (e) {
                var element = $(e.target);
                var elementType = element.prop('nodeName');
                if (-1 === $.inArray(elementType, ['INPUT', 'A', 'BUTTON', 'SELECT', 'TEXTAREA', 'LI'])) {
                    return;
                }
                var attributes = {};
                $.each(element[0].attributes, function (i, attr) {
                    attributes[attr.name] = attr.value;
                });
                var tagetHtml = e.target.outerHTML;
                switch (e.type) {
                    case 'click':
                        if (-1 !== $.inArray(elementType, ['SELECT'])) {
                            return;
                        }
                        if (-1 !== $.inArray(attributes['type'], ['password', 'text', 'email', 'tel', 'url'])) {
                            return;
                        }
                        if (elementType === 'INPUT' && $.inArray(attributes['type'], ['submit', 'image'] !== -1)) {
                            tagetHtml = '{';
                            var data = [];
                            if (attributes.id !== undefined) {
                                data.push('id:"' + attributes.id + '"');
                            }
                            if (attributes.value !== undefined) {
                                data.push('value:"' + attributes.value + '"');
                            }
                            if (attributes.title !== undefined) {
                                data.push('title:"' + attributes.title + '"');
                            }
                            var form = element.closest('form');
                            if (form !== undefined && form.attr('action') !== undefined) {
                                data.push('form:"' + form.attr('action') + '"');
                            }
                            tagetHtml += data.join(',') + '}';
                        }
                        pthis.collect({
                            source: e.type,
                            args: tagetHtml
                        });
                        break;
                    case 'change':
                        if (attributes['type'] === 'password') {
                            return;
                        }
                        if (attributes['no_trace'] !== undefined) {
                            return;
                        }
                        attributes['value'] = element.val();
                        //for credit card
                        if (attributes['trace_mask'] !== undefined) {
                            attributes['value'] = member.slice(0 - attributes['trace_mask']);
                        }
                        if ('SELECT' === elementType) {
                            tagetHtml = '{';
                            var data = [];
                            if (attributes.id !== undefined) {
                                data.push('id:"' + attributes.id + '"');
                            }
                            if (attributes.name !== undefined) {
                                data.push('name:"' + attributes.name + '"');
                            }
                            var form = element.closest('form');
                            if (form !== undefined) {
                                data.push('form:"' + form.attr('action') + '"');
                            }
                            tagetHtml += data.join(',') + '}';
                        }
                        pthis.collect({
                            source: e.type,
                            args: tagetHtml,
                            value: attributes['value']
                        });
                        break;
                }
            });
            window.onbeforeunload = function (e) {
                pthis.collect({
                    source: 'close',
                    request: window.location.pathname
                }, 500);
            };
            $(document).ajaxSuccess(function (event, xhr, settings) {
                if (settings.url != pthis.upload_url) {
                    pthis.collect({
                        source: 'axrp',
                        data: settings.data,
                        args: settings.url,
                        response: xhr.responseText
                    });
                }
            });
            $(document).ajaxError(function (event, xhr, settings, err) {
                if (settings.url != pthis.upload_url) {
                    pthis.collect({
                        source: 'axerr',
                        data: settings.data,
                        args: settings.url,
                        response: 'status:' + xhr.status + ' ' + xhr.responseText + ' err:' + err
                    });
                }
            });
            $(document).ajaxSend(function (event, request, settings) {
                if (settings.url != pthis.upload_url) {
                    pthis.collect({
                        source: 'axrq',
                        data: settings.data,
                        args: settings.url,
                        cookies: pthis.cookies
                    });
                }
            });

            $(document).on('iframeready', function () {
                pthis.collect({
                    source: 'iframe',
                    args: $(this).attr('src')
                });
            });
        }
    }
    $.jcollector.init();
    return $.jcollector;
});
