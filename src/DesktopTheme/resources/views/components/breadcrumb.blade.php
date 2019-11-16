
<div class="pagetitle">
    <div class="container clearfix">
        @include('schemas.breadcrumb_schema',['tree'=>$tree])

        @if(isset($page))
            @if($page === 'product')
                @php
                    $display_name = last($tree)['name'];
                @endphp
                <h1 class="pagetitle__h1">{!! $display_name !!}</h1>
            @elseif($page === 'productList')
                @php
                    if (isset($tree[4])) {
                      $display_name = sprintf('%s %s %s', $tree[1]['name'], $tree[4]['name'], $tree[2]['name']);
                    } else {
                        // $display_name = sprintf('%s %s', $tree[1]['name'], $tree[2]['name']);
                        $display_name = sprintf('%s %s Printer', last($tree)['name'], $tree[1]['name']);
                    }
                @endphp
                <h1 class="pagetitle__h1"><img style="background-color: white;" src=@resource(PrinterCategory::imageUrl($brand, 'tonercitytheme'))/> {!! $display_name !!} Cartridges</h1>
            @elseif($page === 'printerModel')
                @php
                    $display_name = sprintf('%s %s', $tree[1]['name'], $tree[2]['name']);
                @endphp
                <h1 class="pagetitle__h1"><img style="background-color: white;" src=@resource(PrinterCategory::imageUrl($brand, 'tonercitytheme'))/> {!! $display_name !!} Cartridges</h1>
            @elseif($page === 'brand')
                @php
                    if(isset($tree[2])){
                        $display_name = sprintf('%s %s', $tree[1]['name'], $tree[2]['name']);
                    }else{
                        $display_name = sprintf('%s', $tree[1]['name']) . ' Printers';
                    }
                @endphp
                <h1 class="pagetitle__h1"><img style="background-color: white;" src=@resource(PrinterCategory::imageUrl($brand, 'tonercitytheme'))/> {!! $display_name !!} Cartridges</h1>
            @endif
        @else
            @php
                $display_name = last($tree)['name'];
            @endphp
            <h1 class="pagetitle__h1">{!! $display_name !!}</h1>
        @endif
    </div>
</div>


