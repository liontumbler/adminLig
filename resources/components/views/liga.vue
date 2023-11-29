<template>
    <div class="m-4">
        <div class="container">
            <div class="row" v-if="c">
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
                <table-component
                    ref="tableLiga"
                    :title="'Liga'"
                    :url="'cargarLigas'"
                    :cabecera="{
                        id: {
                            text: '#',
                            type: 'text'
                        },
                        total: {
                            text: 'Total',
                            type: 'text'
                        },
                        tipoPago: {
                            text: 'Tipo Pago',
                            type: 'text'
                        },
                        estado: {
                            text: 'Estado',
                            type: 'estado'
                        },
                        accion: {
                            text: 'Acción',
                            type: 'accion'
                        },
                    }"
                    :r="r"
                    :u="u"
                    :d="d"
                    @ver="verLiga"
                    @editar="editatLiga"
                    @eliminar="eliminarLiga"
                >
                </table-component>
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
                            <option v-for="(option, index) in optionsCliente" :value="option.value" :key="index">
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
            <modal-component
                ref="modalEliminar"
                :titulo="'Eliminar'"
                :visibleBtnCerrar="true"
                :visibleBtnContinuar="true"
                @cerrar="cerrarModalEliminar"
                @continuar="continuarModalEliminar"
            >
                Seguro que desea borrar el descuento
            </modal-component>
            <modal-component
                ref="modalSuccess"
                :titulo="titleModalSuccess"
                :visibleBtnCerrar="false"
                :visibleBtnContinuar="true"
                @continuar="continuarModalSuccess"
            >
                {{ msgModalSuccess }}
            </modal-component>
        </div>
    </div>

</template>
<script>
import modal from "../../components/controls/modal.vue";
import table from "../../components/controls/table.vue";

import { cargarDatos, enviarData } from "../../services/servicesApi.js";

