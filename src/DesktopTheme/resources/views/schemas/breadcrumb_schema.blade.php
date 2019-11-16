<nav aria-label="breadcrumb">
    <ol class="pagetitle__breadcrumb breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">
        @php
            $lastOne = count($tree);
        @endphp
        @foreach($tree as $key=>$node)
            @if($lastOne == ($key+1))
            <li  class="breadcrumb-item" itemprop="itemListElement" itemscope
                 itemtype="https://schema.org/ListItem">
                <a class="breadcrumb-item active" itemprop="item" href="{{ $node['url'] }}">
                    <span itemprop="name">{{ $node['name'] }}</span>
                </a>
                <meta itemprop="position" content="{{ $key + 1 }}" />
            </li>
            @else
            <li  class="breadcrumb-item" itemprop="itemListElement" itemscope
                 itemtype="https://schema.org/ListItem">
                <a class="breadcrumb-item" itemprop="item" href="{{ $node['url'] }}">
                    <span itemprop="name">{{ $node['name'] }}</span>
                </a>
                <meta itemprop="position" content="{{ $key + 1 }}" />
            </li>
            @endif
        @endforeach
    </ol>
</nav>
