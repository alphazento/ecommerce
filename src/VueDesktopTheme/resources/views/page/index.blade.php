@extends('layout.frame', ['nav_page' => 'home'])

@push('head')
    <title>BaicyTek Home page</title>
@endpush

@section('pagecontent')
    <?php 
    $images = [
        ['img'=> '/zento_vuedesktoptheme/image/banner.jpg', 'title' => ""],
        ['img'=> '/zento_vuedesktoptheme/image/banner2.jpg', 'title' => ""]
    ];
    ?>
    <section id="banner">
        <!-- This comp. can have a modal included. -->
        <image-carsousel 
            :speed="1"
            :img-data="images"
            >
        </image-carsousel>
        <image-gallery>
        </image-gallery>
    </section>
    <section id="product_index">
        <h1 class="index_h1">HOT PRODUCT</h1>
        <product-list :pagination="pagination"></product-list>
        <a href="/products" class="b_more">MORE</a>
    </section>
@endsection

@push('tail')
    <script>
    const app = new Vue({
        el: '#app',
        vuetify: new Vuetify(),
        data: {
            images: @json($images),
            pagination: @json($pagination)
        },
    });
    </script>
@endpush