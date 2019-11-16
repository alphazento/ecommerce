@extends('layouts.3columns')

@push('head')
    <link rel="stylesheet" href=@asset("/tonercitytheme/assets/css/brand.css")>
@endpush

{{--required--}}
@section('custom')
    <div class="pagecontent">
        <div class="container">
            @hook('brand-content-top')
            @foreach($brand->children as $cat)
            <section class="finde-result">
                <h2 class="finde-result__h2"> {{ $cat->category_name }} Cartridges</h2>
                <div class="row finde-result__list">
                    @php
                        $data = \PrinterCategory::getPrinterModels($cat);
                    @endphp
                    @foreach($data as $row)

                        <div class="col-6 col-sm-3">
                            <a href="{{ url($cat->getUrl()).'#'.$row['series_html_tag']}}">{{$row['series_name']}}</a>
                        </div>
                    @endforeach
                </div>
            </section>
            @endforeach
            @hook('brand-content-footer')
        </div>
    </div>
@endsection
