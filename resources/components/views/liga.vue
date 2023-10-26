<template>
    <div class="m-4">
        <div class="container">
            <div class="row">
                <div class="d-grid gap-2 col-lg-3 mb-1">
                    <button type="button" class="btn btn-primary" @click="agregarLiga">Agregar</button>
                </div>
                <div class="col-lg-3 mb-1">
                    <select class="form-select" id="mostrar" v-model="mostrar" @change="mostrarChange">
                        <option v-for="(option, index) in optionsMostrar" :value="option.value" :key="index">
                            {{ option.text }}
                        </option>
                    </select>
                </div>
                <div class="col-lg-3 mb-1">
                    <div class="input-group">
                        <input class="form-control" type="search" placeholder="Buscar - enter" @search="buscar" id="buscarInTable" v-model="buscarInTable">
                    </div>
                </div>
                <div class="col-lg-3 mb-1">
                    exportar
                </div>
            </div>
            <div class="tableLiga">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Total</th>
                            <th scope="col">Tipo Pago</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Acción</th>
                        </tr>
                    </thead>
                    <tbody id="contenidoLiga">
                        <tr>
                            <th scope="row">1</th>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                            <td>
                                <i class="bi bi-eye-fill ms-1" @click="verLiga"></i>
                                <i class="bi bi-pencil-fill ms-1" @click="editatLiga"></i>
                                <i class="bi bi-x-lg ms-1" @click="eliminarLiga"></i>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <modal-component
                ref="modalLiga"
                :titulo="tutiloModal"
                :visibleBtnCerrar="true"
                :visibleBtnContinuar="btnContinuar"
                @cerrar="modalCerrar"
                @continuar="modalContinuar"
            >
                <div class="row">
                    <div class="col-lg-6 mb-1">
                        <label for="total" class="form-label">Total</label>
                        <input type="number" class="form-control" id="total" min="100" max="9999999999" ref="total" v-model="campos.total" :disabled="disabled.total">
                        <div id="totalError" v-show="msgError.total" class="form-text text-danger">{{ msgError.total }}</div>
                    </div>
                    <div class="col-lg-6 mb-1">
                        <label for="tipoPago" class="form-label">Tipo Pago</label>
                        <input type="text" class="form-control" id="tipoPago" minlength="1" maxlength="50" ref="tipoPago" v-model="campos.tipoPago" :disabled="disabled.tipoPago">
                        <div id="tipoPagoError" v-show="msgError.tipoPago" class="form-text text-danger">{{ msgError.tipoPago }}</div>
                    </div>
                    <div class="col-lg-6 mb-1">
                        <label for="fechaInicio" class="form-label">Fecha Inicio</label>
                        <input type="datetime-local" class="form-control" id="fechaInicio" ref="fechaInicio" v-model="campos.fechaInicio" :disabled="disabled.fechaInicio">
                        <div id="fechaInicioError" v-show="msgError.fechaInicio" class="form-text text-danger">{{ msgError.fechaInicio }}</div>
                    </div>
                    <div class="col-lg-6 mb-1">
                        <label for="fechaFin" class="form-label">Fecha Fin</label>
                        <input type="datetime-local" class="form-control" id="fechaFin" ref="fechaFin" v-model="campos.fechaFin" :disabled="disabled.fechaFin">
                        <div id="fechaFinError" v-show="msgError.fechaFin" class="form-text text-danger">{{ msgError.fechaFin }}</div>
                    </div>
                    <div class="col-lg-6 mb-1">
                        <label for="idGimnasio" class="form-label">IdGimnasio</label>
                        <select class="form-select" id="idGimnasio" ref="idGimnasio" v-model="campos.idGimnasio" :disabled="disabled.idGimnasio">
                            <option value="" selected>{{ textSelectGeneral }}</option>
                            <option v-for="(option, index) in optionsIdGimnasio" :value="option.value" :key="index">
                                {{ option.text }}
                            </option>
                        </select>
                        <div id="idGimnasioError" v-show="msgError.idGimnasio" class="form-text text-danger">{{ msgError.idGimnasio }}</div>
                    </div>
                    <div class="col-lg-6 mb-1">
                        <label for="idTrabajado" class="form-label">IdTrabajado</label>
                        <select class="form-select" id="idTrabajado" ref="idTrabajado" v-model="campos.idTrabajado" :disabled="disabled.idTrabajado">
                            <option value="" selected>{{ textSelectGeneral }}</option>
                            <option v-for="(option, index) in optionsIdTrabajado" :value="option.value" :key="index">
                                {{ option.text }}
                            </option>
                        </select>
                        <div id="idTrabajadoError" v-show="msgError.idTrabajado" class="form-text text-danger">{{ msgError.idTrabajado }}</div>
                    </div>
                    <div class="col-lg-6 mb-1">
                        <label for="idCliente" class="form-label">IdCliente</label>
                        <select class="form-select" id="idCliente" ref="idCliente" v-model="campos.idCliente" :disabled="disabled.idCliente">
                            <option value="" selected>{{ textSelectGeneral }}</option>
                            <option v-for="(option, index) in optionsIdCliente" :value="option.value" :key="index">
                                {{ option.text }}
                            </option>
                        </select>
                        <div id="idClienteError" v-show="msgError.idCliente" class="form-text text-danger">{{ msgError.idCliente }}</div>
                    </div>
                    <div class="col-lg-6 mt-2">
                        <input type="checkbox" class="form-check-input" id="estado" ref="estado" v-model="campos.estado" :disabled="disabled.estado">
                        <label class="form-check-label" for="estado">Estado</label>
                        <div id="estadoError" v-show="msgError.estado" class="form-text text-danger">{{ msgError.estado }}</div>
                    </div>
                </div>
            </modal-component>
        </div>
    </div>

