@extends('layouts.3columns')

@section('schema')
    {{--@include('schemas.product_schema',[])--}}
@endsection

@section('breadcrumb')
    @include('components.breadcrumb', [
    'tree'=>
        [
            [
                'url' => route('home'),
                'name' => 'Home'
            ],
            [
                'url' => url('find-password'),
                'name' => 'Forget Password'
            ],
        ]
    ])
@endsection

@section('custom')
    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                </div>
                <div class="col-sm-6">
                    <div class="forgot-password mb-4">
                        <p> Already have an account? <a href="{{route('login')}}">Sign in</a></p>
                        <p>Lost your password? Please enter your email address. </p>
                        <p>You will receive instructions to reset your password via email.</p>
                        <p>Please enter your email address below to receive a password reset link.</p>

                        <form  method="post" name="password_forgotten" action="{{ route('password.email') }}">
                            @csrf
                            <div class="form-group">
                                <label for="email">Email <span class="required">*</span></label>
                                <input id="email" type="email" class="form-control" name="email" autocomplete="tonercity" required>
                            </div>
                            <div class="form-group">
                                <button class="btn button btn-shadow" type="submit">RESET MY PASSWORD</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-sm-3"></div>
            </div>
        </div>
    </section>
@endsection
