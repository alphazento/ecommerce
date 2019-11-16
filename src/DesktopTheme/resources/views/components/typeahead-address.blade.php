@push('styles')
    .typeahead {
        min-width: 300px;
        width: 95%;
    }

    @media (max-width: 767px){
        .dropdown-menu{
            font-size: 12px;
            max-height: 100px;
            overflow-y: scroll;
            -webkit-overflow-scrolling: touch;
        }
        .dropdown-menu > li > a{
            line-height: 20px;
        }
    }

    .dropdown-menu > .active > a, .dropdown-menu > .active > a:hover, .dropdown-menu > .active > a:focus {
        background: lightgrey;
    }

    .dropdown-menu > li > a {
        word-wrap: break-word;
        white-space: normal;
        line-height: 35px;
    }

    .switch_back_to_address_lookup{
        color: #fff;
        background-color: #f4a100;
        font-weight: 400;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        user-select: none;
        border: 1px solid #f4a100;
        padding: .375rem .75rem;
        font-size: 1rem;
        line-height: 1.5;
        border-radius: .25rem;
        margin-bottom: 5px;
    }
@endpush

@push('rqjs_body')
    requirejs(["jQuery", "typeahead"], function ($) {
        var $inputSuburb = '#{{$suburb}}';
        var $inputPostcode = '#{{$postcode}}';
        var $inputState = '#{{$state}}';
        var $fullAddress = '#{{$fullAddress}}';
        var $addressLineOne = '#{{$streetAddress1}}';
        var $addressLineTwo = '#{{$streetAddress2}}';
        var $detailsAddressBox = '#{{$detailsAddressBox}}';
        var $fullAddressBox = '#{{$fullAddressBox}}';


        $('#entry_postcode').typeahead({
            displayText: function (item) {
                return item.label;
            },
            source: function (query, process) {
                return $.get('{{route('utility.loadSuburbs',['type'=>'pcode'])}}', {term: query}, function (data) {
                    return process(data);
                });
            },
            updater: function (item) {
                var id = this.$element.attr('data-id');
                if (!id) {
                    id = '';
                }
                $($inputSuburb + id).val(item.city);
                $($inputState + id).val(item.state);
                return item.postcode;
            },
            autoSelect: true
        });

        $('#entry_city').typeahead({
            displayText: function (item) {
                return item.label;
            },
            source: function (query, process) {
                return $.get('{{ route('utility.loadSuburbs',['type'=>'locality'])}}', {term: query}, function (data) {
                    return process(data);
                });
            },
            updater: function (item) {
                var id = this.$element.attr('data-id');
                if (!id) {
                    id = '';
                }
                $($inputPostcode + id).val(item.postcode);
                $($inputState + id).val(item.state);
                return item.city;
            },
            autoSelect: true
        });

        const ADDRESS_FINDER_AUTOCOMPLETE_URL = 'https://api.addressfinder.io/api/au/address/autocomplete?';
        //const ADDRESS_FINDER_AUTOCOMPLETE_URL = '/dummy-address?';
        const ADDRESS_FINDER_DEMO_KEY = 'RGAXB6JNV7PU3WELQFY8';
        var source = ADDRESS_FINDER_AUTOCOMPLETE_URL + 'key=' + ADDRESS_FINDER_DEMO_KEY + '&max=5';
        var map = {};
        $('.typeahead-full-address').typeahead({
            name: 'full_address',
            minLength: 3,
            autoSelect: false,
            restrictInputToDatum: true,
            displayText: function (item) {
                return item.full_address;
            },
            source: function (query, process) {
                if($.ajaxSettings.hasOwnProperty('headers')){
                    var qtssid = $.ajaxSettings.headers["X-QT-SSID"];
                    delete $.ajaxSettings.headers["X-QT-SSID"];
                }
                var tmpReturn = $.get(source, {q: query}, function (data) {
                    data = data.completions;
                    data.push({
                        'id': 0,
                        'full_address': "<b style='color:red'>Address Not Found? Enter manually</b>"
                    });

                    // objects = [];
                    map = {};
                    $.each(data, function (i, object) {
                        map[object.full_address] = object.id;
                    });
                    return process(data);
                });
                if(qtssid) {
                    $.ajaxSettings.headers["X-QT-SSID"] = qtssid;
                }
                return tmpReturn;
            },
            sorter: function (items) {
                return items; // no need to sort
            },
            matcher: function (item) {
                return true; // no need to do filter
            },
            updater: function (item) {
                var id = this.$element.attr('data-id');

                if (!id) {
                    id = '';
                }

                if (item.id === 0) {
                    $($detailsAddressBox + id).show();
                    $($fullAddressBox + id).hide();
                } else {

                    $.ajax({
                        type: 'GET',
                        url: "{{ route('verifyFullAddress')}}",
                        data: {
                            'address_id': item.canonical_address_id,
                            'full_address': item.full_address
                        },
                        success: function (data) {
                            $($inputPostcode + id).val(data.postcode);
                            $($inputState + id).val(data.state_territory);
                            $($inputSuburb + id).val(data.locality_name);
                            $($fullAddress + id).val(data.full_address);
                            $($addressLineOne + id).val(data.address_line_1);
                            $($addressLineTwo + id).val(data.address_line_2);

                        }
                    });
                }
            }
        })
        .blur(function () {
            var id = $(this).attr('data-id');
            if (!id) {
                id = '';
            }
            if (!map[$(this).val()]) {
                $($inputPostcode + id).val('');
                $($inputPostcode + id).val('');
                $($inputState + id).val('');
                $($fullAddress + id).val('');
                $($inputSuburb + id).val('');
                $($addressLineOne + id).val('');
                $($addressLineTwo + id).val('');
            }
        });

        $('.switch_back_to_address_lookup').click(function (e) {
            e.preventDefault();
            var id = $(this).attr('data-id');
            if (!id) {
                id = '';
            }
            $($detailsAddressBox + id).hide();
            $($fullAddressBox + id).show();
        });
    });
@endpush
