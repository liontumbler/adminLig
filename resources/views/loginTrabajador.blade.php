@extends('layout.layout')

@section('title', 'inicio')

@section('content')
    @php
        //echo print_r(session()->all());
        echo print_r(session()->get('SesionTrabajador'));
    @endphp
    <div id="app">
        <login-component :login="'trabajador'"></login-component>
    </div>
@endsection
