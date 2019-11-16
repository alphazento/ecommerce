
<form name="edit-account" style="width:100%;" action="{{ route('customer.updateAccount') }}"
      method="POST"
      id="edit-account-form">
    @csrf
    <div class="form-group">
        <label>First Name <span class="required">*</span></label>
        <input type="text" class="form-control" name="firstname"
               value="{{ Customer::now()->getFirstName() }}" id="firstname"
               required>
    </div>
    <div class="form-group">
        <label>Last Name <span class="required">*</span></label>
        <input type="text" name="lastname" class="form-control"
               value="{{ Customer::now()->getLastName() }}" id="lastname"
               required>
    </div>
    <div class="form-group">
        <label>Email Address<span class="required">*</span></label>
        <input type="email" name="email" class="form-control"
               value="{{ Customer::now()->getEmail() }}"
               id="email" required>
    </div>
    <div class="form-group">
        <label>Phone Number <span class="required">*</span></label>
        <input type="text" name="telephone" class="form-control"
               value="{{ Customer::now()->getTelephone() }}" id="telephone"
               required>
    </div>
    <div class="form-group">
        <button class="button btn-shadow btn-submit" type="submit" value="Save Changes">SAVE</button>
    </div>
</form>


@push('rqjs_body')
    requirejs(['jQuery', 'jquery.validate'], function ($) {

        $.validator.addMethod("lettersonly", function(value, element) {
            return this.optional(element) || /^[a-z]+$/i.test(value);
        }, "Only alphabetic characters are allowed.");

        $('#edit-account-form').validate({
            rules: {
                firstname: {
                    maxlength: 30,
                    required: true,
                    lettersonly: true
                },
                lastname: {
                    maxlength: 30,
                    required: true,
                    lettersonly: true
                },
                telephone: {
                    number: true,
                    maxlength: 32,
                    required: true
                },
                email: {
                    maxlength: 255,
                    email: true,
                    required: true
                }
            },
            messages: {
                telephone: {
                    digits: 'Only numbers are allowed.',
                    required: 'Please enter your contact number.'
                }
            }
        });
    });
@endpush


