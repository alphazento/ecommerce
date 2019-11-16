@extends('layouts.3columns')

@exclude('components.header-nav.login')

@section('title')
    <title>Alphazento | Verify Your Email</title>
@endsection

@section('custom')
    <section>
        <div class="container">
            <div class="card">
                <div class="card-header">Verify Your Email Address</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            A fresh verification link has been sent to your email address.
                        </div>
                    @endif

                    <a href="{{ route('verification.resend') }}">click here to request/resend verification email</a>.
                </div>
            </div>
        </div>
    </section>
@endsection
