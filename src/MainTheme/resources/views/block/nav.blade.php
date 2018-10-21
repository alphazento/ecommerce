<nav id="top">
  <div class="container">{{ config('store.currency') }}
    {{ 'language' }}
    <div id="top-links" class="nav pull-right">
      <ul class="list-inline">
        <li><a href="{{ route('contact') }}"><i class="fa fa-phone"></i></a> <span class="hidden-xs hidden-sm hidden-md"> telephone </span></li>
        <li class="dropdown"><a href="{{ route('account') }}" title="{{ __('account') }}" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <span class="hidden-xs hidden-sm hidden-md">{{ __('account') }}</span> <span class="caret"></span></a>
          <ul class="dropdown-menu dropdown-menu-right">
            @if (Auth::check())
            <li><a href="{{ route('account') }}">{{ __('account') }}</a></li>
            <li><a href="{{ route('order') }}">{{ __('order') }}</a></li>
            <li><a href="{{ route('transaction') }}">{{ __('transaction') }}</a></li>
            <li><a href="{{ route('download') }}">{{ __('download') }}</a></li>
            <li><a href="{{ route('logout') }}">{{ __('logout') }}</a></li>
            @else
            <li><a href="{{ route('register') }}">{{ __('register') }}</a></li>
            <li><a href="{{ route('login') }}">{{ __('login') }}</a></li>
            @endif
          </ul>
        </li>
        <li><a href="{{ route('wishlist') }}" id="wishlist-total" title="{{ __('wishlist') }}"><i class="fa fa-heart"></i> <span class="hidden-xs hidden-sm hidden-md">{{ __('wishlist') }}</span></a></li>
        <li><a href="{{ route('shopping_cart') }}" title="{{ __('shopping cart') }}"><i class="fa fa-shopping-cart"></i> <span class="hidden-xs hidden-sm hidden-md">{{ __('shopping cart') }}</span></a></li>
        <li><a href="{{ route('checkout.index') }}" title="{{ __('checkout') }}"><i class="fa fa-share"></i> <span class="hidden-xs hidden-sm hidden-md">{{ __('checkout') }}</span></a></li>
      </ul>
    </div>
  </div>
</nav>