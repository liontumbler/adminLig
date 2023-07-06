@extends('errors.layout')

@section('title', 'Página Pago Requerido')

@section('content')
<div class="container container p-4 bg-dark rounded-bottom-3">
    <div class="row">
        <div class="col-lg-12">
            <img src="img/error.svg" alt="Nocarga"
                style="width: 291px; display: block; margin: auto;">
        </div>
        <div class="col-lg-12">
            <h1 class="text-white text-center" style="font-size: calc(4.375rem + 1.5vw);">402</h1>
        </div>
        <div class="col-lg-12">
            <h1 class="text-white text-center">Page Payment Required</h1>
        </div>
        <div class="col-lg-12">
            <a class="btn btn-secondary btn-lg rounded-3" href="/">Ir al Home</a>
        </div>
    </div>
</div>
@endsection
