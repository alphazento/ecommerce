<div class="swiper-viewport">
  <div id="banner{{ $module }}" class="swiper-container">
    <div class="swiper-wrapper">
      @foreach($banners as $banner)
      <div class="swiper-slide">
      @if($banner->link)
        <a href="{{ $banner->link }}"><img src="{{ $banner->image }}" alt="{{ $banner->title }}" class="img-responsive" /></a>
      @else
        <img src="{{ $banner->image }}" alt="{{ $banner->title }}" class="img-responsive" />
      @endif
      </div>
      @endforeach</div>
  </div>
</div>
<script type="text/javascript"><!--
$('#banner{{ $module }}').swiper({
	effect: 'fade',
	autoplay: 2500,
    autoplayDisableOnInteraction: false
});
--></script> 