<div class="modal osc__modal" tabindex="-1" role="dialog" id="forgot-password-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="forgotPasswordForm" method="post" role="form">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" style="font-size: 35px;">&times;</span>
                            </button>
                        </div>
                    </div>
                    <div class="row justify-content-md-center mb-2">
                        <div class="col-10">
                            <div class="osc__head">
                                <h4 class="osc__h4">FORGOT PASSWORD</h4>
                            </div>
                        </div>
                        <div class="col-10 mt-2">
                            <p id="error-box"></p>
                        </div>
                    </div>
                    <div class="row justify-content-md-center">
                        <div class="col-8">
                            <p class="osc__modal_sentence">No Worries! Please enter your registered email below and we will send you an instruction guideline to reset the password.</p>
                        </div>
                    </div>
                    <div class="row justify-content-md-center">
                        <div class="col-8">
                            <div class="form-group">
                                <label class="osc__form-label">Email</label>
                                <div class="btn-group" style="display: block;">
                                    <input name="forgot_password_email"
                                           id="ajax_forgot_password_email"
                                           class="form-control"
                                           placeholder="Email Address" required
                                           value="" type="email">
                                    <span class="osc__input-clear-icon">&times;</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-md-center mb-4 mt-2">
                        <div class="col-8">
                            <button type="submit" class="btn osc__modal-btn" id="send-forgot-password-email">Continue</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@push('rqjs_configs')
    require_add_config("ajaxForgotPassword", @asset("/tonercitytheme/assets/js/ajax-forgot-password"), {
        deps: [],
        exports: 'ajaxForgotPassword'
    });
@endpush

@push('rqjs_body')
    requirejs(['jQuery', 'jquery.validate', 'ajaxForgotPassword'], function($) {
        var $forgotPasswordForm = $('#forgotPasswordForm');
        var forgotPasswordFormValidate = {
            messages: {
                forgot_password_email: {
                    required: '*Please enter the email address'
                }
            }
        };
        $forgotPasswordForm.validate(forgotPasswordFormValidate);

        var $forgotPasswordEmailInput = $('input[name="forgot_password_email"]');

        $forgotPasswordEmailInput.on('keyup', function(e){
            if(e.target.value.length === 0){
                $('.osc__input-clear-icon').hide();
            }else{
                $('.osc__input-clear-icon').show();
            }
        });

        $('.osc__input-clear-icon').on('click', function(){
            $forgotPasswordEmailInput.val('');
            $(this).hide();
        });

        $('#send-forgot-password-email').on('click', function(e){
            e.preventDefault();
            if($('#forgotPasswordForm').valid()){
                $forgotPasswordForm.submit();
            }
        });
    });
@endpush
