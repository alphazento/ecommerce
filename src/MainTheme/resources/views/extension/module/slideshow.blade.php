<div class="swiper-viewport">
<?php $module = 0; ?>
  <div id="slideshow{{ $module }}" class="swiper-container">
    <div class="swiper-wrapper"> 
    @foreach($banners as $banner)
      <div class="swiper-slide text-center">
      @if($banner->link)
        <a href="{{ $banner->link }}"><img src="{{ $banner->image }}" alt="{{ $banner->title }}" class="img-responsive" /></a>
      @else
        <img src="{{ $banner->image }}" alt="{{ $banner->title }}" class="img-responsive" />
      @endif
      </div>
    @endforeach
    </div>
  </div>
  <div class="swiper-pagination slideshow{{ $module }}"></div>
  <div class="swiper-pager">
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
  </div>
</div>
<script type="text/javascript"><!--
$('#slideshow{{ $module }}').swiper({
	mode: 'horizontal',
	slidesPerView: 1,
	pagination: '.slideshow{{ $module }}',
	paginationClickable: true,
	nextButton: '.swiper-button-next',
    prevButton: '.swiper-button-prev',
    spaceBetween: 30,
	autoplay: 2500,
    autoplayDisableOnInteraction: true,
	loop: true
});
--></script>