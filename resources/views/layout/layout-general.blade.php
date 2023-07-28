@extends('layout.layout')

@section('content')
    <div id="app">
        <nav-component
        :logo="'{{ Vite::asset('resources/img/adminLig.svg') }}'"
        ></nav-component>
        <!--nav-sidebar></nav-sidebar-->
        <div class="container pt-94px">
            @yield('contenedor')
        </div>

        @include('layout.footer')
    </div>
@endsection





