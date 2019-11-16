define(['jQuery'], function ($) {
    var forgotPassword = {
        forgotPasswordUrl: '/ajax/find-password'
    };

    $('#forgotPasswordForm').submit(function (e) {
        e.preventDefault();
        var message = $(this).find("#error-box");
        message.empty();
        message.removeClass('alert alert-danger');
        var button = $(this).find("button[type=submit]");
        button.button('loading');

        $.ajax({
            type: "POST",
            url: forgotPassword.forgotPasswordUrl,
            data: {
                email: $("#ajax_forgot_password_email").val(),
            },
            dataType: 'json',
            success: function (data) {
                if(!data.success){
                    message.addClass('alert alert-danger');
                    message.html("<i class='fas fa-exclamation-circle'></i> We can't find a user with that e-mail address.");
                }else{
                    $('#forgot-password-modal').modal('toggle');
                    $('#forgot-password-email-sent-modal').modal('toggle');
                }
            },
            error: function (data) {
                console.log(data);
                message.addClass('alert alert-danger');

                message.html('Something went wrong, please try again later');
                button.button('reset');
            }
        });
    });
    return forgotPassword;
});