@extends('layout.layout')

@section('content')
    <div id="app">
        <nav-sidebar
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
        <div class="container p-94px">
            @yield('contenedor')
        </div>
    </div>
@endsection