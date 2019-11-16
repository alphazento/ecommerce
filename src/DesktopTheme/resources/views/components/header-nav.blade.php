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
                <img class="logo-big" src=@resource("/inkstation/tonercitytheme/assets/img/logo.png") alt="Alphazento">
                <img class="logo-small" src=@resource("/inkstation/tonercitytheme/assets/img/logo-small.png")
                     alt="Alphazento">
                <img class="logo-scroll" src=@resource("/inkstation/tonercitytheme/assets/img/logo-scroll.png")
                     alt="Alphazento">
            </a>

            <ul class="shortcut-tabs">

                @if(!Auth::check())
                    <li class="account-link item-top dropdown">
                        <a href="{{route('login')}}" class="same-height-left dropdown-toggle"
                           style="height: 13px;" >
                            <span>Login/Register</span>
                        </a>
                        @if(Request::getUri() != route('login'))
                            <div class="dropdown-menu">
                                <div class="register-dropdown">
                                    @include('socialite.login-connect-tonercity')
                                    <h3>Register Customers</h3>
                                    <p>If you have an account, sign in with your email address.</p>

                                    <div id="error-box">

                                    </div>
                                    <form id="loginForm" role="form" class="loginform">
                                        @csrf
                                        <div class="form-group">
                                            @php
                                                $email = (old('email') ?? (Auth::check() ? Customer::now()->getEmail() : ''))
                                            @endphp
                                            <input id="ajax_email" type="email" name="email" class="form-control"
                                                   value="{{ $email }}"
                                                   placeholder="Email*"
                                                   autocomplete="tonercity"
                                                   required/>
                                        </div>
                                        <div class="form-group">
                                            <input name="password" id="ajax_password" class="form-control"
                                                   type="password"
                                                   autocomplete="tonercity" required placeholder="Password*"/>
                                        </div>

                                        <button type="submit" class="btn btn-primary mr-4"
                                                data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Signing in">
                                            Sign In
                                        </button>
                                        <a href="{{route('password.request')}}">Forgot your password?</a>
                                    </form>


                                    <h3 class="mt-4">New Here?</h3>
                                    <p>Registration is free and easy!</p>
                                    <p>Faster checkout</p>
                                    <p>Save multiple delivery addresses</p>
                                    <p>View and track orders and more</p>

                                    <div class="btn-wrapper">
                                        <a class="btn button" href="{{route('register')}}">CREATE AN ACCOUNT</a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </li>

                @else
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
                                        {{ csrf_field() }}
                                    </form>
                                </div>
                            </div>
                        </div>
                    </li>
                @endif
                <li class="cartridges-link item-top acount-item">
                    @if(!Auth::check())
                        <a href="{{route('login')}}" title="My Cartridges" style="height: 13px;"><span>My Cartridges</span></a>
                    @else
                        <a href="" title="My Cartridges" style="height: 13px;"><span>My Cartridges</span></a>
                    @endif
                </li>
                <li class="cart-link item-top cart-item dropdown">
                    <a href="{{route('cart')}}" class="no-count same-height-right dropdown-toggle"
                       style="height: 13px;">
                        <span>Cart
                            <span class="price">${{ Sales::formatPrice(Cart::getQuote()->getSubTotal()) }}</span>
                        </span>
                        @if(Request::getUri() != route('ink.logout'))
                            <strong class="products-num">{{ (Cart::now() && count(Cart::now()->getItems()) > 0 )? Cart::getQuote()->getItemsQty():0 }}</strong>
                        @else
                            <strong class="products-num">0</strong>
                        @endif
                    </a>
                    <div class="dropdown-menu cart-dropdown">
                        <div id="cart-sidebar">
                            <div id="minicart-error-message" class="minicart-message odd"></div>
                            <div id="minicart-success-message" class="minicart-message even"></div>
                            <div class="block-content" id="topCartContent">
                                <div class="box-content">

                                    @if(Request::getRequestUri() != route('checkout',[],false) && Request::getRequestUri() !=route('checkout.success',[],false))
                                        @include('components.minicart')
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>

            @include('components.search-component')
        </div>
    </div>

    <div class="header-nav">
        <nav>
            <div class="container">
                <ul class="main-nav">
                    @if(Request::getUri() != route('home') . '/')
                    <li class="nav-brand level0 cartridge-finder">
                        <div class="level-top-box">
                            <a class="btn-close" href="javascript:;"></a>
                            <a href="javascript:;" class="level0 has-children">
                                <span>Cartridge Finder</span>
                            </a>
                            <div class="box-menu header-cartrigefinder">
                                <div class="col pad-mob-0 header-cartrigefinder-div">
                                    <section class="cartrigefinder">
                                        @include('components.main-cartridge-finder-component',['brands'=>PrinterCategory::getCommonBrands(['url_rewrite'])])
                                    </section>
                                </div>
                            </div>
                        </div>
                    </li>
                    @endif
                    <li class="nav-brand level0 parent">
                        <div class="level-top-box">
                            <a class="btn-close" href="javascript:;"></a>
                            <a href="javascript:;" class="level0 has-children">
                                <span>Ink Cartridges</span>
                            </a>
                            <div class="box-menu">
                                <ul class="nav-brands-list">
                                    @foreach(PrinterCategory::getBrandsWithType('Ink', 6) as $brands)
                                        @foreach($brands as $brand)
                                            @foreach($brand->children as $cat)
                                                @if($cat->category_name === 'Ink')
                                                    <li>
                                                        <a href="{{$cat->getUrl()}}">
                                                            <img src=@resource(PrinterCategory::imageUrl($brand, 'tonercitytheme')) alt="{{ $brand->category_name }}" title="{{ $brand->category_name }} "/>
                                                        </a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li class="nav-brand level0 parent">
                        <div class="level-top-box">
                            <a class="btn-close" href="javascript:;"></a>
                            <a href="javascript:;" class="level0 has-children">
                                <span>Toner Cartridges</span>
                            </a>
                            <div class="box-menu">
                                <ul class="nav-brands-list">
                                    @foreach(PrinterCategory::getBrandsWithType('Toner', 6) as $brands)
                                        @foreach($brands as $brand)
                                            @foreach($brand->children as $cat)
                                                @if($cat->category_name === 'Toner')
                                                    <li>
                                                        <a href="{{$cat->getUrl()}}">
                                                            <img src=@resource(PrinterCategory::imageUrl($brand, 'tonercitytheme')) alt="{{ $brand->category_name }}" title="{{ $brand->category_name }} "/>
                                                        </a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </li>

                    @if(Store::getConfig(\Inkstation\Sales\Model\Constants::CONFIG_REORDER_MUST_FULL_LOGIN, false) ? Auth::isFullLogin() : Auth::check())
                        <li class="nav-default level0 parent">
                            <div class="level-top-box">
                                <a href="{{route('customer.reorder')}}" class="level0 has-children">
                                    <span>Quick Reorder</span>
                                </a>
                            </div>
                        </li>
                    @endif
                </ul>
            </div>
        </nav>
    </div>
</header>
