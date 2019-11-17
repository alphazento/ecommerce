{{-- <v-breadcrumbs :items="items" divider=">"></v-breadcrumbs> --}}
<nav aria-label="breadcrumb">
    <ol class="v-breadcrumbs" itemscope itemtype="https://schema.org/BreadcrumbList">
        @php
            $tree = BladeTheme::getBreadcrumb();
            $lastOne = count($tree) -1 ;
        @endphp
        @foreach($tree as $key=>$node)
            <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <a class="v-breadcrumbs__item {{ $lastOne == $key ? 'v-breadcrumbs__item--disabled' : '' }}" itemprop="item" href="{{ $node['url'] }}">
                    <span itemprop="name">{{ $node['title'] }}</span>
                </a>
                @if( $key < $lastOne)
                    <span class="v-breadcrumbs__divider" style="margin-left: 10px;">></span>
                @endif
                <meta itemprop="position" content="{{ $key + 1 }}" />
            </li>
        @endforeach
    </ol>
</nav>