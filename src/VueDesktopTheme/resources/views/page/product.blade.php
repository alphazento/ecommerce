@extends('layout.frame', ['nav_page' => 'home'])

@push('head')
    <title>BaicyTek product</title>
@endpush

@section('pagecontent')
    <section id="product_index">
        <h1 class="index_h1">{{ strtoupper($product->name)}}</h1>
        <v-container fluid >
            <v-layout row>
              <v-flex>
              </v-flex>
            </v-layout>
        </v-container>
    </section>
@endsection

@push('tail')
    <script>
    const app = new Vue({
        el: '#app',
        vuetify: new Vuetify(),
        data: {
            product: @json($product)
        },
    });
    </script>
@endpush