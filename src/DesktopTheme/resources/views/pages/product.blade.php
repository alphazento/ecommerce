@extends('layouts.3columns')

@push('head')
    <link rel="stylesheet" href=@asset("/tonercitytheme/assets/css/product.css")>
@endpush

@section('schema')
    @include('schemas.product_schema',[
        'imageUrl'=>$product->getImageUrl(),
        'productName'=>$productName,
        'desc'=>str_replace('"', "'",$product->getDescription(false, false)),
        'specialPrice'=>$product->getSpecialPrice(true),
        'normalPrice'=>$product->getPrice(true),
        'isOutOfStock'=>$product->isOutOfStock()
    ])
@endsection


@push('styles')
    .before-price {
        color: blue;
        font-size: 25px;
        font-weight: bold;
    }

    s {
        color: red;
    }

    .out-of-stock {
        color: red;
        font-size: 30px;
        font-weight: bold;
    }
@endpush

@section('custom')

    <div class="pagecontent">
        <div class="container">
            <div class="pagecontent__row">
                <aside class="pagecontent__side">
                    <div class="">
                        <!-- fancy start -->
                        <section id="fancy">
                            <div class="clearfix">
                                <div class="">
                                    <div class="xzoom-container">
                                        <img src="{{ Store::catalog_image($product->products_image, 277) }}"
                                             alt="{{trim($productName)}}">
                                    </div>
                                </div>
                                <div class=""></div>
                            </div>
                        </section>
                        <!-- fancy end -->
                        @hook('product-image-footer')
                    </div>
                </aside>

                <div class="pagecontent__main">
                    <div class="pdetails">
                        <div class="row mb-4">
                            <div class="col-6">

                                @if($product->getSpecialPrice(true) != $product->getPrice(true))
                                    <s>
                                        <span style="color:red;">
                                            {{ Sales::formatAsCurrency($product->getPrice(true), true) }}
                                        </span>
                                    </s>
                                    <span class="pdetails__cost" style="color:blue;">
                                    {{ Sales::formatAsCurrency($product->getSpecialPrice(true), true) }}
                                </span>
                                @if (Product::isShippingFree($product->getSpecialPrice(), $product->products_weight))
                                    <div class="searched-products__free-shipping">
                                        FREE SHIPPING
                                    </div>
                                @endif
                                @else
                                <span class="pdetails__cost">
                                    {{ Sales::formatAsCurrency($product->getSpecialPrice(true), true) }}
                                </span>
                                @endif
                            </div>

                            @if (!$product->isOutOfStock())
                                <div class="col-6 text-right">
                                    <b class="pdetails__instock">IN STOCK</b>
                                </div>
                            @else
                                <div class="col-6 text-right">
                                    <b class="pdetails__instock">Out of Stock</b>
                                </div>
                            @endif

                        </div>

                        <div class="pdetails__actions mb-3">
                            @if (!$product->isOutOfStock())
                                <form method="POST" action="/cart/add/{{ $product->products_id }}" name="buy_now">
                                    @csrf_field()
                                    <div class="clearfix mb-4">
                                        <span class="pdetails__qty">Qty</span>

                                        @include('components.numberselecter', ['properties' => ['name' => 'buyqty'], 'from' => 1, 'to' => 20])
                                    </div>

                                    <div class="clearfix">
                                        <div class="row">
                                            <div class="col-sm-6 col-lg-4 mb-3">
                                                <button class="btn btn--addtocart  btn-lg w-100" type="submit"
                                                        title="Add to Cart">ADD TO CART
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            @else
                                <div style="color:red;">Out of Stock</div>
                            @endif


                        </div>

                        <div class="pdetails__specs mb-3">
                            <div><strong>Specification</strong></div>
                            @if($product->getColour())
                            <div>Colour: {{ $product->getColour() }}</div>
                            @endif
                            @if($product->getYield())
                            <div>Yield: {{ $product->getYield() }}</div>
                            @endif
                            @if($product->getOemCode())
                            <div>OEM Code: {{ $product->getOemCode() }}</div>
                            @endif
                        </div>

                        <div class="pdetails__compatible mb-4">
                            <h2 class="pdetails__h2">Compatible Printer Models</h2>
                            <ul class="pdetails__printers-list clearfix">

                                @if(count($printer_models)>0)

                                    @foreach($printer_models as $printer_model)
                                        <li>
                                            <a
                                               href="{{ $printer_model->getUrl() }}">{{ $brandName !=='Tonercity' ? $brandName : '' }} {{ $printer_model->category_name }}</a>
                                        </li>
                                    @endforeach

                                @endif
                            </ul>
                        </div>

                        <div class="pdetails__infotabs">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab"
                                       href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Description</a>
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                                     aria-labelledby="nav-home-tab">
                                    {!! $product->getPlainDescription(true) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    @hook('product-content-footer')
                </div>
            </div>
            @hook('product-footer')
        </div>
    </div>
@endsection
@push('rqjs_body')
    requirejs(['jQuery', 'windowLib'], function($, windowLib) {
        $(document).ready(function(){
            $('.xzoom-container').click(function(){
                windowLib.sendMessage('open-image-modal');
            });
        });
    });
@endpush

@push('footer')
    @include('components.image-modal')
@endpush
