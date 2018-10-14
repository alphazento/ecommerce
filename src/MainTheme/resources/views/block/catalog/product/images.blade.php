@if($product->thumb || $product->images)
    <ul class="thumbnails">
    @if($product->thumb ?? false)
    <li><a class="thumbnail" href="{{ 'popup' }}" title="{{ 'heading_title' }}"><img src="{{ $product->thumb }}" title="{{ 'heading_title' }}" alt="{{ 'heading_title' }}" /></a></li>
    @endif
    @foreach($product->images ?? [] as $image)
    <li class="image-additional"><a class="thumbnail" href="{{ $image->popup }}" title="{{ 'heading_title' }}"> <img src="{{ $image->thumb }}" title="{{ 'heading_title' }}" alt="{{ 'heading_title' }}" /></a></li>
    @endforeach
    </ul>
@endif