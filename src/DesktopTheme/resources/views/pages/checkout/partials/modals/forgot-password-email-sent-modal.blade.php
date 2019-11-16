<div class="modal osc__modal" tabindex="-1" role="dialog" id="forgot-password-email-sent-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="font-size: 35px;">&times;</span>
                        </button>
                    </div>
                </div>
                <div class="row justify-content-md-center">
                    <div class="col-10">
                        <div class="osc__head">
                            <h4 class="osc__h4">FORGOT PASSWORD</h4>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-md-center  mt-4">
                    <div class="col-8">
                        <p class="osc__modal_sentence">We've sent you a verification link, please check your mail box and follow the instruction to reset your password, or you can continue to checkout without login.</p>
                    </div>
                </div>
                <div class="row justify-content-md-center">
                    <div class="col-8 text-center">
                        <i class="fa fa-envelope" style="font-size: 70px;"></i>
                    </div>
                </div>
                <div class="row justify-content-md-center mb-4 mt-2">
                    <div class="col-8">
                        <button type="button" class="btn osc__modal-btn" id="checkout-without-login">Checkout without login</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('rqjs_body')
    requirejs(['jQuery'], function($) {
        $('#checkout-without-login').on('click', function(){
            $('#forgot-password-email-sent-modal').modal('toggle');
        });
    });
@endpush
