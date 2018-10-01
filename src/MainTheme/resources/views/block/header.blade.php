<header>
  <div class="container">
    <div class="row">
      <div class="col-sm-4">
        <div id="logo">
        @if($logo)
            <a href="/"><img src="{{ $logo }}" title="{{ $name }}" alt="{{ $name }}" class="img-responsive" /></a>
        @else
            <h1><a href="/">{{ $name }}</a></h1>
        @endif
        </div>
      </div>
      <div class="col-sm-5">
        @include(config('block.search', 'block.search'))
      </div>
      <div class="col-sm-3">
        <!-- include(config('block.cart', 'block.cart')) -->
      </div>
    </div>
  </div>
</header>