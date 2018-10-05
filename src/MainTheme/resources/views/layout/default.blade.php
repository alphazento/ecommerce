<!DOCTYPE html>
<!--[if IE]><![endif]-->
<!--[if IE 8 ]><html dir="{{ $direction }}" lang="{{ $lang }}" class="ie8"><![endif]-->
<!--[if IE 9 ]><html dir="{{ $direction }}" lang="{{ $lang }}" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html dir="{{ $direction }}" lang="{{ $lang }}">
<!--<![endif]-->
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  @include(config('block.seo', 'block.seo'))
  <script src="/zento/maintheme/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript"></script>
  <link href="/zento/maintheme/javascript/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen" />
  <script src="/zento/maintheme/javascript/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
  <link href="/zento/maintheme/javascript/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
  <link href="//fonts.googleapis.com/css?family=Open+Sans:400,400i,300,700" rel="stylesheet" type="text/css" />
  <link href="/zento/maintheme/stylesheet/stylesheet.css" rel="stylesheet">
  <script src="/zento/maintheme/javascript/common.js" type="text/javascript"></script>

  <link href='/zento/maintheme/catalog/view/javascript/jquery/swiper/css/swiper.min.css' rel="stylesheet" type="text/css" />
	<link href='/zento/maintheme/catalog/view/javascript/jquery/swiper/css/opencart.css' rel="stylesheet" type="text/css" />
	<script src="/zento/maintheme/catalog/view/javascript/jquery/swiper/js/swiper.jquery.js" type="text/javascript"></script>
		
  @stack('styles')
  @stack('scripts')
  @stack('links')
  @stack('analytics')
</head>
<body>
  @include(config('block.nav', 'block.nav'))
  @include(config('block.header', 'block.header'))
  @include(config('block.menu', 'block.menu'))

  <div id="{{ $page_name }}" class="container">
    @if ($breadcrumb ?? false)
      <ul class="breadcrumbs">
        @foreach($breadcrumbs of $breadcrumb %}
        <li><a href="{{ $breadcrumb->href }}">{{ $breadcrumb->text }}</a></li>
        @endforeach
      </ul>
    @endif
    <div class="row">
    @if($column_left ?? false)
      <aside id="column-left" class="col-sm-3 hidden-xs">
        @foreach($column_left  as $module)
          @include($module[0], $module[1])
        @endforeach
      </aside>
    @endif
    @if(($column_left ?? false) && ($column_right ?? false))
      @php $class = 'col-sm-6'; @endphp
    @elseif(($column_left ?? false) || ($column_right ?? false))
      @php $class = 'col-sm-9'; @endphp
    @else
      @php $class = 'col-sm-12'; @endphp
    @endif
    <div id="content" class="{{ $class }}">
      @yield('content')
    </div>
    @if($column_right ?? false)
      <aside id="column-right" class="col-sm-3 hidden-xs">
        @foreach($column_right as $module)
          @include($module[0], $module[1])
        @endforeach
      </aside>
    @endif
    </div>
  </div>

  @include(config('block.footer', 'block.footer'))

</body>
</html>