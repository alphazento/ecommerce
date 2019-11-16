<li class="account-link item-top dropdown">
    <a href="{{route('customer.account.overview')}}" class="same-height-left dropdown-toggle"
        style="height: 13px;">
        <span>My Account</span>
    </a>
    <div class="dropdown-menu">
        <div class="register-dropdown">
            <div><a href="{{route('customer.account.overview')}}"><i class="fa fa-user"></i> My
                    Account</a></div>
            <hr>
            <div><a href="{{route('customer.account.orders')}}"><i class="fa fa-history"></i> Order
                    History</a></div>
            <hr>
            <div>
                <a href="javascript:void(0);"
                    onclick="document.querySelector('#logoutform').submit();"
                    title="Logout">
                    <i class="fa fa-sign-out"></i> Logout
                </a>
                <form name="myform" id="logoutform" action="{{ route('ink.logout') }}"
                        method="post">
                        @csrf_field()
                </form>
            </div>
        </div>
    </div>
</li>
