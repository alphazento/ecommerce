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

foreach($products as &$product) {
    $product->url = BladeTheme::getProductUrl($product);
    $product->imageUrl = BladeTheme::getProductImageUrl($product);
}
?>
<div id="app" >
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
            <product-list :products="products"></product-list>
            <a href="/products" class="b_more">MORE</a>
        </section>
</div>
<script src=@asset("zento_vuedesktoptheme/js/app.js") type="text/javascript"></script>
<script>
const app = new Vue({
  el: '#app',
  data: {
    images: @json($images),
    products: @json($products)
  },
});
</script>
@endsection