@extends(config('home.layout', 'layout.default'))

@section('content')
  @foreach($content_top ?? [] as $module)
    @include($module[0], $module[1])
  @endforeach
@endsection