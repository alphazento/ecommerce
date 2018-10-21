@extends(config('home.layout', 'layout.default'))

@section('content')

    @foreach($content_top ?? [] as $module)
        @include($module[0], $module[1])
    @endforeach
      <h1>{{ 'checkout' }}</h1>
      <div class="panel-group" id="accordion">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h4 class="panel-title">{{ 'text_checkout_option' }}</h4>
          </div>
          <div class="panel-collapse collapse" id="collapse-checkout-option">
            <div class="panel-body"></div>
          </div>
        </div>
        @if(!Auth::guest())
        <div class="panel panel-default">
          <div class="panel-heading">
            <h4 class="panel-title">{{ 'text_checkout_account' }}</h4>
          </div>
          <div class="panel-collapse collapse" id="collapse-payment-address">
            <div class="panel-body"></div>
          </div>
        </div>
        @else
        <div class="panel panel-default">
          <div class="panel-heading">
            <h4 class="panel-title">{{ 'text_checkout_payment_address' }}</h4>
          </div>
          <div class="panel-collapse collapse" id="collapse-payment-address">
            <div class="panel-body"></div>
          </div>
        </div>
        @endif
        @if(config('shipping_required'))
        <div class="panel panel-default">
          <div class="panel-heading">
            <h4 class="panel-title">{{ 'text_checkout_shipping_address' }}</h4>
          </div>
          <div class="panel-collapse collapse" id="collapse-shipping-address">
            <div class="panel-body"></div>
          </div>
        </div>
        <div class="panel panel-default">
          <div class="panel-heading">
            <h4 class="panel-title">{{ 'text_checkout_shipping_method' }}</h4>
          </div>
          <div class="panel-collapse collapse" id="collapse-shipping-method">
            <div class="panel-body"></div>
          </div>
        </div>
        @endif
        <div class="panel panel-default">
          <div class="panel-heading">
            <h4 class="panel-title">{{ 'text_checkout_payment_method' }}</h4>
          </div>
          <div class="panel-collapse collapse" id="collapse-payment-method">
            <div class="panel-body"></div>
          </div>
        </div>
        <div class="panel panel-default">
          <div class="panel-heading">
            <h4 class="panel-title">{{ 'text_checkout_confirm' }}</h4>
          </div>
          <div class="panel-collapse collapse" id="collapse-checkout-confirm">
            <div class="panel-body"></div>
          </div>
        </div>
      </div>

@endsection