export default {
    name: 'Ligas',
    components: {
        "modal-component": modal,
        "table-component": table,
    },
    async mounted() {
        await this.cargarSelects();
    },
    props: {
        c: {
            type: Boolean,
            default: true,
        },
        r: {
            type: Boolean,
            default: true,
        },
        u: {
            type: Boolean,
            default: true,
        },
        d: {
            type: Boolean,
            default: true,
        }
    },
    data() {
        return {
            titleModalSuccess: '',
            msgModalSuccess: '',
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

            optionsCliente: [],
            optionsIdGimnasio: [],
            optionsIdTrabajado: []
        }
    },
    methods: {
        async llenarSelectCliente() {
            let data = await cargarDatos('cargarClientesSelect');
            this.optionsCliente = data.map(function(cliente) {
                return { text: cliente.id +' - '+ cliente.nombresYapellidos, value: cliente.id}
            });
        },
        async llenarSelectIdGimnasio() {
            let datos = await cargarDatos('cargarGimnasiosSelect');
            this.optionsIdGimnasio = datos.map(function(btn) {
                return {text: btn.nombre, value: btn.id};
            });
        },
        async llenarSelectIdTrabajado() {
            let datos =  await cargarDatos('cargarTrabajadoSelect');
            this.optionsIdTrabajado = datos.map(function(btn) {
                return {text: btn.iniciCaja, value: btn.id};
            });
        },
        async cargarSelects() {
            await this.llenarSelectCliente();
            await this.llenarSelectIdGimnasio();
            await this.llenarSelectIdTrabajado();
        },
        modalCerrar() {
            this.$refs.modalLiga.hide();
        },
        async modalContinuar() {
            this.limpiarErrores();

            let valido = this.validador.validarCampos();
            if (valido.msg) {
                this.msgError[valido.id] = valido.msg;
                return
            } else if (valido) {///'∞'
                console.log('campos', this.campos);
                if (this.editando == true) {
                    let datos = await enviarData('editarLiga', this.campos);
                    console.log('editar', datos);
                    if(datos == true) {
                        this.$refs.modalLiga.hide();
                        this.mostrarMsg('Exito', 'Se actualizo el descuento con exito');
                    }else{
                        this.mostrarMsg('Error', 'Error inesperado');
                    }
                } else if (this.creando == true) {
                    let datos = await enviarData('crearLiga', this.campos);
                    console.log('crear', datos);
                    if(datos == true) {
                        this.$refs.modalLiga.hide();
                        this.mostrarMsg('Exito', 'Se creo el descuento con exito');
                    }else{
                        this.mostrarMsg('Error', 'Error inesperado');
                    }
                }
            }
        },
        buscar(e) {
            console.log(e, 'escucho');
        },
        agregarLiga() {
            this.limpiarErrores();
            this.desbloquearCampos()
            this.vaciarCampos();

            this.fechaVisible = false;
            this.required.estado = true;
            this.btnContinuar = true;
            this.editando = false;
            this.creando = true;

            this.tituloModal = 'Agregar Liga';
            this.$refs.modalLiga.show();

            setTimeout(() => {
                this.validador = new Validador([
                    'total',
                    'tipoPago',
                    'fechaInicio',
                    'fechaFin',
                    'estado',
                    'idGimnasio',
                    'idTrabajado',
                    'idCliente',
                ])
            }, 10);
        },
        async editatLiga() {
            this.$refs.tableLiga.cargando = true;

            await this.cargarSelects();
            this.limpiarErrores();
            this.desbloquearCampos();
            this.llenarCampos(index);

            this.required.estado = false;
            this.btnContinuar = true;
            this.editando = true;
            this.creando = false;
            this.fechaVisible = false;

            this.tituloModal = 'Actualizar Liga '+ id
            this.$refs.modalLiga.show();

            this.$refs.tableLiga.cargando = false;

            setTimeout(() => {
                this.validador = new Validador([
                    'total',
                    'tipoPago',
                    'fechaInicio',
                    'fechaFin',
                    'estado',
                    'idGimnasio',
                    'idTrabajado',
                    'idCliente',
                ])
            }, 10);
        },
        async verLiga(index) {
            this.$refs.tableLiga.cargando = true;

            let datos = this.$refs.tableLiga.datatable[index]

            await this.cargarSelects();
            this.limpiarErrores();
            this.bloquearCampos();
            this.llenarCampos(datos);

            this.btnContinuar = false;
            this.fechaVisible = true;

            this.tituloModal = 'ver Liga'
            this.$refs.modalLiga.show();

            this.$refs.tableLiga.cargando = false;
        },
        eliminarLiga() {
            this.campos.id = id
            this.$refs.modalEliminar.show();
        },
        cerrarModalEliminar() {
            this.$refs.modalEliminar.hide();
        },
        async continuarModalEliminar() {
            this.$refs.modalEliminar.hide();
            let datos = await enviarData('eliminarLiga', {id: this.campos.id});
            console.log('elimino', datos);
            if(datos == true) {
                this.mostrarMsg('Exito', 'Se eliminó el descuento con exito');
            }else{
                this.mostrarMsg('Error', 'Error inesperado');
            }
        },
        mostrarMsg(title, msg) {
            this.titleModalSuccess = title;
            this.msgModalSuccess = msg;
            this.$refs.modalSuccess.show();
        },
        continuarModalSuccess() {
            this.$refs.modalSuccess.hide();
            this.$refs.tableLiga.cargarTabla()
        },
        bloquearCampos() {
            for (const i in this.disabled) {
                this.disabled[i] = true;
            }
        },
        desbloquearCampos() {
            for (const i in this.disabled) {
                this.disabled[i] = false;
            }
        },
        mostrarChange() {
            console.log('escucho');
        },
        llenarCampos(datos) {
            for (const i in this.campos) {
                if (datos[i]) {
                    if (i == 'estado') {
                        this.campos[i] = datos[i] == 1 ? true : false
                    } else {
                        this.campos[i] = datos[i];
                    }
                }
            }
        },
        limpiarErrores() {
            for (const i in this.msgError) {
                this.msgError[i] = '';
            }
        },
    },
};
</script>
<style scoped>

</style>
<style>

</style>
