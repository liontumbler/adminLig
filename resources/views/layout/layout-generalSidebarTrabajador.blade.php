@extends('layout.layout')

@section('content')
    <div id="app">
        <nav-sidebar
            :color="{{ json_encode($arrayConfig['color']) }}"
            :background="{{ json_encode($arrayConfig['background']) }}"
            :nombregimnasio="{{ json_encode($arrayConfig['nombreGimnasio']) }}"
            :nombreperfil="{{ json_encode($arrayConfig['nombrePerfil']) }}"
            :btnssidebar="[
                {nombre: 'home3', href: 'home3', icon: 'bi bi-house-door'},

            ]"
            :footersidebar="[
                {nombre: 'home', href: 'home'},
                {nombre: 'home2', href: 'home2'},
            ]"
            :btnsnav="[
                {nombre: 'home', href: 'home'},
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
    </div>
@endsection
