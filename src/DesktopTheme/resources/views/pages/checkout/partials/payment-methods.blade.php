@push('rqjs_configs')
    require_add_config('windowLib', @asset("/tonercitytheme/assets/js/windowlib"), {
        deps: [],
        exports: 'windowLib'
    });
@endpush

@push('rqjs_body')
requirejs(['jQuery', 'windowLib'], function($, windowLib) {
    $('.tc__payment-method-selector').on('click', function () {
        $(".osc__payment-valid-fail").hide();
        windowLib.sendMessage("payment_method-changed", {method: this.value, status:"change", to:"*" });
    });
    windowLib.onMessage('pre-place-order', function(method) {
        if (method === undefined || method === null || method === '') {
            $(".osc__payment-valid-fail").show();
            return 'Payment details are not valid.';
        }
    });
});
@endpush
@push('styles')
    .tc__payment-method{
        border-radius: 10px;
        font-size: 15px;
    }
    .form-check-label{
        line-height: 25px;
    }
    .osc__payment-valid-fail{
        padding-bottom: 10px;
    }
    .form-check-input{
        width: 20px;
        height: 20px;
        margin-top: 4px;
        margin-left: 0;
    }
    .form-check-label{
        margin-left: 25px;
    }
    .radio-group{
        width: 100%;
        margin-bottom: 0;
    }
@endpush

    <p class="osc__payment-valid-fail" style="display:none;"><strong>* Please set payment method!</strong></p>
    @foreach($paymentMethods as $paymentMethod)
    <div class="tc__payment-methods-container">
        <div class="form-group form-check tc__payment-method bg-light p-2 shadow-sm">
            <label class="radio-group">
                <input value="{{ $paymentMethod->getCode() }}"
                        {{ $quoteSnapshot->payment_method === $paymentMethod->getCode() ? 'checked' : ''}}
                        id="payment_method-{{ $paymentMethod->getCode() }}"
                        name="payment_method"
                        class="form-check-input tc__payment-method-selector"
                        type="radio">
                <span class="form-check-label" for="payment-method{{ $loop->index }}">
                    {{ $paymentMethod->getTitle() }}
                </span>
                <div style="float: right;">
                    @foreach($paymentMethod->getLogos() as $logo)
                        <img src=@resource($logo) alt="{{ $paymentMethod->getTitle() }}"/>
                    @endforeach
                </div>
            </label>
        </div>
        <div class="tc__payment-method-view">
            {!! $paymentMethod->renderView() !!}
        </div>
    </div>
    @endforeach
