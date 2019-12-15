@extends('layout.frame', ['nav_page' => 'register'])

@push('head')
    <title>Register</title>
@endpush

@section('pagecontent')
<v-container fluid>
    <signin-signup work-mode="signup">
        <template>
            <slot name="sns_login"></slot>
        </template>
    </signin-signup>
</v-container>
@endsection

@push('tail')
    <script>
    const store = window.vStore.default;
    const app = new Vue({
        el: '#app',
        store,
        vuetify: new Vuetify(),
    });
    </script>
@endpush