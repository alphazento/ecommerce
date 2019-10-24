<div class="menu_left">
    <ul>
        @foreach($categories as $category) 
        <li class="{{$currentCateId == $category->id ? 'li_on' : ''}}">
            <a href="{{BladeTheme::getCategoryUrl($category)}}">{{$category->name}} Products</a>
        </li>
        @endforeach
    </ul>
</div>