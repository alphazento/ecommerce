@extends('layout.frame', ['nav_page' => 'home'])

@push('head')
    <title>Home | Alphazento</title>
@endpush

@section('pagecontent')
    <?php 
    $images = [
        ['img'=> '/zento_vuetheme/image/banner.jpg', 'title' => "Image 1"],
        ['img'=> '/zento_vuetheme/image/banner2.jpg', 'title' => "Image 2"]
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
        <product-grid :dataset="pagination" :gerneral-mode="true"></product-grid>
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
            user: @json($user),
            images: @json($images),
            pagination: @json($pagination),
            consts: @json($consts)
        },
        created() {
            console.log('data', this.$data)
            this.$store.dispatch('setConsts', this.consts);
            this.$store.dispatch('setUser', this.user);
        }
    });
    </script>
@endpush