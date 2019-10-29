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
                <toolbar :logo="'@asset("/baicy_desktoptheme/image/logo.png")'"> </toolbar>
                @yield('pagecontent')
                <myfooter/>
            </v-container>
        </v-content>
    </v-app>
</div>
<script src=@asset("zento_vuedesktoptheme/js/app.js") type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
@stack('tail')
</body>
</html>
