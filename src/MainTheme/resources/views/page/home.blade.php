@extends(config('home.layout', 'layout.default'))

@section('content')
@if($content_top_modules ?? false)
<aside id="column-left" class="col-sm-3 hidden-xs">
  @foreach($content_top_modules as $module)
    @include($module[0], $module[1])
  @endforeach
</aside>
@endif
@endsection