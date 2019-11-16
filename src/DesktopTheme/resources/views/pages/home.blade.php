@extends('layouts.3columns')

@section('title')
    <title>Alphazento</title>
@endsection

@push('head')
    <link rel="stylesheet" href=@asset('/desktoptheme/css/home.css')>
@endpush

@section('custom')
    <div class="heroarea">
        <div class="container">
            <div class="row mb-4 mt-0 mt-xl-3">
                <div class="col pad-mob-0">
                    <section class="cartrigefinder">
                        <h2 class="cartrigefinder__title d-xl-block">Cartridge Finder</h2>
                        @includecache('', 'components.main-cartridge-finder-component',['brands'=>PrinterCategory::getCommonBrands(['url_rewrite'])])
                    </section>
                </div>
                <div class="slideshow__wrapper pad-mob-0">
                    <section class="slideshow">
                        <h2 class="d-none">Slideshow</h2>
                        <div id="slideshow" class="carousel slide carousel-fade" data-ride="carousel"
                             data-interval="6000">
                            <ol class="carousel-indicators">
                                <li data-target="#slideshow" data-slide-to="0" class="active"></li>
                                <li data-target="#slideshow" data-slide-to="1"></li>
                                <li data-target="#slideshow" data-slide-to="2"></li>
                                <li data-target="#slideshow" data-slide-to="3"></li>
                            </ol>
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img class="d-block w-100" src=@asset("/tonercitytheme/assets/img/banner/1.jpg") alt="">
                                </div>
                                <div class="carousel-item">
                                    <img class="d-block w-100" src=@asset("/tonercitytheme/assets/img/banner/2.jpg") alt="">
                                </div>
                                <div class="carousel-item">
                                    <img class="d-block w-100" src=@asset("/tonercitytheme/assets/img/banner/3.jpg") alt="">
                                </div>
                                <div class="carousel-item">
                                    <img class="d-block w-100" src=@asset("/tonercitytheme/assets/img/banner/4.jpg") alt="">
                                </div>
                            </div>
                            <a class="carousel-control-prev" href="#slideshow" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#slideshow" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>

    <section class="allbrands mb-4">
        <div class="container">
            <h2 class="allbrands__title">Printer Ink and Toner Cartridges - Alphazento<br/>Printer Cartridge Brands</h2>

            <div class="row">
                <ul class="allbrands__list">
                    @foreach(PrinterCategory::getCommonBrands(['url_rewrite'])  as $brand)
                        <li>
                            <a class="brand-list-link" href="{{ $brand->getUrl() }}">
                                <img class="img-fluid"
                                     src=@asset(PrinterCategory::imageUrl($brand, 'tonercitytheme'))
                                     alt="{{ $brand->category_name }}"
                                     title="{{ $brand->category_name }}">
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>

    <section class="services mb-1">
        <div class="container">
            <h2 class="services__title">Why Choose Alphazento</h2>

            <div class="services__list text-center">
                <div class="row">
                    <div class="col-md-3 mb-4">
                        <img class="img-fluid mb-3"
                             src=@asset("/tonercitytheme/assets/img/services/ico-top-quality-ink.gif")
                             alt="">
                        <h3>Ink & Toner at Fantastic Prices</h3>
                        <p>
                            We stock a wide selection from all the major brands at the lowest possible prices
                        </p>
                    </div>
                    <div class="col-md-3 mb-4">
                        <img class="img-fluid mb-3"
                             src=@asset("/tonercitytheme/assets/img/services/ico-orders.gif") alt="">
                        <h3>Fast and Free Delivery</h3>
                        <p>Orders placed before 3pm are dispatched the same business day Free delivery on orders over
                            $50</p>
                    </div>
                    <div class="col-md-3 mb-4">
                        <img class="img-fluid mb-3"
                             src=@asset("/tonercitytheme/assets/img/services/ico-quality-satisfaction-guaranteed.gif")
                             alt="">
                        <h3>Quality & Satisfaction Guaranteed</h3>
                        <p>1-Year satisfaction on all our products</p>
                    </div>
                    <div class="col-md-3 mb-4">
                        <img class="img-fluid mb-3"
                             src=@asset("/tonercitytheme/assets/img/services/ico-secure-online-checkout.gif")
                             alt="">
                        <h3>Safe and Secure Shopping</h3>
                        <p>128-Bit SSL Secure Online Checkout</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
