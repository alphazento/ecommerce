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
            @yield('pagecontent')
            {{-- <admin-footer></admin-footer> --}}
        </v-content>
    </v-app>
</div>

<script src=@asset("zento_backend/js/app.js") type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
@stack('admin.tail')
</body>
</html>
