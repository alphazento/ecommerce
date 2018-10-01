<?php $categories = CategoryService::getCategoriesByLevel(2); ?>

@if(!$categories->isEmpty())
<div class="container">
  <nav id="menu" class="navbar">
    <div class="navbar-header"><span id="category" class="visible-xs">{{ __('category') }}</span>
      <button type="button" class="btn btn-navbar navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse"><i class="fa fa-bars"></i></button>
    </div>
    <div class="collapse navbar-collapse navbar-ex1-collapse">
      <ul class="nav navbar-nav">
        @foreach($categories as $category)
        @if($category->children)
        <li class="dropdown"><a href="{{ DanamicAttributeFactory::single($category, 'url_path')->getValue() }}" class="dropdown-toggle" data-toggle="dropdown">{{ $category->name }}</a>
          <div class="dropdown-menu">
            <div class="dropdown-inner">
              @foreach($category->children as $children)
              <ul class="list-unstyled">
                @foreach($children->children ?? [$children]  as $child)
                <li><a href="{{ DanamicAttributeFactory::single($child, 'url_path')->getValue() }}">{{ $child->name }}({{ $child->children_count }})</a></li>
                @endforeach
              </ul>
              @endforeach
            </div>
            {{
              json_encode($category)
            }}
            <?php die; ?>
            <a href="{{ $category->url_path }}" class="see-all">{{ __('all categories') }} </a> </div>
        </li>
        @else
        <li><a href="{{ $category->url_path }}">{{ $category->name }}</a></li>
        @endif
        @endforeach
      </ul>
    </div>
  </nav>
</div>
@endif