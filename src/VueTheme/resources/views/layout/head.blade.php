<meta content="text/html; charset=UTF-8" http-equiv="content-type">
<link rel="icon" href=@asset(config(\Zento\StoreFront\Consts::LOGO))>
<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
<link href=@asset("zento_vuetheme/vendor/materialdesignicons4.9.95/css/materialdesignicons.min.css") rel="stylesheet">
<link href=@asset("zento_vuetheme/vendor/vuetify.min.css") rel="stylesheet">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="api-guest-token" content="{{ $apiGuestToken }}">
@stub('head')
@stack('head')
