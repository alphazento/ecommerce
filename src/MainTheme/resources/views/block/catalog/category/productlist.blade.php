@if($products)
  <div class="row">
    <div class="col-md-2 col-sm-6 hidden-xs">
      <div class="btn-group btn-group-sm">
        <button type="button" id="list-view" class="btn btn-default" data-toggle="tooltip" title="{{ 'button_list' }}"><i class="fa fa-th-list"></i></button>
        <button type="button" id="grid-view" class="btn btn-default" data-toggle="tooltip" title="{{ 'button_grid' }}"><i class="fa fa-th"></i></button>
      </div>
    </div>
    <div class="col-md-3 col-sm-6">
      <div class="form-group"><a href="{{ 'compare' }}" id="compare-total" class="btn btn-link">{{ __('text_compare') }}</a></div>
    </div>
    <div class="col-md-4 col-xs-6">
      <div class="form-group input-group input-group-sm">
        <label class="input-group-addon" for="input-sort">{{ __('text_sort') }}</label>
        <select id="input-sort" class="form-control" onchange="location = this.value;">
          @foreach($sorts ?? [] as $sort)
            @if($sort->value == '%s-%s' | format($sort, $order))
              <option value="{{ $sort->href }}" selected="selected">{{ $sort->text }}</option>
            @else
              <option value="{{ $sort->href }}">{{ $sort->text }}</option>
            @endif
          @endforeach
        </select>
      </div>
    </div>
    <div class="col-md-3 col-xs-6">
      <div class="form-group input-group input-group-sm">
        <label class="input-group-addon" for="input-limit">{{ 'text_limit' }}</label>
        <select id="input-limit" class="form-control" onchange="location = this.value;">
          @foreach($limits ?? [] as $limit)
            @if($limits.value == $limit)
              <option value="{{ $limits->href }}" selected="selected">{{ $limits->text }}</option>
            @else
              <option value="{{ $limits->href }}">{{ $limits->text }}</option>
            @endif
          @endforeach
        </select>
      </div>
    </div>
  </div>

  <div class="row"> @foreach($products as $product)
    <div class="product-layout product-list col-xs-12">
      <div class="product-thumb">
        <div class="image"><a href="{{ $product->href }}"><img src="{{ $product->thumb }}" alt="{{ $product->name }}" title="{{ $product->name }}" class="img-responsive" /></a></div>
        <div>
          <div class="caption">
            <h4><a href="{{ $product->href }}">{{ $product->name }}</a></h4>
            <p>{{ $product->description }}</p>
            @if($product->price)
            <p class="price"> @if(! $product->special)
              {{ $product->price }}
              @else <span class="price-new">{{ $product->special }}</span> <span class="price-old">{{ $product->price }}</span> @endif
              @if($product->tax) <span class="price-tax">{{ 'text_tax' }} {{ $product->tax }}</span> @endif </p>
            @endif
            @if($product->rating)
            <div class="rating"> @foreach([1,2,3,4,5] as $i)
              @if($product->rating < i) <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span> @else <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>@endif
              @endforeach </div>
            @endif </div>
          <div class="button-group">
            <button type="button" onclick="cart.add('{{ $product->product_id }}', '{{ $product->minimum }}');"><i class="fa fa-shopping-cart"></i> <span class="hidden-xs hidden-sm hidden-md">{{ 'button_cart' }}</span></button>
            <button type="button" data-toggle="tooltip" title="{{ 'button_wishlist' }}" onclick="wishlist.add('{{ $product->product_id }}');"><i class="fa fa-heart"></i></button>
            <button type="button" data-toggle="tooltip" title="{{ 'button_compare' }}" onclick="compare.add('{{ $product->product_id }}');"><i class="fa fa-exchange"></i></button>
          </div>
        </div>
      </div>
    </div>
    @endforeach </div>
    <div class="row">
    <div class="col-sm-6 text-left">{{ 'pagination' }}</div>
    <div class="col-sm-6 text-right">{{ 'results' }}</div>
  </div>
  @endif