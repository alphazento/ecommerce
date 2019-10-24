<div class="breadCrumb">
    <a href="/" class="breadCrumb_no" title="Home">Home</a>
    @foreach(BladeTheme::getBreadcrumb() as $item)
        <a href="{{ $item['url'] }}"  title="{{$item['title']}}">{{$item['title']}}</a>
    @endforeach
</div>