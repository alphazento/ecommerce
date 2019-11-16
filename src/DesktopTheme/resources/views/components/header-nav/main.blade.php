<header class="siteheader">
    <div class="header-info">
        <div class="container clearfix">
            <div class="float-left">
                <strong class="free-shipping"><a href="{{route('shipping')}}">FREE AUS Shipping for Orders $50 or over</a></strong>
            </div>
            <div class="float-right d-md-block">
                <ul class="panel">
                    <li class="help-link"><a href="{{url('contact-us')}}">Need Help?</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="header-holder">
        <div class="container clearfix">
            <a id="mobile-menu-btn" class="mobile-menu-btn" href="JavaScript:;"></a>
            <a class="logo" href="{{route('home')}}">
                <img class="logo-big" src=@asset("/tonercitytheme/assets/img/logo.png") alt="Alphazento">
                <img class="logo-small" src=@asset("/tonercitytheme/assets/img/logo-small.png")
                     alt="Alphazento">
                <img class="logo-scroll" src=@asset("/tonercitytheme/assets/img/logo-scroll.png")
                     alt="Alphazento">
            </a>

            <ul class="shortcut-tabs">
                @if(!Auth::isFullLogin())
                    <li class="account-link item-top dropdown">
                        <a href="{{route('login')}}" class="same-height-left dropdown-toggle"
                           style="height: 13px;" >
                            <span>Login/Register</span>
                        </a>
                        @include('components.header-nav.login')
                    </li>
                @else
                    @includecache('', 'components.header-nav.myaccount')
                @endif
                <li class="cartridges-link item-top acount-item">
                    <a href="{{route('login')}}" title="My Cartridges" style="height: 13px;"><span>My Cartridges</span></a>
                </li>
                <li class="cart-link item-top cart-item dropdown" id="mini-cart-view">
                    {!! Quote::renderQuoteView('components.header-nav.mycart') !!}
                </li>
            </ul>

            @include('components.header-nav.search')
        </div>
    </div>

    <div class="header-nav">
        <nav>
            <div class="container">
                <ul class="main-nav">
                    <li class="nav-brand level0 cartridge-finder parent">
                        @include('components.header-nav.cartridge-finder')
                    </li>
                    <li class="nav-brand level0 parent">
                        @includecache('ink', 'components.header-nav.brand-list', ['type' => 'Ink'])
                    </li>
                    <li class="nav-brand level0 parent">
                        @includecache('toner', 'components.header-nav.brand-list', ['type' => 'Toner'])
                    </li>
                    @if(Store::getConfig(\Inkstation\Sales\Model\Constants::CONFIG_REORDER_MUST_FULL_LOGIN, false) ? Auth::isFullLogin() : Auth::check())
                        <li class="nav-default level0 parent">
                            <div class="level-top-box">
                                <a href="{{route('customer.reorder')}}" class="level0 has-children">
                                    <span>Quick Reorder</span>
                                </a>
                            </div>
                        </li>
                    @else
                        <li class="nav-default level0" style="width: 25%;"></li>
                    @endif
                </ul>
            </div>
        </nav>
    </div>
</header>
