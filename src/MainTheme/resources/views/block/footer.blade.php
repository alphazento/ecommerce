<footer>
  <div class="container">
    <div class="row">
      @if($informations ?? false)
      <div class="col-sm-3">
        <h5>{{ __('information') }}</h5>
        <ul class="list-unstyled">
        @foreach ($informations as $information)
          <li><a href="{{ $information->href }}">{{ $information->title }}</a></li>
        @endforeach
        </ul>
      </div>
      @endif
      <div class="col-sm-3">
        <h5>{{ __('service') }}</h5>
        <ul class="list-unstyled">
          <li><a href="{{ route('contact') }}">{{ __('contact') }}</a></li>
          <li><a href="{{ route('return') }}">{{ __('return') }}</a></li>
          <li><a href="{{ route('sitemap') }}">{{ __('sitemap') }}</a></li>
        </ul>
      </div>
      <div class="col-sm-3">
        <h5>{{ __('extra') }}</h5>
        <ul class="list-unstyled">
          <li><a href="{{ route('manufacturer') }}">{{ __('manufacturer') }}</a></li>
          <li><a href="{{ route('voucher') }}">{{ __('voucher') }}</a></li>
          <li><a href="{{ route('affiliate') }}">{{ __('affiliate') }}</a></li>
          <li><a href="{{ route('special') }}">{{ __('special') }}</a></li>
        </ul>
      </div>
      <div class="col-sm-3">
        <h5>{{ __('account') }}</h5>
        <ul class="list-unstyled">
          <li><a href="{{ route('account') }}">{{ __('account') }}</a></li>
          <li><a href="{{ route('order') }}">{{ __('order') }}</a></li>
          <li><a href="{{ route('wishlist') }}">{{ __('wishlist') }}</a></li>
          <li><a href="{{ route('newsletter') }}">{{ __('newsletter') }}</a></li>
        </ul>
      </div>
    </div>
    <hr>
    <p>{!! config('copyright', 'Powered By <a href="http://www.alphazento.com">AlaphaZento</a><br> Your Store © 2018') !!}</p>
  </div>
</footer>
@stack('scripts')