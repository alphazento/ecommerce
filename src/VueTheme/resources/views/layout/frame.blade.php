<!DOCTYPE html>
<html>
<head>
    @include('layout.head')
</head>

<body>
<div id="app" >
    <v-app>
        <v-content>
            <theme-manager></theme-manager>
            <v-container>
                <theme-toolbar :logo="'@asset("/baicy_desktoptheme/image/logo.png")'" >
                    <template v-slot:breadcrumbs>
                        @if ($nav_page !== 'home')
                            @include('widget.breadcrumbs')
                        @endif
                    </template>
                    <template v-slot:category_menus>
                        @include('widget.category-menu')
                    </template>
                    <template v-slot:navigation_drawer="slot_props">
                        @include('widget.navigation-drawer')
                    </template>
                    <template v-slot:sns_login>
                    </template>
                </theme-toolbar>
                @yield('pagecontent')
                <theme-footer></theme-footer>
            </v-container>
        </v-content>
    </v-app>
</div>
@php 
$appjs = $appjs ?? 'app.js';
@endphp

<script src=@asset("zento_vuetheme/js/" . $appjs) type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
<script>
    window.themeData = @json($themeData); 
</script>
@stack('tail')
</body>
</html>
