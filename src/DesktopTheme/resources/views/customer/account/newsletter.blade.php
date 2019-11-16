@extends('customer.base')


{{--optional--}}
@section('title')
    <title>
        Alphazento | Newsletter Subscription
    </title>
@endsection

@section('customer')
    <div class="pagecontent__main">
        <div class="block-dashboard mb-4">
            <div class="block-dashboard__title">
                <h1>Subscription option</h1>
            </div>
            <div class="clearfix">
                <form name="account_newsletter" action="{{ route('customer.account.toggleSubscription') }}" method="post" style="width:100%;">
                    @csrf
                    <div class="form-group">
                        <label><input name="subscribed" value="1" type="checkbox" id="subscribed" {{ $subscribed ? 'checked' : '' }}/> General Subscription
                        </label>
                    </div>
                    <button type="submit" title="Save" class="button btn-shadow minw-100"><span>Save</span></button>
                </form>
            </div>
        </div>
    </div>
@endsection
