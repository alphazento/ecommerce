

<form name="change-password" style="width:100%;" action="{{ route('customer.changePassword') }}"
      method="POST"
      id="change-password-form">
    @csrf
    <input type="hidden" value="{{ Customer::now()->getEmail() }}" name="email_address">
    <div class="form-group">
        <label>Current Password <span class="required">*</span></label>
        <input type="password" name="password_current" value="" autocomplete="tonercity" required
               id="password_current" class="form-control">
    </div>
    <div class="form-group">
        <label>New Password<span class="required">*</span></label>
        <input type="password" name="password" id="password" value="" autocomplete="tonercity"
               required
               minlength=8 class="form-control">
    </div>
    <div class="form-group">
        <label>Confirm Password <span class="required">*</span></label>
        <input type="password" name="password_confirmation" value="" autocomplete="tonercity" required
               equalTo="#password" id="password_confirmation" class="form-control">
    </div>
    <div class="form-group">
        <button class="button btn-shadow btn-submit" type="submit" value="Save Changes">SAVE</button>
    </div>
</form>


@push('footer')
    <script>
        var changePasswordValidation = {
            rules: {
                password: {
                    minlength: 8,
                    required: true
                },
                password_confirmation: {
                    equalTo: "#password"
                },
                password_current:{
                    required: true
                }
            }
        };

        requirejs(['jQuery','emoji-check','jquery.validate'], function ($) {
            $('#change-password-form').validate(changePasswordValidation);
        });
    </script>
@endpush


