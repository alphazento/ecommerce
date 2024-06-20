<!DOCTYPE html>
<html>
<head>
    @include('layout.head')
</head>

<script src=@asset("zento_vuetheme/js/" . ($appjs ?? 'app.js')) type="text/javascript"></script>
<script src=@asset("zento_vuetheme/vendor/vuetify2.2.3.js") type="text/javascript"></script>
<script>
    window.appData = @json($appData);
    Vue.prototype.catalogMediaUrl = function(subType, url) {
        var baseUrl = window.appData.mediaLibs.catalog;
        return `${baseUrl}/${subType}${url}`;
    };
    Vue.prototype.productUrl = function(url) {
        return `${url}.html`;
    };
</script>

<body>
@include('layout.preloader')

<div id="app" >
    <v-app v-show="loaded">
        <v-content>
            <theme-manager></theme-manager>
            <theme-toolbar>
                <template v-slot:breadcrumbs>
                    @if ($nav_page !== 'home')
                        @include('widget.breadcrumbs')
                    @endif
                </template>
                <template v-slot:category_menus>
                    @include('widget.category-menu')
                </template>
                <template v-slot:navigation_drawer>
                    @stub('navigation-drawer')
                </template>
                <template v-slot:sns_login>
                    @stub('sns_login')
                </template>
            </theme-toolbar>
            <spinner-layer></spinner-layer>
            @yield('pagecontent')
            <theme-footer></theme-footer>
        </v-content>
    </v-app>
</div>

@stack('tail')
</body>
</html>
