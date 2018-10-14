@extends(config('category.layout', 'layout.default'))

@section('content')
  @foreach($content_top ?? [] as $module)
    @include($module[0], $module[1])
  @endforeach
      <div class="row">
      @if(($column_left ?? false) || ($column_right ?? false))
        <?php $class = 'col-sm-6' ?>
        @else
        <?php $class = 'col-sm-8' ?>
        @endif
        <div class="{{ $class }}">
          @include('block.catalog.product.images')
          @include('tabgroups')
        </div>
        <div class="{{ $class }}">
          <div class="btn-group">
            <button type="button" data-toggle="tooltip" class="btn btn-default" title="{{ 'button_wishlist' }}" onclick="wishlist.add('{{ 'product_id' }}');"><i class="fa fa-heart"></i></button>
            <button type="button" data-toggle="tooltip" class="btn btn-default" title="{{ 'button_compare' }}" onclick="compare.add('{{ 'product_id' }}');"><i class="fa fa-exchange"></i></button>
          </div>
          <h1>{{ 'heading_title' }}</h1>
          <ul class="list-unstyled">
            @if($product->manufacturer)
            <li>{{ 'text_manufacturer' }} <a href="{{ $product->manufacturer->url }}">{{ $product->manufacturer->name }}</a></li>
            @endif
            <li>{{ 'text_model' }} {{ 'model' }}</li>
            @if($reward ?? false)
            <li>{{ 'text_reward' }} {{ 'reward' }}</li>
            @endif
            <li>{{ 'text_stock' }} {{ $product->stock }}</li>
          </ul>
          @if($product->price)
          <ul class="list-unstyled">
            @if(!$product->special_price)
            <li>
              <h2>{{ $product->price }}</h2>
            </li>
            @else
            <li><span style="text-decoration: line-through;">{{ $product->price }}</span></li>
            <li>
              <h2>{{ $product->special_price }}</h2>
            </li>
            @endif
            @if($tax ?? false)
            <li>{{ 'text_tax' }} {{ 'tax' }}</li>
            @endif
            @if($points ?? false)
            <li>{{ 'text_points' }} {{ 'points' }}</li>
            @endif
            @if($discounts ?? false)
            <li>
              <hr>
            </li>
            @foreach($discounts as $discount )
            <li>{{ $discount->quantity }}{{ 'text_discount' }}{{ $discount->price }}</li>
            @endforeach
            @endif
          </ul>
          @endif

          <?php
          // <div id="product"> @if($options)
          //   <hr>
          //   <h3>{{ text_option }}</h3>
          //   @foreach(option in options)
          //   @if($option.type == 'select')
          //   <div class="form-group@if($option.required) required @endif">
          //     <label class="control-label" for="input-option{{ option.product_option_id }}">{{ option.name }}</label>
          //     <select name="option[{{ option.product_option_id }}]" id="input-option{{ option.product_option_id }}" class="form-control">
          //       <option value="">{{ text_select }}</option>
          //       @foreach(option_value in option.product_option_value)
          //       <option value="{{ option_value.product_option_value_id }}">{{ option_value.name }}
          //       @if($option_value.price)
          //       ({{ option_value.price_prefix }}{{ option_value.price }})
          //       @endif </option>
          //       @endforeach
          //     </select>
          //   </div>
          //   @endif
          //   @if($option.type == 'radio')
          //   <div class="form-group@if($option.required) required @endif">
          //     <label class="control-label">{{ option.name }}</label>
          //     <div id="input-option{{ option.product_option_id }}"> @foreach(option_value in option.product_option_value)
          //       <div class="radio">
          //         <label>
          //           <input type="radio" name="option[{{ option.product_option_id }}]" value="{{ option_value.product_option_value_id }}" />
          //           @if($option_value.image) <img src="{{ option_value.image }}" alt="{{ option_value.name }} @if($option_value.price) {{ option_value.price_prefix }} {{ option_value.price }} @endif" class="img-thumbnail" /> @endif                  
          //           {{ option_value.name }}
          //           @if($option_value.price)
          //           ({{ option_value.price_prefix }}{{ option_value.price }})
          //           @endif </label>
          //       </div>
          //       @endforeach </div>
          //   </div>
          //   @endif
          //   @if($option.type == 'checkbox')
          //   <div class="form-group@if($option.required) required @endif">
          //     <label class="control-label">{{ option.name }}</label>
          //     <div id="input-option{{ option.product_option_id }}"> @foreach(option_value in option.product_option_value)
          //       <div class="checkbox">
          //         <label>
          //           <input type="checkbox" name="option[{{ option.product_option_id }}][]" value="{{ option_value.product_option_value_id }}" />
          //           @if($option_value.image) <img src="{{ option_value.image }}" alt="{{ option_value.name }} @if($option_value.price) {{ option_value.price_prefix }} {{ option_value.price }} @endif" class="img-thumbnail" /> @endif
          //           {{ option_value.name }}
          //           @if($option_value.price)
          //           ({{ option_value.price_prefix }}{{ option_value.price }})
          //           @endif </label>
          //       </div>
          //       @endforeach </div>
          //   </div>
          //   @endif
          //   @if($option.type == 'text')
          //   <div class="form-group@if($option.required) required @endif">
          //     <label class="control-label" for="input-option{{ option.product_option_id }}">{{ option.name }}</label>
          //     <input type="text" name="option[{{ option.product_option_id }}]" value="{{ option.value }}" placeholder="{{ option.name }}" id="input-option{{ option.product_option_id }}" class="form-control" />
          //   </div>
          //   @endif
          //   @if($option.type == 'textarea')
          //   <div class="form-group@if($option.required) required @endif">
          //     <label class="control-label" for="input-option{{ option.product_option_id }}">{{ option.name }}</label>
          //     <textarea name="option[{{ option.product_option_id }}]" rows="5" placeholder="{{ option.name }}" id="input-option{{ option.product_option_id }}" class="form-control">{{ option.value }}</textarea>
          //   </div>
          //   @endif
          //   @if($option.type == 'file')
          //   <div class="form-group@if($option.required) required @endif">
          //     <label class="control-label">{{ option.name }}</label>
          //     <button type="button" id="button-upload{{ option.product_option_id }}" data-loading-text="{{ text_loading }}" class="btn btn-default btn-block"><i class="fa fa-upload"></i> {{ button_upload }}</button>
          //     <input type="hidden" name="option[{{ option.product_option_id }}]" value="" id="input-option{{ option.product_option_id }}" />
          //   </div>
          //   @endif
          //   @if($option.type == 'date')
          //   <div class="form-group@if($option.required) required @endif">
          //     <label class="control-label" for="input-option{{ option.product_option_id }}">{{ option.name }}</label>
          //     <div class="input-group date">
          //       <input type="text" name="option[{{ option.product_option_id }}]" value="{{ option.value }}" data-date-format="YYYY-MM-DD" id="input-option{{ option.product_option_id }}" class="form-control" />
          //       <span class="input-group-btn">
          //       <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
          //       </span></div>
          //   </div>
          //   @endif
          //   @if($option.type == 'datetime')
          //   <div class="form-group@if($option.required) required @endif">
          //     <label class="control-label" for="input-option{{ option.product_option_id }}">{{ option.name }}</label>
          //     <div class="input-group datetime">
          //       <input type="text" name="option[{{ option.product_option_id }}]" value="{{ option.value }}" data-date-format="YYYY-MM-DD HH:mm" id="input-option{{ option.product_option_id }}" class="form-control" />
          //       <span class="input-group-btn">
          //       <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
          //       </span></div>
          //   </div>
          //   @endif
          //   @if($option.type == 'time')
          //   <div class="form-group@if($option.required) required @endif">
          //     <label class="control-label" for="input-option{{ option.product_option_id }}">{{ option.name }}</label>
          //     <div class="input-group time">
          //       <input type="text" name="option[{{ option.product_option_id }}]" value="{{ option.value }}" data-date-format="HH:mm" id="input-option{{ option.product_option_id }}" class="form-control" />
          //       <span class="input-group-btn">
          //       <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
          //       </span></div>
          //   </div>
          //   @endif
          //   @endforeach
          //   @endif
          //   @if($recurrings)
          //   <hr>
          //   <h3>{{ text_payment_recurring }}</h3>
          //   <div class="form-group required">
          //     <select name="recurring_id" class="form-control">
          //       <option value="">{{ text_select }}</option>
          //       @foreach(recurring in recurrings)
          //       <option value="{{ recurring.recurring_id }}">{{ recurring.name }}</option>
          //       @endforeach
          //     </select>
          //     <div class="help-block" id="recurring-description"></div>
          //   </div>
          //   @endif
          //   <div class="form-group">
          //     <label class="control-label" for="input-quantity">{{ entry_qty }}</label>
          //     <input type="text" name="quantity" value="{{ minimum }}" size="2" id="input-quantity" class="form-control" />
          //     <input type="hidden" name="product_id" value="{{ product_id }}" />
          //     <br />
          //     <button type="button" id="button-cart" data-loading-text="{{ text_loading }}" class="btn btn-primary btn-lg btn-block">{{ button_cart }}</button>
          //   </div>
          //   @if($minimum > 1)
          //   <div class="alert alert-info"><i class="fa fa-info-circle"></i> {{ text_minimum }}</div>
          //   @endif</div>
          // @if($review_status)
          // <div class="rating">
          //   <p>@foreach(i in 1..5)
          //     @if($rating < i)<span class="fa fa-stack"><i class="fa fa-star-o fa-stack-1x"></i></span>@else)<span class="fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span>@endif
          //     @endforeach <a href="" onclick="$('a[href=\'#tab-review\']').trigger('click'); return false;">{{ reviews }}</a> / <a href="" onclick="$('a[href=\'#tab-review\']').trigger('click'); return false;">{{ text_write }}</a></p>
          //   <hr>
          //   <!-- AddThis Button BEGIN -->
          //   <div class="addthis_toolbox addthis_default_style" data-url="{{ share }}"><a class="addthis_button_facebook_like" fb:like:layout="button_count"></a> <a class="addthis_button_tweet"></a> <a class="addthis_button_pinterest_pinit"></a> <a class="addthis_counter addthis_pill_style"></a></div>
          //   <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-515eeaf54693130e"></script> 
          //   <!-- AddThis Button END --> 
          // </div>
          // @endif </div>
      // </div>
      // @if($products)
      // <h3>{{ text_related }}</h3>
      // <div class="row"> @set i = 0)
      //   @foreach(product in products)
      //   @if($column_left and column_right)
      //   @set class = 'col-xs-8 col-sm-6')
      //   @elseif column_left or column_right)
      //   @set class = 'col-xs-6 col-md-4')
      //   @else)
      //   @set class = 'col-xs-6 col-sm-3')
      //   @endif
      //   <div class="{{ class }}">
      //     <div class="product-thumb transition">
      //       <div class="image"><a href="{{ product.href }}"><img src="{{ product.thumb }}" alt="{{ product.name }}" title="{{ product.name }}" class="img-responsive" /></a></div>
      //       <div class="caption">
      //         <h4><a href="{{ product.href }}">{{ product.name }}</a></h4>
      //         <p>{{ product.description }}</p>
      //         @if($product.rating)
      //         <div class="rating"> @foreach(j in 1..5)
      //           @if($product.rating < j) <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-1x"></i></span> @else) <span class="fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span> @endif
      //           @endforeach </div>
      //         @endif
      //         @if($product.price)
      //         <p class="price"> @if($not product.special)
      //           {{ product.price }}
      //           @else) <span class="price-new">{{ product.special }}</span> <span class="price-old">{{ product.price }}</span> @endif
      //           @if($product.tax) <span class="price-tax">{{ text_tax }} {{ product.tax }}</span> @endif </p>
      //         @endif </div>
      //       <div class="button-group">
      //         <button type="button" onclick="cart.add('{{ product.product_id }}', '{{ product.minimum }}');"><span class="hidden-xs hidden-sm hidden-md">{{ button_cart }}</span> <i class="fa fa-shopping-cart"></i></button>
      //         <button type="button" data-toggle="tooltip" title="{{ button_wishlist }}" onclick="wishlist.add('{{ product.product_id }}');"><i class="fa fa-heart"></i></button>
      //         <button type="button" data-toggle="tooltip" title="{{ button_compare }}" onclick="compare.add('{{ product.product_id }}');"><i class="fa fa-exchange"></i></button>
      //       </div>
      //     </div>
      //   </div>
      //   @if($column_left and column_right and (i + 1) % 2 == 0)
      //   <div class="clearfix visible-md visible-sm"></div>
      //   @elseif column_left or column_right and (i + 1) % 3 == 0)
      //   <div class="clearfix visible-md"></div>
      //   @elseif (i + 1) % 4 == 0)
      //   <div class="clearfix visible-md"></div>
      //   @endif
      //   @set i = i + 1)
      //   @endforeach </div>
      //   @endif
      //   @if($tags)
      //   <p>{{ text_tags }}
      //   @foreach(i in 0..tags|length)
      //   @if($i < (tags|length - 1)) <a href="{{ tags[i].href }}">{{ tags[i].tag }}</a>,
      //   @else) <a href="{{ tags[i].href }}">{{ tags[i].tag }}</a> @endif
      //   @endforeach </p>
      //   @endif
        ?>
      
      @foreach($content_bottom ?? [] as $module)
        @include($module[0], $module[1])
      @endforeach
      </div>
      @foreach($column_right ?? [] as $module)
        @include($module[0], $module[1])
      @endforeach</div>
</div>
@endsection
