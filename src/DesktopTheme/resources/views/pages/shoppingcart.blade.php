@extends('layouts.3columns')

<?php BladeTheme::breadcrumb(route('cart'), 'Shopping Cart'); ?>

@push('head')
    <link rel="stylesheet" href=@asset("/tonercitytheme/assets/css/checkout.css")>
@endpush
@push('styles')
    .empty-shopping-cart{
        text-align: center;
        min-height: 300px;
    }
    .empty-shopping-cart .title{
        font-size: 20px;
        font-weight: 600;
    }
@endpush

@section('custom')
    @if(!$quote->isEmpty())
        <div class="container">
            <div class="cart_content">
                <div class="cart_content__left">

                    <p class="text-right">
                        All Prices Include G.S.T.
                    </p>

                    <div class="cart_content__table_wrapper table-responsive">
                        <table class="table table-borderless">
                            <thead>
                            <thead>
                            <tr>
                                <th class="" scope="col"><span>Item</span></th>
                                <th class="text-right" scope="col"><span>Qty</span></th>
                                <th class="text-right" scope="col"><span>Subtotal</span></th>
                            </tr>
                            </thead>
                            <tbody class="cart__item">

                            @foreach($quote->getItems() as $item)
                                <tr class="cart__item-details">
                                    <td class="col item">
                                        <div style="width: 100%;">
                                            <div style="width: 25%; float: left;">
                                            <a class="cart__item-img-wrapper" href="{{ $item->url }}"
                                                     title="{{ $item->getName() }}">
                                                <img class="img-fluid"
                                                     src="{{ $item->image }}"
                                                     alt="{{ $item->getName() }}"
                                                     title="{{ $item->getName() }}" width="130" height="130">
                                            </a>
                                            </div>
                                            <div class="cart__item-name" style="width: 75%; float: right; font-size: 15px;">
                                                <a href="{{ $item->url }}">{{ $item->getName() }}</a>
                                                <strong class="product-quantity"> × {{$item->getQty()}}</strong>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="col qty">
                                        <form name="buy_now" action="{{ route('cart.update', ['product' => $item->product_id]) }}"
                                              method="POST">
                                            @csrf_field()
                                            @include('components.numberselecter', ['properties'=>['name'=>'buyqty', 'onchange'=>'this.form.submit()'], 'from'=>1, 'to'=>20, 'selected'=> $item->getQty()])
                                        </form>
                                    </td>
                                    <td class="col cart__item-total">
                                        {{ Sales::formatAsCurrency($item->getOriginalRowTotal()) }}
                                    </td>
                                </tr>


                                <tr class="cart__item-actions">
                                    <td colspan="4">
                                        <div class="clearfix">
                                            <a class="cart__item-move float-right"
                                               href="{{ route('cart.remove', ['product' => $item->product_id]) }}"><span class="fa fa-trash"></span></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="cart__main-actions text-right">
                        <div class="row mb-5">
                            <div class="col">
                                <div class="apply_discount_code">
                                    <span class="form_show">Apply Discount Code <span class="arrow_symbol"><i class="fa fa-caret-{{ $appliedCouponCode ? 'up' : 'down' }}"></i></span></span>
                                </div>
                                <form id="coupon_checker_form" style="display: {{ $appliedCouponCode ? 'block' : 'none' }};" name="coupon_checker"
                                      action="{{ route('cart.applyCoupon') }}"
                                      method="post">
                                    <div class="coupon_input_part">
                                        @csrf_field()
                                        <input value="{{ $appliedCouponCode ? $appliedCouponCode : old('coupon') }}"
                                               name="coupon"
                                               id="coupon_code"
                                               placeholder="Enter coupon code here"
                                               size="16"
                                               maxlength="32"
                                               class="form-control"
                                               type="text">

                                        <button class="button" name="apply_coupon">Apply</button>
                                    </div>
                                </form>
                            </div>
                            <div class="col">
                                <a href="{{ $backurl }}" id="continue_shopping_link">Continue Shopping</a>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="cart_content__right">
                    <div class="cart-summary mb-4 sticky-top">
                        <h2 class="cart-summary__h2">Summary</h2>
                        <div class="mb-4">
                            <table>
                                <tbody>
                                @foreach(Sales::getQuoteDisplayItems(Quote::now()) as $displayItem)
                                    <tr class="cart-summary__list">
                                        <td>{{ $displayItem['title'] }}:</td>
                                        <td class="text-right">{{ $displayItem['valueText'] }}</td>
                                    </tr>
                                @endforeach
                                <tr class="cart-summary__totals">
                                    <td><strong>Order Total:</strong></td> <td class="text-right"><strong>{{ Sales::formatAsCurrency(Quote::now()->getGrandTotal()) }}</strong></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="p-2 text-center">
                            <a href="{{ route('checkout') }}" class="cart-summary__checkout">Proceed to checkout</a>
                        </div>
                        <div class="p-2 text-center">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="empty-shopping-cart">
            <p class="title">Shopping Cart is Empty</p>
            <p>You have no items in your shopping cart.</p>
            <p>Click <a href="/">here</a> to continue shopping</p>
        </div>
    @endif
@endsection

@push('rqjs_body')
    requirejs(["jQuery"], function ($){
        $('.form_show').click(function(){
            var $form = $(this).parent().siblings('#coupon_checker_form');
            var $arrowSymbol = $(this).find('.arrow_symbol');
            if($form.is(':visible')){
                $form.hide();
                $arrowSymbol.html('<i class="fa fa-caret-down"></i>');
            }else{
                $form.show();
                $arrowSymbol.html('<i class="fa fa-caret-up"></i>')
            }
        });

    });
@endpush
