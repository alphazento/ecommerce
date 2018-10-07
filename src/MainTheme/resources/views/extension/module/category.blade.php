<div class="list-group">
  @foreach($categories as $category)
    @if($category['category_id'] == $category_id) 
      <a href="{{ $category['href'] }}" class="list-group-item active">{{ $category['name'] }}</a> 
      @if($category['children'])
        @foreach($category['children'] as $child)
          @if($child['category_id'] == $child_id)
          <a href="{{ $child['href'] }}" class="list-group-item active">&nbsp;&nbsp;&nbsp;- {{ $child['name'] }}</a> 
          @else
          <a href="{{ $child['href'] }}" class="list-group-item">&nbsp;&nbsp;&nbsp;- {{ $child['name'] }}</a>
          @endif
        @endforeach
      @endif
    @else
      <a href="{{ $category['href'] }}" class="list-group-item">{{ $category['name'] }}</a>
    @endif
  @endforeach
</div>
