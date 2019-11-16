<a href="{{ route('cart') }}" class="no-count same-height-right dropdown-toggle" style="height: 13px;">
    <span>Cart <span class="price">{{ Sales::formatAsCurrency($quote->getSubTotal()) }}</span></span>
    <strong class="products-num">{{ $quote->getItemsQty() }}</strong>
</a>
@include('components.header-nav.minicart')
