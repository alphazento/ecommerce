<div class="email-field one-field">
    @include('socialite.login-connect')
    <form id="checkout__guest-email-form">
        <div class="form-group">
            <label class="osc__form-label">Email <span>*</span></label>
            <input name="username"
                    id="checkout__customer-email__box"
                    class="form-control"
                    placeholder="Email Address" required
                    value="{{ Customer::now()->getEmail() }}" type="text">
        </div>
    </form>
</div>

@push('rqjs_body')
requirejs(['jQuery', 'windowLib', 'jquery.validate', 'loadingNotification'], function($, windowLib, validator, notifier) {
    $.validator.addMethod("customemail",
        function(value, element) {
            return /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(value);
        },
        "*Please enter a valid email address"
    );

    var customerEmailValidation = {
        rules: {
            username: {
                required: {
                    depends:function(){
                        $(this).val($.trim($(this).val()));
                            return true;
                        }
                    },
                customemail: true,
                email: true
            }
        },
        messages: {
            username: {
                required: '*Please enter email address'
            }
        }
    };

    $("#checkout__guest-email-form").validate(customerEmailValidation);

    windowLib.onMessage('collect-guest-detail', function(data){
        if(!$('#checkout__guest-email-form').validate(customerEmailValidation).form()){
            return 'Invalid email address';
        }
        windowLib.sendMessage('guest-email', $("#checkout__customer-email__box").val());
    });

    var email = $("#checkout__customer-email__box").val();
    var $nextInput = $('#delivery_address_form-entry_firstname');
    $('#checkout__customer-email__box').blur(function() {
        var $me = $(this);
        if ($("#checkout__guest-email-form").valid()) {
            if (this.value !== email) {
                var currentEmail = this.value;
                $.ajaxPOST('/ajax/quote/guest-email', {email: this.value}, function(data) {
                    if (data['success']) {
                        email = currentEmail;
                        if (data['redirect']) {
                            window.location.href = data['redirect'];
                        }
                    }
                    $nextInput.focus();
                }, function(xhr) {
                    if (xhr.status === 429) {
                        $("#checkout__customer-email__box").val(email);
                        var retryAfter = (xhr.getResponseHeader('Retry-After'));
                        notifier.error('Too Many Attempts to change your email address. Please retry after ' + retryAfter +'s');
                    }
                })
            }
        }
    })
});
@endpush
