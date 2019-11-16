@php
    if (!$errors->any()) {
        session()->flash('message', [
            'type' => 'error',
            'body' => 'Your reset password link or token might be invalid, please resend a new one.'
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
                <div class="col-12">
                    <div class="text-center">
                        <a class="btn button btn-shadow" href="{{ route('home') }}">Home</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
