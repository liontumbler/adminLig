@extends('layout.layout')

@section('title', 'inicio')

@section('content')
    @php
        //echo print_r(session()->all());
        //echo print_r(session()->get('SesionAdmin'));
    @endphp
    <div id="app">
        <login-component
        :imglogo="'{{ Vite::asset('resources/img/adminLig.svg') }}'"
        ></login-component>
    </div>
@endsection
