<div class="dropdown-menu">
    <div class="register-dropdown">
        @include('socialite.login-connect')
        <h3>Register Customers</h3>
        <p>If you have an account, sign in with your email address.</p>
        <form action="{{ route('login') }}" id="loginForm" role="form" class="loginform">
            <div id="error-box"></div>
            @csrf
            <div class="form-group">
                @php
                    $email = (old('email') ?? (Auth::check() ? Customer::now()->getEmail() : ''))
                @endphp
                <input id="ajax_email" type="email" name="email" class="form-control"
                        value="{{ $email }}"
                        placeholder="Email*"
                        autocomplete="tonercity"
                        required/>
            </div>
            <div class="form-group">
                <input name="password" id="ajax_password" class="form-control"
                        type="password"
                        autocomplete="tonercity" required placeholder="Password*"/>
            </div>

            <button type="button"
                    class="btn btn-primary mr-4 login-btn"
                    data-normal-text="Sign In"
                    data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Signing in...">
                Sign In
            </button>
            <a href="{{route('password.request')}}">Forgot your password?</a>
        </form>

        <h3 class="mt-4">New Here?</h3>
        <p>Registration is free and easy!</p>
        <p>Faster checkout</p>
        <p>Save multiple delivery addresses</p>
        <p>View and track orders and more</p>

        <div class="btn-wrapper">
            <a class="btn button" href="{{route('register')}}">CREATE AN ACCOUNT</a>
        </div>
    </div>
</div>
@push('rqjs_body')
requirejs(['jQuery', 'ajaxlogin', 'jquery.validate'], function($, ajaxlogin) {
    $("#loginForm").validate();
    $('.login-btn').on('click', function(){
        var $loginForm = $('#loginForm');
        if($loginForm.valid()){
            ajaxlogin.login($loginForm);
        }
    });
});
@endpush
