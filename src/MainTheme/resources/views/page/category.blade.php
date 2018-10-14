@extends(config('category.layout', 'layout.default'))

@section('content')
  @foreach($content_top ?? [] as $module)
    @include($module[0], $module[1])
  @endforeach
  <h2>{{ $heading_title }}</h2>
  @if(($thumb ?? false) || $description)
  <div class="row"> @if($thumb)
    <div class="col-sm-2"><img src="{{ $thumb }}" alt="{{ $heading_title }}" title="{{ $heading_title }}" class="img-thumbnail" /></div>
    @endif
    @if($description)
    <div class="col-sm-10">{{ $description }}</div>
    @endif
  </div>
  <hr>
  @endif
  @if($categories)
    <h3>{{ __('Refine Search') }}</h3>
    @if(count($categories) <= 5)
    <div class="row">
      <div class="col-sm-3">
        <ul>
          @foreach($categories as $category)
          <li><a href="{{ $category['href'] }}">{{ $category['name'] }}</a></li>
          @endforeach
        </ul>
      </div>
    </div>
    @else
    <div class="row">
      @foreach($categories as $category)
      <div class="col-sm-3">
        <ul>
          @foreach($children as $child)
          <li><a href="{{ $child->href }}">{{ $child->name }}</a></li>
          @endforeach
        </ul>
      </div>
      @endforeach</div>
    <br />
    @endif
  @endif
  @if($products)
    @include('block.catalog.category.productlist')
  @endif
  @if(!$categories && !$products)
  <p>{{ __('text_empty') }}</p>
  <div class="buttons">
    <div class="pull-right"><a href="{{ 'continue' }}" class="btn btn-primary">{{ __('button_continue') }}</a></div>
  </div>
  @endif
@endsection
