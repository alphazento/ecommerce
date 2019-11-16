@pushonce('autocomplete-address', 'styles')
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
@endpushonce

@pushonce('autocomplete-address', 'rqjs_configs')
    require_add_config('addressFinder', @asset("/tonercitytheme/assets/js/addressfinder"), {
        deps: [],
        exports: 'addressFinder'
    });
@endpushonce

@pushonce('autocomplete-address', 'rqjs_body')
requirejs(['addressFinder'], function (addressFinder) {
    addressFinder.init('RGAXB6JNV7PU3WELQFY8', '', "{{ route('verifyFullAddress')}}", 3);
});
@endpushonce
