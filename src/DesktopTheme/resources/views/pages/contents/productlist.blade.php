@extends('layouts.3columns')

@push('head')
    <link rel="stylesheet" href=@asset("/tonercitytheme/assets/css/product.css")>
@endpush

@section('php')
    @php
        $moreProductFrom = ($curPage - 1) * $pageSize;
        $moreProductTo = $moreProductFrom + count($moreProducts);
        $totalPages = ceil($moreTotal / $pageSize);
        if ($moreProducts->first()) {
            $moreProducts->first()->massAssignEav($moreProducts, 'url_rewrite');
        }

        foreach($tree as $row){
            BladeTheme::breadcrumb($row->getUrl(), $row->getName());
        }
        BladeTheme::breadcrumb('brand', $tree[0], true)
            ->breadcrumb('page','productList', true);
    @endphp
@endsection

@section('custom')
    <div class="pagecontent">
        <div class="container">
            @hook('productlist-content-top')
            <div class="pagecontent__row">

                <div class="pagecontent__main" style="width: 100%;">
                    <section class="searched-products">
                        <div class="searched-products__count">
                            Displaying <b>
                                @if($moreTotal == 0)
                                    0
                                @else
                                    {{$moreProductFrom + 1}}
                                @endif
                            </b> to <b>{{$moreProductTo}}</b> (of <b>{{$moreTotal}}</b> products)
                        </div>
                        <ul class="searched-products__items">

                            @foreach($moreProducts as $product)
                                @include('components.product-component',['product'=>$product])
                            @endforeach
                        </ul>

                        <div class="row paging-row mt-5">
                            <div class="col-sm-8">
                                <nav aria-label="Page navigation example">


                                    <ul class="pagination">
                                        <li class="page-item">
                                            <a class="page-link" href="#" aria-label="Previous">
                                                <span class="lsaquo" aria-hidden="true">&lsaquo;</span>
                                                <span class="sr-only">Previous</span>
                                            </a>
                                        </li>
                                        @if ($curPage > 1)
                                            <li class="page-item">
                                                <a class="page-link"  href="{{$category->getUrl()}}{{ $curPage > 2 ? sprintf('?page=%s', $curPage -1 ) :''}}"
                                                   title=" Previous Page ">&lt;&lt;
                                                </a>
                                            </li>
                                        @endif
                                        @for($i = 1; $i <= $totalPages; $i++)
                                            <li class="page-item {{$i==$curPage ?'active':''}}"><a class="page-link"
                                                                                                   href="{{$category->getUrl()}}{{ $i > 1 ? sprintf('?page=%s', $i) :''}}"
                                                        title=" Page {{$i}} ">{{$i}}</a>
                                            </li>
                                        @endfor

                                        @if ($curPage < $totalPages)
                                            <li class="page-item"><a  class="page-link"  href="{{$category->getUrl()}}{{ sprintf('?page=%s', $curPage + 1 ) }}"
                                                   title=" Next Page ">
                                                    &nbsp;&gt;&gt;
                                                </a></li>
                                        @endif
                                            <li class="page-item">
                                                <a class="page-link" href="#" aria-label="Next">
                                                    <span class="rsaquo" aria-hidden="true">&rsaquo;</span>
                                                    <span class="sr-only">Next</span>
                                                </a>
                                            </li>
                                    </ul>
                                </nav>
                            </div>
                            {{--<div class="col-sm-4 text-right">--}}
                                {{--<div class="limiter">--}}
                                    {{--<label class="limiter__label" for="limiter">--}}
                                        {{--<span>Show</span>--}}
                                    {{--</label>--}}
                                    {{--<div class="limiter__control">--}}
                                        {{--<select id="limiter" data-role="limiter" class="limiter__options">--}}
                                            {{--<option value="9">9</option>--}}
                                            {{--<option value="15">15</option>--}}
                                            {{--<option value="30" selected="selected">30</option>--}}
                                        {{--</select>--}}
                                    {{--</div>--}}
                                    {{--<span class="limiter__text">per page</span>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        </div>
                    </section>
                </div>
            </div>
            @hook('productlist-content-footer')
        </div>
    </div>
@endsection


