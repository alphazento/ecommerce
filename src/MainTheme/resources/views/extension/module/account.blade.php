<div class="list-group">
  @if(Auth::guest())
  <a href="{{ 'login' }}" class="list-group-item">{{ __('login') }}</a> <a href="{{ register }}" class="list-group-item">{{ __('register') }}</a> 
  <a href="{{ 'forgotten' }}" class="list-group-item">{{ __('forgote password') }}</a>
  @endif
  <a href="{{ 'account' }}" class="list-group-item">{{ __('account') }}</a>
  @if(Auth::check())
  <a href="{{ 'edit' }}" class="list-group-item">{{ __('edit') }}</a> <a href="{{ 'password' }}" class="list-group-item">{{ __('password') }}</a>
  @endif
  <a href="{{ 'address' }}" class="list-group-item">{{ __('address') }}</a> <a href="{{ wishlist }}" class="list-group-item">{{ __('wishlist') }}</a> <a href="{{ order }}" class="list-group-item">{{ __('Order') }}</a> 
  <a href="{{ 'download' }}" class="list-group-item">{{ __('download') }}</a><a href="{{ recurring }}" class="list-group-item">{{ __('recurring') }}</a> <a href="{{ 'reward' }}" class="list-group-item">{{ __('reward') }}</a> <a href="{{ 'return' }}" class="list-group-item">{{ __('return') }}</a> <a href="{{ 'transaction' }}" class="list-group-item">{{ __('transaction') }}</a> <a href="{{ 'newsletter' }}" class="list-group-item">{{ __('newsletter') }}</a>
  @if(Auth::check())
  <a href="{{ 'logout' }}" class="list-group-item">{{ __('logout') }}</a>
  @endif
</div>
