@extends('layouts.3columns')

@push('head')
    <link rel="stylesheet" href=@asset("/tonercitytheme/assets/css/search.css")>
@endpush

@section('php')
    @php
        $paginationHtml = $paginator->links();
    @endphp
@endsection

@section('custom')

    <div class="pagecontent">
        <div class="container">
            <div class="pagecontent__row">
                <aside class="pagecontent__side">
                    <div class="mobaccordion mobaccordion--search sticky-top">
                        <div class="mobaccordion__head">
                            Looking for ink/toner for a printer model below?
                        </div>
                        <div class="mobaccordion__body">
                            <ul class="mobaccordion__items">
                                @foreach($suggestedPrinterModels as $printerModel)
                                <li class="mobaccordion__item">
                                    <a href="{{ $printerModel->getUrl()  }}">{{ $printerModel->getBrand() . " " . $printerModel->getName() }}</a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </aside>


                <div class="pagecontent__main">
                    <section class="searched-products">
                        <div class="searched-products__count">
                            Items {{ $productFrom }} - {{ $productTo }} of {{ $paginator->total() }}
                        </div>

                        <div class="row">
                            <div class="col-sm-8">
                                <nav aria-label="Page navigation example">
                                    @if ($paginationHtml != '')
                                        {{ $paginationHtml }}
                                    @endif
                                </nav>
                            </div>
                        </div>
                        <br>

                        <ul class="searched-products__items">
                            @foreach($products as $product)
                                @include('components.product-component',['product'=>$product])
                            @endforeach
                        </ul>

                        <div class="row paging-row mt-5">
                            <div class="col-sm-8">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination">
                                        @if ($paginationHtml != '')
                                            {{ $paginationHtml }}
                                        @endif
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>

@endsection
