@extends('layouts.3columns')

@section('php')
    @php
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
            @php
                $display_name = sprintf('%s %s Printers', $tree[0]->getName(), last($tree)->getName());
            @endphp
            <h3>
                Cartridges for {{ $display_name }}
            </h3>
            <h5 class="sub-cat-title">Categories</h5>
            <hr class="sub-cat-hr">
            @foreach($subCatDesc as $desc)
                <a href="?category={{$desc->categories_id}}" style="line-height: 2;">
                    <span class="sub-cat-symbol">» </span>
                    <span class="sub-cat-name">{{ $desc->categories_name }}</span>
                </a>
                <br>
            @endforeach
        </div>
    </div>
@endsection
