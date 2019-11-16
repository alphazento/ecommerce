<div class="level-top-box">
    <a class="btn-close" href="javascript:;"></a>
    <a href="javascript:;" class="level0 has-children">
        <span>{{$type}} Cartridges</span>
    </a>
    <div class="box-menu">
        <ul class="nav-brands-list">
            @foreach(PrinterCategory::getBrandsWithType($type, 6) as $brands)
                @foreach($brands as $brand)
                    @foreach($brand->children as $cat)
                        @if($cat->category_name === $type)
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


