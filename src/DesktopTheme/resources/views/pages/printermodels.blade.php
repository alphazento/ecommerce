@extends('layouts.3columns')


@push('head')
    <link rel="stylesheet" href=@asset("/tonercitytheme/assets/css/brand.css")>
@endpush


@section('php')
    @php
        $brandName = $tree[0]->getName();
        $brandUrl = $tree[0]->getUrl();
        $typeName = isset($tree[1]) ? $tree[1]->getName() : '';

        $data = \PrinterCategory::getPrinterModels(last($tree));


        // printer model drop down list
        $map = [];
        $names = [];
        $childrenCollection = last($tree)->children;
        if ($model = $childrenCollection->first()) {
            $model->massAssignEav($childrenCollection, 'url_rewrite')->massEagerChildrenAmount($childrenCollection);
        }
        foreach ($childrenCollection as $model) {
        // foreach (last($tree)->children as $model) {
            $names[] = $model->getName();
            $map[$model->getName()] = $model->getUrl();
        }
        natsort($names);

        $printerModelsDropDown=[];
        foreach($names as $name){
            $printerModelsDropDown[] = [
                    'url'=> $map[$name],
                    'name'=>$name
            ];
        }


        // type drop down
        $childrenCollection = $tree[0]->children;
        if ($model = $childrenCollection->first()) {
            $model->massAssignEav($childrenCollection, 'url_rewrite')->massEagerChildrenAmount($childrenCollection);
        }

        $typeDropDown = [];

        foreach($childrenCollection  as $subcat){
            $typeDropDown[] = [
                    'url'=> $subcat->getUrl(),
                    'name'=> $subcat->getName()
            ];
        }


        // series drop down

        $seriesDropDown = [];
        foreach(last($tree)->allSubSeries as $key => $series){
            $seriesDropDown[] = [
            'url'=>sprintf('#%s', $series->getNameAsHtmlTag()),
            'name'=> $series->getName()
            ];
        }

    @endphp
@endsection

@section('custom')
    <div class="pagecontent">
        <div class="container">
            @include('components.brand-cartridge-finder-component',[
                'typeName'=>$typeName,
                'brandName'=>$brandName,
                'brandUrl'=>$brandUrl,
                'names'=>$names,
                'typeDropDown'=>$typeDropDown,
                'seriesDropDown'=>$seriesDropDown,
                'printerModelsDropDown'=>$printerModelsDropDown
            ])
            @if($data)
                @foreach($data as $series)
                    <section class="finde-result">
                        <h2 class="finde-result__h2"><a id="{{ $series['series_html_tag'] }}">&#160;</a>
                            {{ $brandName }} {{ $series['series_name'] }}</h2>
                        <div class="row finde-result__list">
                            @foreach($series['categories'] as $key => $value)
                                <div class="col-6 col-sm-3">
                                    <li><a href="{{ \Illuminate\Support\Str::start($value['url_rewrite'], '/') }}">{{$value['category_name']}} </a></li>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endforeach
            @endif
        </div>
    </div>

@endsection
