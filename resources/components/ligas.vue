<template>
    <div class="m-4">
        <div class="container anchoStandar">
            <div class="row">
                <div class="col-lg-12 mb-1">
                    <input class="form-check-input" type="checkbox" value="" id="checkCliente" v-model="exiteCliente">
                    <label class="form-check-label" for="checkCliente">
                        Cliente existe?
                    </label>
                </div>
                <div class="col-lg-12 mb-1" v-if="exiteCliente">
                    <label for="cliente" class="form-label">Clientes *</label>
                    <select id="cliente" class="form-select" required>
                        <option selected value="">Seleccione una opción</option>
                    </select>
                </div>
                <div class="col-lg-6 mb-1" v-if="!exiteCliente">
                    <label for="nombreYapellido" class="form-label">Nombre Y Apellido *</label>
                    <input type="text" class="form-control" id="nombreYapellido" placeholder="Nombre Y Apellido del Cliente"
                        title="Nombre Y Apellido del Cliente" required minlength="1" maxlength="50">
                </div>
                <div class="col-lg-6 mb-1" v-if="!exiteCliente">
                    <label for="documento" class="form-label">Documento</label>
                    <input type="number" class="form-control" id="documento" placeholder="Documento del Cliente"
                        title="Documento del Cliente" min="1" max="999999999999">
                </div>
                <div class="col-lg-12 mb-1" v-if="!exiteCliente">
                    <label for="equipo" class="form-label">Equipo</label>
                    <select id="equipo" class="form-select">
                        <option selected value="">Seleccione una opción</option>
                    </select>
                </div>
                <div class="col-lg-12 mb-1">
                    <label for="selectHora" class="form-label">Hora *</label>
                    <select id="selectHora" class="form-select" required>
                        <option selected value="">Seleccione una opción</option>
                    </select>
                </div>
                <div class="col-lg-12 mb-1">
                    <input class="form-check-input" type="checkbox" value="" id="fechaDefault" v-model="fechaDefault">
                    <label class="form-check-label" for="fechaDefault">
                        Fecha default
                    </label>
                </div>
                <div class="col-lg-12 mb-1" v-if="!fechaDefault">
                    <label for="fechaInicio" class="form-label">Fecha Y hora de inicio *</label>
                    <input type="datetime-local" class="form-control" id="fechaInicio" placeholder="fecha y hora de inicio"
                        required>
                </div>
                <div class="col-lg-12 mb-1">
                    <input class="form-check-input" type="checkbox" value="" id="pago" v-model="pago">
                    <label class="form-check-label" for="pago">
                        Pago?
                    </label>
                </div>
                <div class="col-lg-12 mb-1 ms-3" v-if="pago">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="tipoPago" id="efectivo" value="efectivo" checked>
                        <label class="form-check-label" for="efectivo">
                            Efectivo
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="tipoPago" id="digital" value="digital">
                        <label class="form-check-label" for="digital">
                            Digital
                        </label>
                    </div>
                </div>
                <hr>
                <div class="col-lg-12 mb-1">
                    <label class="form-label">Total: {{ total }}</label>
                </div>
                <div class="col-lg-12 mb-1">
                    <div class="d-grid gap-2">
                        <button @click="agregarLiga" class="btn btn-primary" type="button">
                            <i class="bi bi-alarm"></i>&nbsp;Agregar Liga
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: 'ligas',
    data() {
        return {
            exiteCliente: true,
            fechaDefault: true,
            pago: true,
            total: 0
        }
    },
    methods: {
        agregarLiga() {
            console.log('escucho');
        }
    },
};
</script>

