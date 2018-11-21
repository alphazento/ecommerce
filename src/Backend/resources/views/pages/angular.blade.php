<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>
        {{$title}}
    </title>
    <base href="/{{$base}}/" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" type="image/x-icon" href="favicon.ico" />
</head>

<body>
    <app-root globals="{{$globals}}">
        <div class="spinner">
            <div class="double-bounce1">
            </div>
            <div class="double-bounce2">
            </div>
        </div>
    </app-root>
    <script type="text/javascript" src=@resource("/Zento/admin/ng/inline.bundle.js")></script>
    <script type="text/javascript" src=@resource("/Zento/admin/ng/polyfills.bundle.js")></script>
    <script type="text/javascript" src=@resource("/Zento/admin/ng/scripts.bundle.js")></script>
    <script type="text/javascript" src=@resource("/Zento/admin/ng/styles.bundle.js")></script>
    <script type="text/javascript" src=@resource("/Zento/admin/ng/vendor.bundle.js")></script>
    <script type="text/javascript" src=@resource("/Zento/admin/ng/main.bundle.js")></script>
</html>