<!DOCTYPE html>
<html>
<head>
    <script src=@asset("zento_vuedesktoptheme/js/app.js") type="text/javascript"></script>
    @include('layout.head')
    <style>
        #app {
            max-width: 1440px;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>

<body>
@include('layout.header')
@include('widget.breadcrumb')
@yield('pagecontent')
@include('layout.footer')
</body>
</html>
