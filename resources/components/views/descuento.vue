<template>
    <div class="m-4">
        <div class="container">
            <div class="row">
                <div class="d-grid gap-2 col-lg-3 mb-1">
                    <button type="button" class="btn btn-primary" @click="agregarDescuento">Agregar</button>
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
            <div class="tableDescuento">
                <table-component
                    ref="tableDescuento"
                    :url="'cargarDescuentos'"
                    :cabecera="{
                        id: {
                            text: '#',
                            type: 'text'
                        },
                        titulo: {
                            text: 'Título',
                            type: 'text'
                        },
                        descripcion: {
                            text: 'Descripción',
                            type: 'text-large'
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
                    @ver="verDescuento"
                    @editar="editatDescuento"
                    @eliminar="eliminarDescuento"
                >
                </table-component>
            </div>
            <modal-component
                ref="modalDescuento"
                :titulo="tutiloModal"
                :visibleBtnCerrar="true"
                :visibleBtnContinuar="btnContinuar"
                @cerrar="modalCerrar"
                @continuar="modalContinuar"
            >
                <div class="row">
                    <div class="col-lg-6 mb-1">
                        <label for="titulo" class="form-label">Título</label>
                        <input type="text" class="form-control" id="titulo" ref="titulo" v-model="campos.titulo" :disabled="disabled.titulo">
                        <div id="tituloError" v-show="msgError.titulo" class="form-text text-danger">{{ msgError.titulo }}</div>
                    </div>
                    <div class="col-lg-6 mb-1">
                        <label for="total" class="form-label">Total</label>
                        <input type="number" class="form-control" id="total"  ref="total" v-model="campos.total" :disabled="disabled.total">
                        <div id="totalError" v-show="msgError.total" class="form-text text-danger">{{ msgError.total }}</div>
                    </div>
                    <div class="col-lg-6 mb-1">
                        <label for="fecha" class="form-label">fecha</label>
                        <input type="datetime-local" class="form-control" id="fecha"  ref="fecha" v-model="campos.fecha" :disabled="disabled.fecha">
                        <div id="fechaError" v-show="msgError.fecha" class="form-text text-danger">{{ msgError.fecha }}</div>
                    </div>
                    <div class="col-lg-6 mb-1">
                        <label for="idGimnasio" class="form-label">idGimnasio</label>
                        <select class="form-select" id="idGimnasio" ref="idGimnasio" v-model="campos.idGimnasio" :disabled="disabled.idGimnasio">
                            <option value="" selected>{{ textSelectGeneral }}</option>
                            <option v-for="(option, index) in optionsIdGimnasio" :value="option.value" :key="index">
                                {{ option.text }}
                            </option>
                        </select>
                        <div id="idGimnasioError" v-show="msgError.idGimnasio" class="form-text text-danger">{{ msgError.idGimnasio }}</div>
                    </div>
                    <div class="col-lg-6 mb-1">
                        <label for="idTrabajado" class="form-label">idTrabajado</label>
                        <select class="form-select" id="idTrabajado" ref="idTrabajado" v-model="campos.idTrabajado" :disabled="disabled.idTrabajado">
                            <option value="" selected>{{ textSelectGeneral }}</option>
                            <option v-for="(option, index) in optionsIdTrabajado" :value="option.value" :key="index">
                                {{ option.text }}
                            </option>
                        </select>
                        <div id="idTrabajadoError" v-show="msgError.idTrabajado" class="form-text text-danger">{{ msgError.idTrabajado }}</div>
                    </div>
                    <div class="col-lg-6 mb-1">
                        <label for="idTrabajador" class="form-label">idTrabajador</label>
                        <select class="form-select" id="idTrabajador" ref="idTrabajador" v-model="campos.idTrabajador" :disabled="disabled.idTrabajador">
                            <option value="" selected>{{ textSelectGeneral }}</option>
                            <option v-for="(option, index) in optionsIdTrabajador" :value="option.value" :key="index">
                                {{ option.text }}
                            </option>
                        </select>
                        <div id="idTrabajadorError" v-show="msgError.idTrabajador" class="form-text text-danger">{{ msgError.idTrabajador }}</div>
                    </div>
                    <div class="col-lg-12 mb-1">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" id="descripcion" rows="3" ref="descripcion" v-model="campos.descripcion" :disabled="disabled.descripcion"></textarea>
                        <div id="descripcionError" v-show="msgError.descripcion" class="form-text text-danger">{{ msgError.descripcion }}</div>
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
    name: 'Descuentos',
    components: {
        "modal-component": modal,
        "table-component": table,
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
            btnContinuar: true,
            titleModalSuccess: '',
            msgModalSuccess: '',

            campos: {
                titulo: '',
                total: '',
                fecha: '',
                idGimnasio: '',
                idTrabajado: '',
                idTrabajador: '',
                descripcion: '',
                estado: '',
            },

            disabled: {
                titulo: false,
                total: false,
                fecha: false,
                idGimnasio: false,
                idTrabajado: false,
                idTrabajador: false,
                descripcion: false,
                estado: false,
            },

            msgError: {
                titulo: '',
                total: '',
                fecha: '',
                idGimnasio: '',
                idTrabajado: '',
                idTrabajador: '',
                descripcion: '',
                estado: '',
            },

            optionsIdGimnasio: [],

            optionsIdTrabajado:[],

            optionsIdTrabajador:[],
        }
    },
    async mounted() {
        await this.cargarSelects();
    },
    methods: {
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
        async llenarSelectIdTrabajador() {
            let datos =  await cargarDatos('cargarTrabajadorSelect');
            this.optionsIdTrabajador = datos.map(function(btn) {
                return {text: btn.nickname, value: btn.id};
            });
        },
        async modalContinuar() {
            //this.$refs.modalDescuento.hide();
            //campos que no son requridos
            let noRequired = [
                'descripcion'
            ];
            for (const i in this.campos) {
                console.log(noRequired.indexOf(i));
                if (!this.campos[i] && noRequired.indexOf(i) < 0) {
                    console.log('no tiene valor el campo ' + i);
                    this.$refs[i].focus();
                    this.msgError[i] = 'El campo no puede estar vacío';

                    return;
                }else {
                    //validar los parametros de restriccion que se ponen en los atributos
                    this.msgError[i] = '';
                }
            }
            console.log('campos', this.campos);
            if (this.editando == true) {
                let datos = await enviarData('editarDescuento', this.campos);
                console.log('editar', datos);
            } else if (this.creando == true) {
                let datos = await enviarData('crearDescuento', this.campos);
                console.log('crear', datos);
                if(datos == true) {
                    this.titleModalSuccess = 'Exito'
                    this.msgModalSuccess = 'se creo el descuento con exito'
                    this.$refs.modalSuccess.show();
                }else{
                    this.titleModalSuccess = 'Error'
                    this.msgModalSuccess = 'error inesperado'
                    this.$refs.modalSuccess.show();
                }
            }
        },
        async agregarDescuento() {
            this.desbloquearCampos()
            this.btnContinuar = true;

            this.editando = false;
            this.creando = true;

            this.vaciarCampos();

            this.tutiloModal = 'Agregar Descuento'
            this.$refs.modalDescuento.show();
        },
        async cargarSelects() {
            await this.llenarSelectIdGimnasio();
            await this.llenarSelectIdTrabajado();
            await this.llenarSelectIdTrabajador();
        },
        async editatDescuento(index, id) {
            this.$refs.tableDescuento.cargando = true;

            await this.cargarSelects();

            this.desbloquearCampos()

            this.btnContinuar = true;

            this.editando = true;
            this.creando = false;

            this.llenarCampos(index);

            this.tutiloModal = 'Actualizar Descuento '+ id
            this.$refs.modalDescuento.show();
            this.$refs.tableDescuento.cargando = false;
        },
        async verDescuento(index) {
            this.$refs.tableDescuento.cargando = true;

            await this.cargarSelects();

            this.bloquearCampos();

            this.btnContinuar = false;

            let datos = this.$refs.tableDescuento.datatable[index]

            this.campos.titulo = datos.titulo
            this.campos.total = datos.total
            this.campos.fecha = datos.fecha
            this.campos.idGimnasio = datos.idGimnasio
            this.campos.idTrabajado = datos.idTrabajado
            this.campos.idTrabajador = datos.idTrabajador
            this.campos.descripcion = datos.descripcion
            this.campos.estado = datos.estado == 1 ? true : false

            this.tutiloModal = 'ver Descuento'
            this.$refs.modalDescuento.show();
            this.$refs.tableDescuento.cargando = false;
        },
        continuarModalSuccess() {
            this.$refs.modalSuccess.hide();
            location.reload();
        },
        buscar(e) {
            console.log(e, 'escucho');
        },
        modalCerrar() {
            this.$refs.modalDescuento.hide();
        },
        vaciarCampos() {
            delete this.campos.id
            this.campos.titulo = ''
            this.campos.total = ''
            this.campos.fecha = ''
            this.campos.idGimnasio = ''
            this.campos.idTrabajado = ''
            this.campos.idTrabajador = ''
            this.campos.descripcion = ''
            this.campos.estado = ''
        },
        llenarCampos(index){
            let datos = this.$refs.tableDescuento.datatable[index]

            this.campos.id = datos.id
            this.campos.titulo = datos.titulo
            this.campos.total = datos.total
            this.campos.fecha = datos.fecha
            this.campos.idGimnasio = datos.idGimnasio
            this.campos.idTrabajado = datos.idTrabajado
            this.campos.idTrabajador = datos.idTrabajador
            this.campos.descripcion = datos.descripcion
            this.campos.estado = datos.estado == 1 ? true : false
        },
        eliminarDescuento(id) {
            console.log('eliminar', id);
            this.campos.id = id
            this.$refs.modalEliminar.show();
        },
        cerrarModalEliminar() {
            this.$refs.modalEliminar.hide();
        },
        async continuarModalEliminar() {
            this.$refs.modalEliminar.hide();
            let datos = await enviarData('eliminarDescuento', {id: this.campos.id});
            console.log(datos, 'eliminar');
        },
        bloquearCampos() {
            this.disabled.titulo = true;
            this.disabled.descripcion = true;
            this.disabled.total = true;
            this.disabled.fecha = true;
            this.disabled.idGimnasio = true;
            this.disabled.idTrabajado = true;
            this.disabled.idTrabajador = true;
            this.disabled.estado = true;
        },
        desbloquearCampos() {
            this.disabled.titulo = false;
            this.disabled.descripcion = false;
            this.disabled.total = false;
            this.disabled.fecha = false;
            this.disabled.idGimnasio = false;
            this.disabled.idTrabajado = false;
            this.disabled.idTrabajador = false;
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
