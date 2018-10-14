<ul class="nav nav-tabs">
    @foreach($tabs  as  $tabName => $detail)
    <li class="active">
        <a href="#tab-{{$tabName}}" data-toggle="tab">{{ __('tab_' . $tabName) }}</a>
    </li>
</ul>
<div class="tab-content">
    @foreach($tabs  as  $tabName => $detail)
        @include($viewName)
    @endforeach
</div>