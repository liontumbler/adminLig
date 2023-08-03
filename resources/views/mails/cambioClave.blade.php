@extends('layout.layout')

@section('title', 'Código de caja')

@section('content')
<div class="container">
    @vite(['resources/css/login.css'])
    <img src="{{ Vite::asset('resources/img/adminLig.svg') }}" alt="Nocarga" class="w-50 d-block m-auto">
    <h1 class="text-center mt-2">AdminLig</h1>

    <p class="text-center">
        <strong>Hola!</strong> {{ (empty(session()->get('SesionTrabajador')['nombre']) ? 'vacio' : session()->get('SesionTrabajador')['nombre']) }}
    </p>
    <p class="text-center">
        El código para ingresar a la su caja el día hoy: <strong>{{ date('Y-m-d H:i:s') }}</strong>
    </p>
    <p class="text-center">
        <strong>La clave es: {{ $claveCajaNueva }}</strong>
    </p>

    @include('layout.footer')
</div>
@endsection
