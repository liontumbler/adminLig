@extends('layout.layout')

@section('title', 'login del trabajador')

@section('content')

    @php
        //echo print_r(session()->all());
        //echo print_r(session()->get('SesionTrabajador'));
    @endphp
    <div id="app">
        @vite(['resources/css/login.css'])
        @vite(['resources/css/fondo.css'])
        <login-component
        :login="'trabajador'"
        :fondo="'{{ Vite::asset('resources/img/cheer fondo.jpg') }}'"
        :imglogo="'{{ Vite::asset('resources/img/adminLig.svg') }}'"
        ></login-component>
    </div>
@endsection
