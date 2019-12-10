@php 
  $level = 0;
  function _renderCategoryMenu_($category, $level) {
    $hasChildren = $category->children && $category->children->count();
    $html[] = sprintf('<li class="%s">', $level === 0 ? 'dropdown' : '');
    if ($level === 0) {
      if ($hasChildren) {
        $html[] =  '<v-hover v-slot:default="{ hover }">';
        $html[] =  '<div class="menu-item">';
        $html[] = sprintf('<a v-if="!hover" text >%s</a>', $category->name);
        $html[] = sprintf('<a v-if="hover"  href="%s">%s</a>', $category->url, $category->name);
        $html[] =  '</div>';
        $html[] =  '</v-hover>';
      } else {
        $html[] = sprintf('<a class="menu-item" href="%s">%s</a>', $category->url, $category->name);
      }
    } else {
      $html[] = sprintf('<a href="%s">%s</a>', $category->url, $category->name);
    }

    if ($hasChildren) {
      if ($level < 1) {
        $html[] = sprintf('<div class="sub-nav level-%s">', $level);
        $html[] = '<ul class="container">';
      } else {
        $html[] = sprintf('<ul class="sub-nav level-%s">', $level);
      }
      
      foreach($category->children as $subCate) {
        $html[] = _renderCategoryMenu_($subCate, $level+1);
      }
      $html[] = '</ul>';
      if ($level < 1) {
        $html[] = '</div>';
      }
    }
    $html[] = '</li>';
    return implode(PHP_EOL, $html);
  }
@endphp
<ul class="category-menu-nav">
  @php
  foreach($category_tree as $category) {
    if ($category->include_in_menu) {
      echo _renderCategoryMenu_($category, 0);
    }
  }
  @endphp
</ul>
