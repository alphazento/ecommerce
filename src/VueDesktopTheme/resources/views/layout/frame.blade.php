<!DOCTYPE html>
<html>
<head>
    <script src=@asset("zento_vuedesktoptheme/js/app.js") type="text/javascript"></script>
    @include('layout.head')
</head>

<body>
<div id="app" >
    <v-app>
        <v-content>
            <v-container>
                <theme-toolbar :logo="'@asset("/baicy_desktoptheme/image/logo.png")'"> </theme-toolbar>
                @include('widget.breadcrumbs')
                @yield('pagecontent')
                <theme-footer></theme-footer>
            </v-container>
        </v-content>
    </v-app>
</div>
<script src=@asset("zento_vuedesktoptheme/js/app.js") type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
@stack('tail')
</body>
</html>
