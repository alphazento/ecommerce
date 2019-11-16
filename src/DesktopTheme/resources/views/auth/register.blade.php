@extends('layouts.3columns')

@push('styles')
    @media screen and (max-width: 767px){
        .position-create-account-btn{
            text-align: center;
        }
    }
@endpush

<?php BladeTheme::breadcrumb(route('register'), 'Registration') ?>

{{--optional--}}
@section('title')
    <title>
        Alphazento | Sign up
    </title>
@endsection

{{--required--}}
@section('custom')

    <section class="myaccountsec">
        <div class="row">
            <div class="col-sm-12">
                <div class="container">
                    Already have an account? <a href="{{route('login')}}">Sign in</a>
                </div>
            </div>
        </div>
    </section>
    @include('forms.register-form',['states'=>Customer::loadStates()])
@endsection
