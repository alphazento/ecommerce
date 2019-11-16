define(["jQuery", "windowLib", "typeahead", "lodash"], function($, windowLib) {
    var finder_api = 'https://api.addressfinder.io/api/au/address/autocomplete';
    var map = {};

    var addrFinder = {
        source: '',
        varifyUrl: '',
        minLength: 3,
        numOfResults: 5,
        modes: {},
        allowManual: true,
        init: function(key, finderEndpoint, varifyEndpoint, minLength, allowManual) {
            addrFinder.minLength = minLength || 3;
            finderEndpoint = finderEndpoint || finder_api;
            if (allowManual !== undefined) {
                addrFinder.allowManual = allowManual;
            }
            addrFinder.varifyUrl = varifyEndpoint;
            addrFinder.source = finderEndpoint + '?key=' + key + '&max=' + addrFinder.numOfResults;
            return addrFinder;
        },
        connect: function(connectorSelector, applyCallback, manualCallback) {
            var debouncedGetAddresses = _.debounce(function(formId, url, query, process) {
                if (addrFinder.modes[formId] === 'manual') {
                    return null;
                }
                if ($.ajaxSettings.hasOwnProperty('headers')) {
                    var qtssid = $.ajaxSettings.headers["X-QT-SSID"];
                    delete $.ajaxSettings.headers["X-QT-SSID"];
                }
                var tmpReturn = $.get(addrFinder.source, {
                    q: query
                }, function(data) {
                    data = data.completions;
                    if (addrFinder.allowManual) {
                        data.push({
                            'id': 'manual-input',
                            'full_address': "<strong style='color:red'>Address Not Found? Enter manually</strong>"
                        });
                    }
                    map = {};
                    $.each(data, function(i, object) {
                        map[object.full_address] = object.id;
                    });
                    return process(data);
                });
                if (qtssid) {
                    $.ajaxSettings.headers["X-QT-SSID"] = qtssid;
                }
                return tmpReturn;
            }, 500);

            $(connectorSelector).typeahead({
                name: 'full_address',
                minLength: addrFinder.minLength,
                autoSelect: false,
                restrictInputToDatum: true,
                changeInputOnMove: false,
                selectOnBlur: false,
                displayText: function(item) {
                    return item.full_address;
                },
                source: function(query, process) {
                    return debouncedGetAddresses(this.$element.attr('formid'), addrFinder.source, query, process);
                },
                sorter: function(items) {
                    return items; // no need to sort
                },
                matcher: function(item) {
                    return true; // no need to do filter
                },
                afterSelect: function(item) {
                    var formid = this.$element.attr('formid');
                    var id = this.$element.attr('data-id');
                    $('#' + formid + '-full_address-error').hide();
                    if (!id) {
                        id = '';
                    }
                    if (item.id === "manual-input") {
                        addrFinder.modes[formid] = 'manual';
                        if (manualCallback !== undefined) {
                            manualCallback(formid);
                        }
                    } else {
                        var self = this;
                        var $form = $('#' + formid);
                        var $removeIcon = $form.find('#' + formid + '-remove-full-address');
                        var $verifyingIcon = $form.find('#' + formid + '-waiting-verify');
                        var $formSubmitBtn = $('.disable-before-address-verify');
                        var $placeOrderForm = $('form[name="osc__checkout-form"]');
                        var $placeOrderVerifyingIcon = $('#waiting-verify-to-placeorder');
                        $removeIcon.hide();
                        $verifyingIcon.show();
                        $formSubmitBtn.attr('disabled', true);
                        $placeOrderForm.hide();
                        $placeOrderVerifyingIcon.show();
                        this.$element.attr('readonly', true);
                        this.$element.attr('disabled', true);
                        this.$element.blur();
                        $.ajax({
                            type: 'GET',
                            url: addrFinder.varifyUrl,
                            data: {
                                'address_id': item.canonical_address_id,
                                'full_address': item.full_address
                            },
                            success: function(data) {
                                self.$element.attr('placeholder', 'Start typing your address');
                                $verifyingIcon.hide();
                                $removeIcon.show();
                                $formSubmitBtn.attr('disabled', false);
                                $placeOrderVerifyingIcon.hide();
                                $placeOrderForm.show();
                                if (applyCallback !== undefined) {
                                    applyCallback(data, formid);
                                }
                            }
                        });
                    }
                }
            })
            .blur(function() {
                var id = $(this).attr('data-id');
                if (!id) {
                    id = '';
                }
                if (!map[$(this).val()]) {}
            });
        }
    };
    return addrFinder;
});