</template>
<script>
import modal from "../../components/controls/modal.vue";

export default {
    name: 'Ligas',
    components: {
        "modal-component": modal,
    },
    mounted() {
        //llenarselects
    },
    data() {
        return {
            textSelectGeneral: 'escoja una opcion',
            mostrar: 10,
            optionsMostrar: [
                {text: '10', value: 10},
                {text: '20', value: 20},
                {text: '30', value: 30},
            ],
            buscarInTable: '',
            tutiloModal: '',
            editando: false,
            creando: false,
            viendo: false,
            btnContinuar: true,

            campos: {
                total: '',
                tipoPago: '',
                fechaInicio: '',
                fechaFin: '',
                estado: '',
                idGimnasio: '',
                idTrabajado: '',
                idCliente: '',
            },

            disabled: {
                total: false,
                tipoPago: false,
                fechaInicio: false,
                fechaFin: false,
                estado: false,
                idGimnasio: false,
                idTrabajado: false,
                idCliente: false,
            },

            msgError: {
                total: '',
                tipoPago: '',
                fechaInicio: '',
                fechaFin: '',
                estado: '',
                idGimnasio: '',
                idTrabajado: '',
                idCliente: '',
            },

            optionsIdGimnasio:[
                {text: 'text', value: 1}
            ],

            optionsIdEquipo:[
                {text: 'text', value: 1}
            ],
        }
    },
    methods: {
        modalCerrar() {
            this.$refs.modalLiga.hide();
        },
        modalContinuar() {
            this.$refs.modalLiga.hide();
        },
        buscar(e) {
            console.log(e, 'escucho');
        },
        agregarLiga() {
            this.desbloquearCampos()
            this.btnContinuar = true;

            this.editando = false;
            this.creando = true;
            this.viendo = false;

            this.tutiloModal = 'Agregar Liga'
            this.$refs.modalLiga.show();
        },
        editatLiga() {
            this.desbloquearCampos()
            this.btnContinuar = true;

            this.editando = true;
            this.creando = false;
            this.viendo = false;

            this.tutiloModal = 'Actualizar Liga'
            this.$refs.modalLiga.show();
        },
        verLiga() {
            this.bloquearCampos()
            this.btnContinuar = false;

            this.editando = false;
            this.creando = false;
            this.viendo = true;

            this.tutiloModal = 'ver Liga'
            this.$refs.modalLiga.show();
        },
        eliminarLiga() {
            console.log('eliminar');
        },
        bloquearCampos() {
            this.disabled.total = true;
            this.disabled.tipoPago = true;
            this.disabled.fechaInicio = true;
            this.disabled.fechaFin = true;
            this.disabled.idGimnasio = true;
            this.disabled.idTrabajado = true;
            this.disabled.idCliente = true;
            this.disabled.estado = true;
        },
        desbloquearCampos() {
            this.disabled.total = false;
            this.disabled.tipoPago = false;
            this.disabled.fechaInicio = false;
            this.disabled.fechaFin = false;
            this.disabled.idGimnasio = false;
            this.disabled.idTrabajado = false;
            this.disabled.idCliente = false;
            this.disabled.estado = false;
        },
        mostrarChange() {
            console.log('escucho');
        }
    },
};
</script>
<style scoped>

</style>
<style>

</style>
