<template>
    <div class="m-4">
        <div class="container anchoStandar">
            <div class="row">
                <div class="col-lg-12 mb-1">
                    <checkbox-component
                        ref="exiteCliente"
                        :required="false"
                        v-model="exiteCliente"
                        @model="updateExiteCliente"
                    ></checkbox-component>
                    <label class="form-check-label" for="checkCliente">
                        Cliente existe?
                    </label>
                </div>
                <div class="col-lg-12 mb-1" v-if="exiteCliente">
                    <label for="cliente" class="form-label">Clientes *</label>
                    <select-component
                        :required="true"
                        :predeterminado="{ text: 'Seleccione una opción', value: '' }"
                        :options="[
                            { text: 'Cedula de ciudadania', value: 'CC' },
                            { text: 'Tarjeta de identidad', value: 'TI' },
                        ]"
                        :value="cliente"
                        @model="updateCliente"
                    ></select-component>
                </div>
                <div class="col-lg-6 mb-1" v-if="!exiteCliente">
                    <label for="nombreYapellido" class="form-label">Nombre Y Apellido *</label>
                    <input-component
                        :type="'text'"
                        :minlength="1"
                        :maxlength="50"
                        :required="true"
                        :placeholder="'Nombre Y Apellido del Cliente'"
                        :value="nombreYapellido"
                        @model="updateNombreYapellido"
                    ></input-component>
                </div>
                <div class="col-lg-6 mb-1" v-if="!exiteCliente">
                    <label for="documento" class="form-label">Documento</label>
                    <input-component
                        :type="'number'"
                        :minlength="1"
                        :maxlength="50"
                        :min="'1'"
                        :max="'999999999999'"
                        :required="false"
                        :placeholder="'Documento del Cliente'"
                        :value="documento"
                        @model="updateDocumento"
                    ></input-component>
                </div>
                <div class="col-lg-12 mb-1" v-if="!exiteCliente">
                    <label for="equipo" class="form-label">Equipo</label>
                    <select-component
                        :required="false"
                        :predeterminado="{ text: 'Seleccione una opción', value: '' }"
                        :options="[
                            { text: 'Cedula de ciudadania', value: 'CC' },
                            { text: 'Tarjeta de identidad', value: 'TI' },
                        ]"
                        :value="equipo"
                        @model="updateEquipo"
                    ></select-component>
                </div>
                <div class="col-lg-12 mb-1">
                    <label for="selectHora" class="form-label">Hora *</label>
                    <select-component
                        ref="selectHora"
                        :id="'selectHora'"
                        :required="true"
                        :predeterminado="{ text: 'Seleccione una opción', value: '' }"
                        :options="[
                            { text: 'Cedula de ciudadania', value: 'CC' },
                            { text: 'Tarjeta de identidad', value: 'TI' },
                        ]"
                        :value="selectHora"
                        @model="updateSelectHora"
                    ></select-component>
                </div>
                <div class="col-lg-12 mb-1">
                    <input class="form-check-input" type="checkbox" value="" id="fechaDefault" v-model="fechaDefault">
                    <label class="form-check-label" for="fechaDefault">
                        Fecha default
                    </label>
                </div>
                <div class="col-lg-12 mb-1" v-if="!fechaDefault">
                    <label for="fechaInicio" class="form-label">Fecha Y hora de inicio *</label>
                    <input-component
                        :type="'datetime-local'"
                        :min="'2018-06-07T00:00'"
                        :max="'2018-06-14T00:00'"
                        :required="true"
                        :placeholder="'fecha y hora de inicio'"
                        :value="fechaInicio"
                        @model="updateFechaInicio"
                    ></input-component>
                </div>
                <div class="col-lg-12 mb-1">
                    <input class="form-check-input" type="checkbox" value="" id="pago" v-model="pago">
                    <label class="form-check-label" for="pago">
                        Pago?
                    </label>
                </div>
                <div class="col-lg-12 mb-1 ms-3" v-if="pago">
                    <radio-component
                        :radios="[
                            {
                                value: 'efectivo',
                                checked: true,
                                label: 'Efectivo'
                            },
                            {
                                value: 'digital',
                                checked: false,
                                label: 'Digital'
                            }
                        ]"
                        :required="false"
                        :value="'efectivo'"
                        :name="'tipoPago'"
                        v-model="tipoPago"
                        @model="updateTipoPago"
                    ></radio-component>
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
import inputp from "../components/controls/input.vue";
import selectp from "../components/controls/select.vue";
import checkboxp from "../components/controls/checkbox.vue";
import radiop from "../components/controls/radio.vue";
export default {
    name: 'ligas',
    components: {
        "input-component": inputp,
        "select-component": selectp,
        "checkbox-component": checkboxp,
        "radio-component": radiop,
    },
    data() {
        return {
            exiteCliente: true,
            fechaDefault: true,
            pago: true,
            total: 0,
            nombreYapellido: '',
            documento: '',
            fechaInicio: '',
            cliente: '',
            equipo: '',
            tipoPago: 'efectivo'
        }
    },
    methods: {
        agregarLiga() {
            console.log('agregarLiga', [
                this.exiteCliente,
                this.fechaDefault,
                this.pago,
                this.total,
                this.nombreYapellido,
                this.documento,
                this.fechaInicio,
                this.cliente,
                this.equipo,
                this.tipoPago,
            ]);
        },
        updateExiteCliente(value) {
            this.exiteCliente = value;
        },
        updateNombreYapellido(value) {
            this.nombreYapellido = value;
        },
        updateDocumento(value) {
            this.documento = value;
        },
        updateFechaInicio(value) {
            this.fechaInicio = value;
        },
        updateCliente(value) {
            this.cliente = value;
        },
        updateEquipo(value) {
            this.equipo = value;
        },
        updateTipoPago(value) {
            this.tipoPago = value;
        },
    },
};
</script>

