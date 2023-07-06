@extends('errors.layout')

@section('title', 'Servicio de página no disponible')

@section('content')
<div class="container container p-4 bg-dark" style="border-radius: 0px 0px 5px 5px;">
    <div class="row">
        <div class="col-lg-12">
            <img src="img/error.svg" alt="Nocarga"
                style="width: 291px; display: block; margin: auto;">
        </div>
        <div class="col-lg-12">
            <h1 class="text-white" style="text-align: center; font-size: calc(4.375rem + 1.5vw);">503</h1>
        </div>
        <div class="col-lg-12">
            <h1 class="text-white" style="text-align: center;">Page Service Unavailable</h1>
        </div>
        <div class="col-lg-12">
            <a class="btn btn-secondary btn-lg" href="/">Ir al Home</a>
        </div>
    </div>
</div>
@endsection
