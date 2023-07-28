@extends('layout.layout')

@section('content')
    <div id="app">
        <nav-sidebar
            :logo="'{{ Vite::asset('resources/img/adminLig.svg') }}'"
            :color="'#ff00ff'"
            :background="'#fff000'"
            :btnssidebar="[
                {nombre: 'home3', href: 'home3', icon: 'bi bi-house-door'},
                {nombre: 'home4', href: 'home4', icon: 'bi bi-house-door'},
            ]"
            :footersidebar="[
                {nombre: 'home', href: 'home'},
                {nombre: 'home2', href: 'home2'},
            ]"
            :btnsnav="[
                {nombre: 'home', href: 'home'},
                {nombre: 'home2', href: 'home2'},
                {nombre: 'dorp', href: [
                    {nombre: 'uno', href: 'uno'},
                    {nombre: 'divider'},
                    {nombre: 'dos', href: 'dos'}
                ]},
            ]"
        ></nav-sidebar>
        <div class="container pt-94px">
            @yield('contenedor')
        </div>

        @include('layout.footer')
    </div>
@endsection
