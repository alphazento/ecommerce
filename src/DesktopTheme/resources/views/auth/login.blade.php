@extends('layouts.3columns')

@exclude('components.header-nav.login')

{{--optional--}}
@section('php')
    @php
        $email = (old('email') ?? (Auth::check() ? Customer::now()->getEmail() : ''));
        BladeTheme::breadcrumb(url('login'), 'Login or Create an Account');
    @endphp
@endsection

{{--optional--}}
@section('schema')
    {{--@include('schemas.product_schema',[])--}}
@endsection

@section('title')
    <title>Alphazento | Login</title>
@endsection

@section('custom')
    <section>
        <div class="container">
            @include('socialite.login-connect')
            <div class="row">
                <div class="col-sm-6 mb-4">
                    <div class="block-dashboard__title">
                        <h5>New Here?</h5>
                        <hr/>
                    </div>
                    <div class="content">
                        <div class="mb-2">
                            <i style="color:#a0a0a0;">Registration is free and easy!</i>
                        </div>

                        <ul class="ml-4">
                            <li>Faster checkout</li>
                            <li>Save multiple delivery addresses</li>
                            <li>View and track orders and more</li>
                        </ul>

                        <div>
                            <a class="button btn-shadow" href="{{ route('register') }}">CREATE AN ACCOUNT</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="register-container mb-4">
                        <div class="block-dashboard__title">
                            <h5>Registered Customers</h5>
                            <hr/>
                            <div class="mb-4">
                                If you have an account, sign in with your email address.
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-8">

                                <form name="login" class="fullwidth" action="{{ route('login') }}" method="post">
                                    @csrf_field()
                                    <div class="form-group">
                                        <label><strong>Email</strong> <span class="required">*</span></label>
                                        <input id="email" type="email" name="email" class="form-control" value="{{ $email }}"
                                               autocomplete="tonercity"
                                               required placeholder="Email*"/>
                                    </div>
                                    <div class="form-group">
                                        <label><strong>Password </strong><span class="required">*</span></label>
                                        <input name="password" id="password" class="form-control" type="password"
                                               autocomplete="tonercity" required placeholder="Password*"/>
                                    </div>
                                    <div class="lost-password form-group">
                                        <a href="{{url('/find-password')}}">Lost Your Password?</a>
                                    </div>
                                    <div class="form-group">
                                        <input class="btn button btn-shadow w-100" type="submit" value="Sign In">
                                        <!-- <label class="checklabel"><input value="rememberme" type="checkbox">Remember me</label>-->
                                    </div>
                                    <div class="form-group">
                                        <span class="required">* Required Fields</span>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
