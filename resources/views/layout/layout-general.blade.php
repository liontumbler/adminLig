@extends('layout.layout')

@section('content')
    <div id="app">
        <nav-component></nav-component>
        <!--nav-sidebar></nav-sidebar-->
        <div class="container pt-94px">
            @yield('contenedor')
        </div>
    </div>
@endsection





