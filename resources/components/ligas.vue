<template>
    <div class="m-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 mb-1">
                    <checkbox-component
                        ref="exiteCliente"
                        :id="'exiteCliente'"
                        :required="false"
                        v-model="exiteCliente"
                        @model="updateExiteCliente"
                    ></checkbox-component>
                    <label class="form-check-label" for="exiteCliente">
                        Cliente existe?
                    </label>
                </div>
                <div class="col-lg-12 mb-1" v-if="exiteCliente">
                    <label for="cliente" class="form-label">Clientes *</label>
                    <select-component
                        :id="'cliente'"
                        :required="true"
                        :predeterminado="{ text: 'Seleccione una opción', value: '' }"
                        :options="dataClientes"
                        ref="cliente"
                        :value="cliente"
                        @model="updateCliente"
                    ></select-component>
                </div>
                <div class="col-lg-6 mb-1" v-if="!exiteCliente">
                    <label for="nombreYapellido" class="form-label">Nombre Y Apellido *</label>
                    <input-component
                        :id="'nombreYapellido'"
                        :type="'text'"
                        :minlength="1"
                        :maxlength="50"
                        :required="true"
                        :placeholder="'Nombre Y Apellido del Cliente'"
                        ref="nombreYapellido"
                        :value="nombreYapellido"
                        @model="updateNombreYapellido"
                    ></input-component>
                </div>
                <div class="col-lg-6 mb-1" v-if="!exiteCliente">
                    <label for="documento" class="form-label">Documento</label>
                    <input-component
                        :id="'documento'"
                        :type="'number'"
                        :minlength="1"
                        :maxlength="50"
                        :min="'1'"
                        :max="'999999999999'"
                        :required="false"
                        :placeholder="'Documento del Cliente'"
                        ref="documento"
                        :value="documento"
                        @model="updateDocumento"
                    ></input-component>
                </div>
                <div class="col-lg-12 mb-1" v-if="!exiteCliente">
                    <label for="equipo" class="form-label">Equipo</label>
                    <select-component
                        :id="'equipo'"
                        :required="false"
                        :predeterminado="{ text: 'Seleccione una opción', value: '' }"
                        :options="dataEquipos"
                        ref="equipo"
                        :value="equipo"
                        @model="updateEquipo"
                    ></select-component>
                </div>
                <div class="col-lg-12 mb-1">
                    <label for="selectHora" class="form-label">Hora *</label>
                    <select-component
                        :id="'selectHora'"
                        :required="true"
                        :predeterminado="{ text: 'Seleccione una opción', value: '' }"
                        :options="dataSelectHoras"
                        ref="selectHora"
                        :value="selectHora"
                        @model="updateSelectHora"
                    ></select-component>
                </div>
                <div class="col-lg-12 mb-1">
                    <checkbox-component
                        ref="fechaDefault"
                        :id="'fechaDefault'"
                        :required="false"
                        v-model="fechaDefault"
                        @model="updateFechaDefault"
                    ></checkbox-component>
                    <label class="form-check-label" for="fechaDefault">
                        Fecha default
                    </label>
                </div>
                <div class="col-lg-12 mb-1" v-if="!fechaDefault">
                    <label for="fechaInicio" class="form-label">Fecha Y hora de inicio *</label>
                    <input-component
                        :id="'fechaInicio'"
                        :type="'datetime-local'"
                        :min="fechaActualHoraCC()"
                        :max="ultimodiaFechaActualHoraCC()"
                        :required="true"
                        :placeholder="'fecha y hora de inicio'"
                        ref="fechaInicio"
                        :value="fechaInicio"
                        @model="updateFechaInicio"
                    ></input-component>
                </div>
                <div class="col-lg-12 mb-1">
                    <checkbox-component
                        ref="pago"
                        :id="'pago'"
                        :required="false"
                        v-model="pago"
                        @model="updatePago"
                    ></checkbox-component>
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
                        ref="tipoPago"
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
                        <button @click="agregarLiga" :disabled="btnDisabledAgregarLiga" class="btn btn-primary" type="button">
                            <i class="bi bi-alarm"></i>&nbsp;Agregar Liga
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <modal-component
        ref="modalConfirmar"
        :titulo="'Confirmación'"
        :visibleBtnCerrar="true"
        :visibleBtnContinuar="true"
        @cerrar="modalConfirmacion"
        @continuar="modalConfirmacion"
    >
        {{ msgConfirmacion }}
    </modal-component>
    <modal-component
        ref="modalError"
        :titulo="'Error'"
        :visibleBtnCerrar="true"
        :visibleBtnContinuar="true"
        @cerrar="modalError"
        @continuar="modalError"
    >
        {{ msgError }}
    </modal-component>
