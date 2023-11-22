<template>
    <div class="m-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 mb-1">
                    <label for="cliente" class="form-label">Cliente{{ required.cliente ? '*' : '' }}</label>
                    <select class="form-select" id="cliente" :required="required.cliente" ref="cliente" v-model="campos.cliente" :disabled="disabled.cliente">
                        <option value="" selected>{{ textSelectGeneral }}</option>
                        <option v-for="(option, index) in optionsCliente" :value="option.value" :key="index">
                            {{ option.text }}
                        </option>
                    </select>
                    <div id="clienteError" v-show="msgError.cliente" class="form-text text-danger text-center"><small>{{ msgError.cliente }}</small></div>
                </div>
                <div class="col-lg-12 mb-1">
                    <label for="selectHora" class="form-label">Hora{{ required.selectHora ? '*' : '' }}</label>
                    <select class="form-select" id="selectHora" :required="required.selectHora" ref="selectHora" v-model="campos.selectHora" :disabled="disabled.selectHora">
                        <option value="" selected>{{ textSelectGeneral }}</option>
                        <option v-for="(option, index) in optionsSelectHora" :value="option.value" :key="index" :precio="option.precio">
                            {{ option.text }}
                        </option>
                    </select>
                    <div id="selectHoraError" v-show="msgError.selectHora" class="form-text text-danger text-center"><small>{{ msgError.selectHora }}</small></div>
                </div>
                <div class="col-lg-12 mt-2">
                    <input type="checkbox" class="form-check-input" id="fechaDefault" ref="fechaDefault" v-model="fechaDefault" @click="cambiarEstadoFechaDefault">
                    <label class="form-check-label" for="fechaDefault">fechaDefault</label>
                </div>
                <div class="col-lg-12 mb-1" v-if="!fechaDefault">
                    <label for="fechaInicio" class="form-label">Fecha Y hora de inicio{{ required.fechaInicio ? '*' : '' }}</label>
                    <input type="datetime-local" class="form-control" id="fechaInicio" :required="required.fechaInicio" min="1" max="1000000" ref="fechaInicio" v-model="campos.fechaInicio" :disabled="disabled.fechaInicio">
                    <div id="fechaInicioError" v-show="msgError.fechaInicio" class="form-text text-danger text-center"><small>{{ msgError.fechaInicio }}</small></div>
                </div>
                <div class="col-lg-12 mt-2">
                    <input type="checkbox" class="form-check-input" id="pago" ref="pago" v-model="pago" @click="cambiarEstadoPago">
                    <label class="form-check-label" for="pago">Pago?</label>
                </div>
                <div class="col-lg-12 mb-1 ms-3" v-if="pago">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="tipoPago" id="efectivo" checked value="efectivo">
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
                    <span class="form-label p-2">Total: {{ total }}</span>
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
import { ApiService } from "../../services/services.js";
import { Methods } from "../../services/methods.js";
import modalp from "../../components/controls/modal.vue";
export default {
    name: 'ligasTrabajador',
    components: {
        "modal-component": modalp,
    },
    async mounted() {
        await this.cargarSelects();
    },
    data() {
        return {
            textSelectGeneral: 'escoja una opcion',
            fechaDefault: true,
            pago: true,
            btnDisabledAgregarLiga: false,
            total: 0,

            required: {
                cliente: true,
                selectHora: true,
                fechaInicio: true
            },

            campos: {
                cliente: '',
                selectHora: '',
                fechaInicio: '',
                tipoPago: '',
            },

            disabled: {
                cliente: false,
                selectHora: false,
                fechaInicio: false,
            },

            msgError: {
                cliente: '',
                selectHora: '',
                fechaInicio: '',
            },


            optionsCliente: [],
            optionsSelectHora: [],
        }
    },
    methods: {
        async cargarSelects() {
            await this.selectCliente();
            await this.selectTarifaHora();
        },
        cambiarEstadoFechaDefault() {
            this.fechaDefault = !this.fechaDefault;
        },
        cambiarEstadoPago() {
            this.pago = !this.pago;
        },
        async selectCliente() {
            let data = await ApiService.post('cargarClientesSelect', {});
            this.optionsCliente = data.map(function(cliente) {
                return { text: cliente.id +' - '+ cliente.nombresYapellidos, value: cliente.id}
            });
        },
        async selectTarifaHora() {
            let data = await ApiService.post('cargarSelectHora', {});
            this.optionsSelectHora = data.map(function(selectHora) {
                return { text: selectHora.id +' - '+ selectHora.nombre, value: selectHora.id, precio: selectHora.precio}
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
            /*let array = []
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
                    }else if (rdta.error) {
                        this.msgError = 'Errores encontrados:\n';
                        rdta.error.forEach(e => {
                            this.msgError += e + '\n';
                        });
                        this.$refs.modalError.show();
                    } else {
                        this.msgError = 'Error desconocido';
                        this.$refs.modalError.show();
                    }
                }
            }else{
                console.log(validCampos, 'resedwin');
            }*/
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

