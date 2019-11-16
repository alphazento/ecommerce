@php
    $display_name = sprintf('%s %s %s', $tree[0]->getName(), last($tree)->getName(), $tree[1]->getName());
@endphp


@includecache($cacheKey, "pages.contents.productlist", ['display_name'=>$display_name, 'showPrinterModels' => false])
