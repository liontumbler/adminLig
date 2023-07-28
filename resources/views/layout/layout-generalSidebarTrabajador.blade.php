@extends('layout.layout')

@section('content')
    <div id="app">
        <nav-sidebar
            :logo="'{{ Vite::asset('resources/img/adminLig.svg') }}'"
            :color="'{{ json_encode($arrayConfig['color']) }}'"
            :background="'{{ json_encode($arrayConfig['background']) }}'"
            :nombregimnasio="'{{ json_encode($arrayConfig['nombreGimnasio']) }}'"
            :nombreperfil="'{{ json_encode($arrayConfig['nombrePerfil']) }}'"
            :btnssidebar="[
                {nombre: 'home3', href: 'home3', icon: 'bi bi-house-door'},
            ]"
            :footersidebar="[
                {nombre: 'home', href: 'home'},
                {nombre: 'home2', href: 'home2'},
            ]"
            :btnsnav="[
                {nombre: 'home', href: 'home'},
                {nombre: 'Opciones', href: [
                    {nombre: 'Administradores', href: '/loginAdmin'},
                    {nombre: 'Trabajadores', href: '/loginTrabajador'},
                    {nombre: 'divider'},
                    {nombre: 'PQRs', href: 'dos'}
                ]},
            ]"
        ></nav-sidebar>

        <div class="container pt-94px">
            @yield('contenedor')
        </div>

        @include('layout.footer')
    </div>
@endsection
