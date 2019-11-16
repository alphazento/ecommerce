<!DOCTYPE html>
<html lang="en">
@include('layouts.support.head')
<body style="position: relative;">
<div class="main-part">
    @include('components.header-nav.main')
    <main>
        <div class="page-left">
        </div>
        <div class="page-middle">
            {!! BladeTheme::renderBreadcrumb() !!}
            <!-- global error, success embedded message box -->
            @include('partials.message')
            @yield('custom')
        </div>
        <div class="page-right">
        </div>
    </main>
</div>
@yield('custom-footer')
@include('components.footer')
@include('components.loading-notification')
@include('components.google-review-badge')
@include('layouts.support.requirejs')
@stack('footer')
<style>
    @stack('styles')
</style>
</body>
</html>
@php
    Session::forget('errors');
    Session::forget('message');
@endphp
