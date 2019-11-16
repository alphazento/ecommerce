@php
    if (!$errors->any()) {
        session()->flash('message', [
            'type' => 'success',
            'body' => 'You have successfully logged in. You can continue to checkout. Or, reset your password below.'
        ]);
    }
@endphp

@extends('layouts.3columns')

@section('breadcrumb')
    @include('components.breadcrumb', [
    'tree'=>
        [
            [
                'url' => route('home'),
                'name' => 'Home'
            ],
            [
                'url' => '',
                'name' => 'Reset Password'
            ],
        ]
    ])
@endsection

@section('custom')
    <section>
        <div class="container mb-4">
            <div class="row">
                <div class="col-3"></div>
                <div class="col-6">
                    <form method="POST" action="{{ route('password.update') }}" id="password-forgot-form">
                        {{ csrf_field() }}
                        <input type="hidden" name="token" value="{{ $token }}">
                        <input type="hidden" name="email" value="{{ $email  }}" required>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" aria-describedby="emailHelp"
                                   placeholder="Enter email" value="{{ $email }}" disabled>
                        </div>

                        <div class="form-group">
                            <label for="password">New Password</label>
                            <input name="password" type="password" class="form-control" id="password" required>
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password</label>
                            <input name="password_confirmation" type="password" class="form-control"
                                   id="password_confirmation" required>
                        </div>

                        <button type="submit" class="btn btn--green">Reset Password</button>
                    </form>
                </div>
                <div class="col-3"></div>
            </div>
        </div>
    </section>
@endsection

@section('rqjs_body')
    requirejs(['jQuery', 'jquery.validate'], function($) {
        $('#password-forgot-form').validate({
            rules: {
                password: {
                    minlength: 8,
                    required: true
                },
                password_confirmation: {
                    equalTo: '#password',
                    required: true
                }
            }
        });
    });
@endsection
