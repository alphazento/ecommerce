<h3>Featured</h3>
<div class="row">
 @foreach($products as $product)
  <div class="product-layout col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <div class="product-thumb transition">
      <div class="image">
        <a href="{{ $product->url_path }}">
          <img src="{{ '/images/catalog/product/'. $product->image }}" alt="{{ $product->name }}" title="{{ $product->name }}" class="img-responsive" />
        </a>
      </div>
      <div class="caption">
        <h4><a href="{{ $product->url_path }}">{{ $product->name }}</a></h4>
        <p>{!! $product->description !!}</p>
        @if($product->rating)
        <div class="rating">
          @for($i =1; $i<6; $i++)
           @if($product->rating < $i)
           <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
           @else
           <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
           @endif
          @endfor
        </div>
        @endif
        @if($product->price)
        <p class="price">
          @if(!$product->special_price)
          {{ $product->price }}
          @else
          <span class="price-new">{{ $product->special_price }}</span> <span class="price-old">{{ $product->special_price }}</span>
          @endif
          @if($product->tax)
          <span class="price-tax">{{ __('tax') }} {{ $product->tax }}</span>
          @endif
        </p>
         @endif
      </div>
      <div class="button-group">
        <button type="button" onclick="mycart.add('{{ $product->id }}');"><i class="fa fa-shopping-cart"></i> <span class="hidden-xs hidden-sm hidden-md">{{ __('add to cart') }}</span></button>
        <button type="button" data-toggle="tooltip" title="{{ __('add to wishlist')  }}" onclick="wishlist.add('{{ $product->id }}');"><i class="fa fa-heart"></i></button>
        <button type="button" data-toggle="tooltip" title="{{ __('add to compare')  }}" onclick="compare.add('{{ $product->id }}');"><i class="fa fa-exchange"></i></button>
      </div>
    </div>
  </div>
  @endforeach
</div>

<script>
var mycart = {
	'add': function(product_id, quantity) {
		$.ajax({
			url: '/cart/items/add',
			type: 'post',
			data: '_token={{csrf_token()}}&product_id=' + product_id + '&quantity=' + (typeof(quantity) != 'undefined' ? quantity : 1),
			dataType: 'json',
			beforeSend: function() {
				$('#cart > button').button('loading');
			},
			complete: function() {
				$('#cart > button').button('reset');
			},
			success: function(json) {
				$('.alert-dismissible, .text-danger').remove();

				if (json['redirect']) {
					location = json['redirect'];
				}

				if (json['success']) {
					$('#content').parent().before('<div class="alert alert-success alert-dismissible"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');

					// Need to set timeout otherwise it wont update the total
					setTimeout(function () {
						$('#cart > button').html('<span id="cart-total"><i class="fa fa-shopping-cart"></i> ' + json['total'] + '</span>');
					}, 100);

					$('html, body').animate({ scrollTop: 0 }, 'slow');

					$('#cart > ul').load('index.php?route=common/cart/info ul li');
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
  }
};
</script>
