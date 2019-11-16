@extends('layouts.3columns')



@push('head')
    <link rel="stylesheet" href=@asset("/tonercitytheme/assets/css/account.css")>
@endpush
<!-- required -->
@section('custom')

    <div class="pagecontent">
        <div class="container">

            <div class="pagecontent__row">
                <aside class="pagecontent__side mb-4">
                    <div class="mobaccordion mobaccordion--acount">
                        <div class="mobaccordion__head">
                            My Account
                        </div>
                        <div class="mobaccordion__body">
                            <ul class="mobaccordion__items">
                                <li class="mobaccordion__item {{ Request::is(ltrim(route('customer.account.overview',[],false), '/')) ? 'active' : '' }}">
                                    <a href="{{route('customer.account.overview')}}">Account Dashboard</a>
                                </li>
                                <li class="mobaccordion__item {{ Request::is(ltrim(route('customer.account.information',[],false), '/')) ? 'active' : '' }}">
                                    <a href="{{ route('customer.account.information') }}">Account Information</a>
                                </li>
                                <li class="mobaccordion__item {{ Request::is(ltrim(route('customer.account.addresses',[],false), '/')) ? 'active' : '' }}">
                                    <a href="{{route('customer.account.addresses')}}">Address Book</a>
                                </li>
                                <li class="mobaccordion__item {{ (Request::is(ltrim(route('customer.account.orders',[],false), '/')) || ( strpos(Request::getRequestUri() , '/sales/order') !== false) ) ? 'active' : '' }}">
                                    <a href="{{route('customer.account.orders')}}">My Orders</a>
                                </li>
                                <li class="mobaccordion__item {{ Request::is(ltrim(route('customer.account.newsletter',[],false), '/')) ? 'active' : '' }}">
                                    <a href="{{route('customer.account.newsletter')}}">Newsletter Subscriptions</a>
                                </li>
                                <li class="mobaccordion__item {{ Request::is(ltrim(route('customer.reorder',[],false), '/')) ? 'active' : '' }}">
                                    <a href="{{route('customer.reorder')}}">Re-Order</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </aside>


                @yield('customer')

            </div>
        </div>
    </div>
@endsection

@push('rqjs_body')
    requirejs(['jQuery'], function($) {
    var cef_t = "Change Email";
    var cpf_t = "Change Password";
    var cepf_t = "Change Email and Password";

    var cef = $('#change-email-fields').html();
    var cpf = $('#change-password-fields').html();

    $('input#change-email[type="checkbox"]').click(function(){
    if($(this).prop("checked") == true){
    $('#emailpassfields').show();
    $('#dynamic-fields').append(cef);
    if($('input#change-pass[type="checkbox"]').prop("checked") == true){
    $('#dynamic-title').html(cepf_t);
    }else{
    $('#dynamic-title').html(cef_t);
    }
    }
    else if($(this).prop("checked") == false){
    $('#dynamic-fields .change-email-fields').remove();
    if($('input#change-pass[type="checkbox"]').prop("checked") == true){
    $('#dynamic-title').html(cpf_t);
    }else{
    $('#dynamic-title').html('');
    $('#emailpassfields').hide();
    }
    }
    });

    $('input#change-pass[type="checkbox"]').click(function(){
    if($(this).prop("checked") == true){
    $('#emailpassfields').show();
    $('#dynamic-fields').append(cpf);
    if($('input#change-email[type="checkbox"]').prop("checked") == true){
    $('#dynamic-title').html(cepf_t);
    }else{
    $('#dynamic-title').html(cpf_t);
    }
    }
    else if($(this).prop("checked") == false){
    $('#dynamic-fields .change-password-fields').remove();
    if($('input#change-email[type="checkbox"]').prop("checked") == true){
    $('#dynamic-title').html(cef_t);
    }else{
    $('#dynamic-title').html('');
    $('#emailpassfields').hide();
    }
    }
    });
    });
@endpush