</template>
<script>
import { ApiService } from "../services/services.js";
import { Methods } from "../services/methods.js";
import inputp from "../components/controls/input.vue";
import selectp from "../components/controls/select.vue";
import checkboxp from "../components/controls/checkbox.vue";
import radiop from "../components/controls/radio.vue";
import modalp from "../components/controls/modal.vue";
export default {
    name: 'ligas',
    components: {
        "modal-component": modalp,
        "input-component": inputp,
        "select-component": selectp,
        "checkbox-component": checkboxp,
        "radio-component": radiop,
    },
    mounted() {
        this.selectCliente();
        this.selectEquipo();
        this.selectTarifaHora();
    },
    data() {
        return {
            exiteCliente: true,
            fechaDefault: true,
            pago: true,
            btnDisabledAgregarLiga: false,
            total: 0,
            nombreYapellido: '',
            documento: '',
            fechaInicio: '',
            cliente: '',
            equipo: '',
            tipoPago: 'efectivo',
            selectHora: '',
            dataClientes: [],
            dataEquipos: [],
            dataSelectHoras: [],
        }
    },
    methods: {
        async selectCliente() {
            let data = await ApiService.post('cargarClientesSelect', {});
            this.dataClientes = data.map(function(cliente) {
                return { text: cliente.id +' - '+ cliente.nombresYapellidos, value: cliente.id}
            });
        },
        async selectEquipo() {
            let data = await ApiService.post('cargarEquiposSelect', {});
            this.dataEquipos = data.map(function(equipo) {
                return { text: equipo.id +' - '+ equipo.nombre, value: equipo.id}
            });
        },
        async selectTarifaHora() {
            let data = await ApiService.post('cargarSelectHora', {});
            this.dataSelectHoras = data.map(function(selectHora) {
                return { text: selectHora.id +' - '+ selectHora.nombre, value: selectHora.id}
            });
        },
        fechaActualHoraCC() {
            var fechaActual = new Date();

            var year = fechaActual.getFullYear();
            var month = ('0' + (fechaActual.getMonth() + 1)).slice(-2);
            var day = ('0' + fechaActual.getDate()).slice(-2);

            return year + '-' + month + '-' + day + 'T00:00';
        },
        ultimodiaFechaActualHoraCC(){
            var fechaActual = new Date();
            var ultimoDiaMes = new Date(fechaActual.getFullYear(), fechaActual.getMonth() + 1, 0);

            var year = ultimoDiaMes.getFullYear();
            var month = ('0' + (ultimoDiaMes.getMonth() + 1)).slice(-2);
            var day = ('0' + ultimoDiaMes.getDate()).slice(-2);

            return year + '-' + month + '-' + day + 'T00:00';
        },
        async agregarLiga() {
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
                this.selectHora,
            ]);

            let array = []
            if(this.exiteCliente && this.pago && this.fechaDefault){
                array = ['cliente', 'selectHora', 'tipoPago']
            } else if(this.exiteCliente && !this.pago && this.fechaDefault){
                array = ['cliente', 'selectHora']
            } else if(!this.exiteCliente && !this.pago && this.fechaDefault){
                array = ['nombreYapellido', 'documento', 'equipo', 'selectHora']
            } else if(!this.exiteCliente && this.pago && this.fechaDefault){
                array = ['nombreYapellido', 'documento', 'equipo', 'selectHora', 'tipoPago']
            } else if(this.exiteCliente && !this.pago && !this.fechaDefault){
                array = ['cliente', 'selectHora', 'fechaInicio']
            } else if(!this.exiteCliente && !this.pago && !this.fechaDefault){
                array = ['nombreYapellido', 'documento', 'equipo', 'selectHora', 'fechaInicio']
            } else if(!this.exiteCliente && this.pago && !this.fechaDefault){
                array = ['nombreYapellido', 'documento', 'equipo', 'selectHora', 'tipoPago', 'fechaInicio']
            } else if(this.exiteCliente && this.pago && !this.fechaDefault){
                array = ['cliente', 'selectHora', 'tipoPago', 'fechaInicio']
            }

            let validCampos = await Methods.validarCampos(this, array);

            if (validCampos) {
                let data = await Methods.armardatos(this, array);

                console.log('b', data);
                this.btnDisabledAgregarLiga = true
                let rdta = await ApiService.post('crearLiga', data)
                this.btnDisabledAgregarLiga = false
                console.log(rdta);

                if (rdta == true) {
                    this.msgConfirmacion = 'Se insertó la liga';
                    this.$refs.modalConfirmar.show();
                }else{
                    if (rdta == './loginTrabajador') {
                        location.href = rdta
                    }else if (rdta == -1) {
                        //el usuario ya existe
                        this.msgError = 'El usuario ya existe';
                        this.$refs.modalError.show();
                    }else if (rdta == 601) {
                        //su plan llego al limite
                        this.msgError = 'Su plan llegó al límite';
                        this.$refs.modalError.show();
                    }else {
                        this.msgError = 'Error desconocido';
                        this.$refs.modalError.show();
                    }
                }
            }else{
                console.log(validCampos, 'resedwin');
            }
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
        updatePago(value) {
            this.pago = value;
        },
        updateFechaDefault(value) {
            this.fechaDefault = value;
        },
        updateSelectHora(value) {
            this.selectHora = value;
        },
        modalConfirmacion() {
            location.href = './ligas';
        },
        modalError() {
            this.$refs.modalError.hide();
        },
    },
};
</script>

