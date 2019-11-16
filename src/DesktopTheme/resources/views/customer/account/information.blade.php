@extends('customer.base')

{{--optional--}}
@section('title')
    <title>
        Alphazento | Edit Account Information
    </title>
@endsection


@section('customer')
    <div class="pagecontent__main">
        <div class="block-dashboard mb-4">
            <div class="row">
                <div class="col-sm-6">
                    <div class="block-dashboard__title">
                        <h1>Edit Account Information</h1>
                    </div>
                    @include('forms.account-information-form')
                </div>
                <div class="col-sm-6">
                    <div class="block-dashboard__title">
                        <h1>Change Password</h1>
                    </div>
                    @include('forms.account-password-form')
                </div>
            </div>
        </div>
    </div>

@endsection
