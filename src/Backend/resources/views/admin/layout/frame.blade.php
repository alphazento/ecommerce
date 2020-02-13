<!DOCTYPE html>
<html>
<head>
    @include('admin.layout.head')
</head>

<body>
<div id="app" >
    <v-app>
        <spinner-layer></spinner-layer>
        <v-content>
            <admin-toolbar>
                <template v-slot:sns_login>
                    @stub('sns_login')
                </template>
            </admin-toolbar>
            <z-breadcrumbs divider=">"></z-breadcrumbs>
            @yield('pagecontent')
            {{-- <admin-footer></admin-footer> --}}
        </v-content>
    </v-app>
</div>

<script src=@asset("zento_backend/js/app.js") type="text/javascript"></script>
<script src=@asset("zento_backend/vendor/vuetify2.2.3.js") type="text/javascript"></script>
@stack('admin.tail')
</body>
</html>
