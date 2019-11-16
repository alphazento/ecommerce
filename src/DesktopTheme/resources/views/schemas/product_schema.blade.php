<div>
    <span itemscope itemtype="https://schema.org/Product" class="microdata">
        <meta itemprop="image" content="{{ $imageUrl }}">
        <meta itemprop="name" content="{{$productName}}">
        <meta itemprop="description" content="{{ $desc }}">
        <span itemprop="offers" itemscope itemtype="https://schema.org/Offer">
            @if($specialPrice != $normalPrice)
                <meta itemprop="price" content="{{$specialPrice }}">
            @else
                <meta itemprop="price" content="{{$normalPrice }}">
            @endif
            <meta itemprop="priceCurrency" content="AUD">
        <meta itemprop="availability" content="{{ !$isOutOfStock ? 'in stock' : 'out of stock'}}">
        <meta itemprop="itemCondition" content="new">
    </span>
  </span>
</div>