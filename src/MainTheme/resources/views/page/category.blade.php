@extends(config('category.layout', 'layout.default'))

@section('content')
  @foreach($content_top ?? [] as $module)
    @include($module[0], $module[1])
  @endforeach
  <h2>{{ $heading_title }}</h2>
  @if($thumb or $description)
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
    <h3>{{ __('refine') }}</h3>
    @if($categories|length <= 5)
    <div class="row">
      <div class="col-sm-3">
        <ul>
          @foreach($categories as $categorie)
          <li><a href="{{ $category->href }}">{{ $category->name }}</a></li>
          @endforeach
        </ul>
      </div>
    </div>
    @else
    <div class="row">@foreach($categories as $category)
      <div class="col-sm-3">
        <ul>
          @foreach($category as $child)
          <li><a href="{{ $child->href }}">{{ $child->name }}</a></li>
          @endforeach
        </ul>
      </div>
      @endforeach</div>
    <br />
    @endif
  @endif
  @include('block.catalog.product.list')
  @if($not categories and not products)
  <p>{{ __('text_empty') }}</p>
  <div class="buttons">
    <div class="pull-right"><a href="{{ 'continue' }}" class="btn btn-primary">{{ __('button_continue') }}</a></div>
  </div>
  @endif
@endsection
