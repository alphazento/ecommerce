<div class="list-group">
  @foreach($categories as $category)
    @if($category->id == $category_id) 
      <a href="{{ $category->url_path }}" class="list-group-item active">{{ $category->name }}</a> 
      @if($category->childrenCategories)
        @foreach($category->childrenCategories as $child)
          @if($child->id == $child_id)
          <a href="{{ $child->url_path }}" class="list-group-item active">&nbsp;&nbsp;&nbsp;- {{ CategoryService::getName($child, true)  }}</a> 
          @else
          <a href="{{ $child->url_path }}" class="list-group-item">&nbsp;&nbsp;&nbsp;- {{ CategoryService::getName($child, true) }}</a>
          @endif
        @endforeach
      @endif
    @else
      <a href="{{ $category->url_path }}" class="list-group-item">{{ $category->name }}</a>
    @endif
  @endforeach
</div>
