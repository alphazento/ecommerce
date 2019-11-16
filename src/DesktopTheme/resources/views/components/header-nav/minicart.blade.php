<?php
    $value = 0;
    $couponDiscount = Sales::getAppliedCouponDiscount(Quote::now());
    if (!empty($couponDiscount)) {
        list($value, $description) = $couponDiscount;
    }
?>

<div class="dropdown-menu cart-dropdown">
    <div id="cart-sidebar">
        <div id="minicart-error-message" class="minicart-message odd"></div>
        <div id="minicart-success-message" class="minicart-message even"></div>
        <div class="block-content" id="topCartContent">
            <div class="box-content">
                @if ($quote->isEmpty())
                    <div>
                        <div class="mini-cart-title">YOUR CART IS EMPTY</div>
                    </div>
                @else
                    <div class="mini-cart-title">
                        {{count(Quote::now()->getItems())}} ITEMS
                    </div>
                    <div class="mini-cart-product-list">
                        @foreach(Quote::now()->getItems() as $item)
                        <div class="min-cart-product-info">
                            <div class="col-sm-4 col-4 nopadding">
                                <a href="{{ $item->url }}">
                                    <img src="{{ $item->image }}"  alt="{{ $item->getName() }}"  title="{{ $item->getName() }}" style="width: 80px;"/>
                                </a>
                            </div>
                            <div class="col-sm-7 col-7 no-padding">
                                <div>
                                    <a href="{{ $item->url }}"><span class="mini-cart-product-name">{{ $item->getName() }}</span></a>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-4">
                                        <p>Qty: {{ $item->getQty() }}</p>
                                    </div>
                                    <div class="col-md-8 col-8">
                                        <span>Unit Price: </span>
                                        <p class="mini-cart-product-price">{{ Sales::formatAsCurrency($item->price) }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-1 col-1 no-padding">
                                <a style="text-decoration: none" href="/cart/remove/{{ $item->product_id }}" title="Remove This Item"><span class="mini-cart-remove-product">x</span></a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @if ($value !== 0)
                    <div>
                        <span>Coupon</span>
                        <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="{{ $description }}"></i>
                        <span>:</span>
                        <span>{{ Sales::formatAsCurrency($value) }}</span>
                    </div>
                    @endif
                    <div>Subtotal: {{ Sales::formatAsCurrency($quote->getSubTotal()) }}</div>
                    <hr>
                    <ul class="actions">
                        <li><a href="{{ route('cart') }}" class="button black">VIEW CART</a></li>
                        <li><a href="{{ route('checkout') }}" class="button" title="Checkout">Checkout</a></li>
                    </ul>
                @endif
            </div>
        </div>
    </div>
</div>
