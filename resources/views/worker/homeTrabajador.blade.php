@extends('layout.layout-generalSidebarTrabajador', $arrayConfig)

@section('title', 'Bienvenido Trabajador')

@section('contenedor')

    <div class="m-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 mb-1">
                    <div class="d-grid gap-2">
                        <a class="btn btn-light">
                            <i class="bi bi-alarm"></i>&nbsp;Ligas
                        </a>
                    </div>
                </div>
                <div class="col-lg-12 mb-1">
                    <div class="d-grid gap-2">
                        <a class="btn btn-light" >
                            <i class="bi bi-shop"></i>&nbsp;Tienda
                        </a>
                    </div>
                </div>
                <div class="col-lg-12 mb-1">
                    <div class="d-grid gap-2">
                        <a class="btn btn-light" >
                            <i class="bi bi-dash"></i>&nbsp;Descuento
                        </a>
                    </div>
                </div>
                <div class="col-lg-12 mb-1">
                    <div class="d-grid gap-2">
                        <a class="btn btn-light" >
                            <i class="bi bi-currency-dollar"></i>&nbsp;Pagos
                        </a>
                    </div>
                </div>
                <div class="col-lg-12 mb-1">
                    <div class="d-grid gap-2">
                        <a class="btn btn-light disabled">
                            <i class="bi bi-currency-dollar"></i>&nbsp;Caja
                        </a>
                    </div>
                </div>
                <div class="col-lg-12 mb-1">
                    <div class="d-grid gap-2">
                        <a class="btn btn-light" >
                            <i class="bi bi-people"></i>&nbsp;Equipos
                        </a>
                    </div>
                </div>
                <div class="col-lg-12 mb-1">
                    <div class="d-grid gap-2">
                        <a class="btn btn-light" >
                            <i class="bi bi-basket"></i>&nbsp;Productos
                        </a>
                    </div>
                </div>
                <div class="col-lg-12 mb-1">
                    <div class="d-grid gap-2">
                        <a class="btn btn-light" >
                            <i class="bi bi-clock-history"></i>&nbsp;Tarifas liga
                        </a>
                    </div>
                </div>
                <div class="col-lg-12 mb-1">
                    <div class="d-grid gap-2">
                        <a class="btn btn-light" >
                            <i class="bi bi-file-earmark-person"></i>&nbsp;Trabajador
                        </a>
                    </div>
                </div>
                <div class="col-lg-12 mb-1">
                    <div class="d-grid gap-2">
                        <a class="btn btn-light" >
                            <i class="bi bi-gear"></i>&nbsp;Configuración
                        </a>
                    </div>
                </div>
                <div class="col-lg-12 mb-1">
                    <div class="d-grid gap-2">
                        <a class="btn btn-danger" >
                            <i class="bi bi-door-open-fill"></i>&nbsp;Salir
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
