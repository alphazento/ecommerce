@extends('layout.frame', ['nav_page' => 'home'])

@push('head')
    <title>Home | Alphazento</title>
@endpush

@section('pagecontent')
    <?php

?>
    <section>
        <!-- This comp. can have a modal included. -->
        <image-carousel
            :speed="1"
            :img-data="carousel"
            >
        </image-carousel>
    </section>
    <section>
        <image-gallery :cards="gallery">
        </image-gallery>
    </section>
    <section>
        <h1 class="index_h1">HOT PRODUCTS</h1>
        <product-grid :dataset="topsale" :gerneral-mode="true"></product-grid>
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
        data() {
            var pageData = @json($pageData);
            return pageData;
        },
        created() {
            console.log('data', this.$data)
            this.$store.dispatch('BIND_CUSTOMER', window.appData.user);
        }
    });
</script>
@endpush