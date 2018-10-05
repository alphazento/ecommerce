<div class="swiper-viewport">
  <div id="carousel{{ $module }}" class="swiper-container">
    <div class="swiper-wrapper">
    @foreach($banners as $banner)
      <div class="swiper-slide text-center">
      @if($banner->link)
        <a href="{{ $banner->link }}"><img src="{{ '/images/'. $banner->image }}" alt="{{ $banner->title }}" class="img-responsive" /></a>
      @else
        <img src="{{ '/images/'. $banner->image }}" alt="{{ $banner->title }}" class="img-responsive" />
      @endif
      </div>
    @endforeach
  </div>
  <div class="swiper-pagination carousel{{ $module }}"></div>
  <div class="swiper-pager">
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
  </div>
</div>
<script type="text/javascript"><!--
$('#carousel{{ $module }}').swiper({
	mode: 'horizontal',
	slidesPerView: 5,
	pagination: '.carousel{{ $module }}',
	paginationClickable: true,
	nextButton: '.swiper-button-next',
    prevButton: '.swiper-button-prev',
	autoplay: 2500,
	loop: true
});
--></script>