@extends('layout.frame', ['nav_page' => 'home'])

@push('head')
    <title>Home page</title>
@endpush

@section('pagecontent')
    <?php 
    $images = [
        ['img'=> '/zento_vuedesktoptheme/image/banner.jpg', 'title' => "Image 1"],
        ['img'=> '/zento_vuedesktoptheme/image/banner2.jpg', 'title' => "Image 2"]
    ];
    ?>
    <spinner-layer></spinner-layer>
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
        <h1 class="index_h1">HOT PRODUCTS</h1>
        <product-grid :pagination="pagination" :gerneral-mode="true"></product-grid>
        <a href="/products" class="b_more">MORE</a>
    </section>
@endsection

@push('tail')
    <script>
    const store = window.vStore.default;
    const app = new Vue({
        el: '#app',
        store,
        vuetify: new Vuetify(),
        data: {
            images: @json($images),
            pagination: @json($pagination)
        },
    });
    </script>
@endpush