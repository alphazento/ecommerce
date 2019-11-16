<li class="searched-products__item">
    <a class="searched-products__image" href="{{ $product->getUrl() }}" title="{{ $product->getName(true) }}">
        <img src="{{ Store::catalog_image($product->products_image) }}"
             alt="{{ $product->getName(true) }}" title="{{ $product->getName(true) }}"
             class="products_image">
    </a>
    <div class="searched-products__shop">
        <div class="searched-products__shop-left">
            <a href="{{ $product->getUrl() }}">
                <strong>
                    <span class="text-small">{{ $product->getName(true) }}<br/>
                    @if ($product->getType() === 'any')
                            <span style="color:red;">Please Indicate your choice in checkout message box</span>
                        @endif
                    </span>
                </strong>
            </a>
            <div class="product-specs mt-5">
                @if($product->getColour())
                <div>Colour: {{ $product->getColour() }}</div>
                @endif
                @if($product->getYield())
                <div>Yield: {{ $product->getYield() }}</div>
                @endif
                @if($product->getOemCode())
                <div>OEM Code: {{ $product->getOemCode() }}</div>
                @endif
            </div>
        </div>
        <div class="searched-products__shop-right">
            @if (Product::isShippingFree($product->getSpecialPrice(), $product->products_weight))
                <div class="searched-products__free-shipping">
                    FREE SHIPPING
                </div>
            @endif
            <div class="searched-products__price">
                @if($product->getSpecialPrice(true) != $product->getPrice(true))
                    <span class="searched-products__price-old">
                        <s>{{ Sales::formatAsCurrency($product->getPrice(true), true) }}</s>
                    </span>
                    <span class="searched-products__price-new">{{ Sales::formatAsCurrency($product->getSpecialPrice(true), true) }}</span>
                @else
                    <span class="searched-products__price-new">{{ Sales::formatAsCurrency($product->getPrice(true), true) }}</span>
                @endif
            </div>

            <div class="searched-products__action clearfix">

                @if (!$product->isOutOfStock())
                <form name="buy_now" action="/cart/add/{{ $product->products_id }}" method="POST">
                    @csrf_field()
                    @include('components.numberselecter', ['properties' => ['name' => 'buyqty'], 'from' => 1, 'to' => 20])
                    <input type="submit" value="Add to Cart" class="button btn-shadow btn-cart">
                </form>
                @else
                    <div style="color:red;">Out of Stock</div>
                @endif
            </div>
        </div>
    </div>
</li>

