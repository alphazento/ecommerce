@push('styles')
    #sim__forgot-password-link{
        font-weight: bold;
        color: #A7A4A4;
        font-size: 13px;
        cursor: pointer;
        display: block;
        margin-top: 5px;
    }
@endpush

<div class="modal osc__modal" tabindex="-1" role="dialog" id="sign-in-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('login') }}" method="post" id="loginForm" role="form" class="loginform">
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
                                <h4 class="osc__h4">SIGN IN</h4>
                            </div>
                        </div>
                        <div class="col-10 mt-2">
                            <p id="error-box"></p>
                        </div>
                    </div>
                    <div class="row justify-content-md-center">
                        <div class="col-8">
                            <div class="form-group">
                                <label class="osc__form-label">Email</label>
                                <div class="btn-group" style="display: block;">
                                    <input name="email"
                                           class="form-control"
                                           id="ajax_email"
                                           placeholder="Email*"
                                           required
                                           value="" type="email">
                                    <span class="osc__input-clear-icon">&times;</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-md-center">
                        <div class="col-8">
                            <label class="osc__form-label">Password</label>
                            <input name="password"
                                   id="ajax_password"
                                   class="form-control"
                                   placeholder="Password*"
                                   required
                                   value="" type="password">
                            <label id="sim__forgot-password-link">Forgot password?</label>
                        </div>
                    </div>
                    <div class="row justify-content-md-center mb-4 mt-2">
                        <div class="col-8">
                            <button type="submit" class="btn osc__modal-btn login-btn" id="modal-sign-in-btn"
                                    data-normal-text="Sign In"
                                    data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Signing in...">Sign In</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@push('rqjs_body')
requirejs(['jQuery', 'ajaxlogin', 'jquery.validate'], function($, ajaxlogin) {

    var validateSignInForm = {
        messages: {
            sign_in_email: {
                required: '*Please enter the email address'
            },
            sign_in_password: {
                required: '*Please enter the password'
            }
        }
    };

    $("#loginForm").validate(validateSignInForm);

    $(document).on('click', '#sim__forgot-password-link', function() {
        $('#sign-in-modal').modal('toggle');
        $('#forgot-password-modal').modal('toggle');
    });

    $(document).on('keyup', '#ajax_email', function(e) {
        if (e.target.value.length === 0) {
            $('.osc__input-clear-icon').hide();
        } else {
            $('.osc__input-clear-icon').show();
        }
    });

    $(document).on('click', '.osc__input-clear-icon', function() {
        $('#ajax_email').val('');
        $(this).hide();
    });

    $(document).on('click', '#modal-sign-in-btn', function(e) {
        e.preventDefault();
        var $loginForm = $('#loginForm');
        if ($loginForm.valid()) {
            ajaxlogin.login($loginForm);
        }
    });

});
@endpush
