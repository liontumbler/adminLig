@extends('layout.layout')

@section('title', 'inicio')

@section('content')
    <div id="app">
        <login-component :login="'trabajador'"></login-component>
    </div>
@endsection
