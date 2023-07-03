@extends('layout.layout')

@section('content')
    <div id="nav">
        <nav-component></nav-component>
        <!--nav-sidebar></nav-sidebar-->
    </div>
    <div class="container p-94px" id="app">
        @yield('contenedor')
    </div>
@endsection





