define(['jQuery'], function ($) {

    return {
        login: function ($loginForm) {
            var $message = $loginForm.find('#error-box');
            var $button = $loginForm.find(".login-btn");

            var url = $loginForm.attr('action');
            var normalText = $button.data('normal-text') || 'Sign In';
            var loadingText = $button.data('loading-text') || 'Signing in...';

            var email = $loginForm.find('#ajax_email').val();
            var password = $loginForm.find('#ajax_password').val();

            $button.attr('disabled', true).html(loadingText);
            $message.empty();
            $message.removeClass('alert alert-danger');

            $.ajax({
                type: "POST",
                url: url,
                data: {
                    email: email,
                    password: password
                },
                dataType: 'json',
                success: function (data) {
                    window.location.href = data.intended;
                },
                error: function (data) {
                    console.log(data);
                    $message.addClass('alert alert-danger');
                    $message.html('<i class="fa fa-exclamation-circle"></i> Sorry! The Email and/or password you entered does not match an existing account.');
                    $button.attr('disabled', false).html(normalText);
                }
            });
        }
    }
});
