<template>
    <div class="m-4">
        <div class="container">
            <div class="row">
                <div class="d-grid gap-2 col-lg-3 mb-1">
                    <button type="button" class="btn btn-primary" @click="agregarDescuento">Agregar</button>
                </div>
                <div class="col-lg-3 mb-1">
                    <select class="form-select" id="mostrar" v-model="mostrar" @change="mostrarChange" v-if="false">
                        <option v-for="(option, index) in optionsMostrar" :value="option.value" :key="index">
                            {{ option.text }}
                        </option>
                    </select>
                </div>
                <div class="col-lg-3 mb-1">
                    <div class="input-group" v-if="false">
                        <input class="form-control" type="search" placeholder="Buscar - enter" @search="buscar" id="buscarInTable" v-model="buscarInTable">
                    </div>
                </div>
                <div class="col-lg-3 mb-1" v-if="false">
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
                    @editar="editarDescuento"
                    @eliminar="eliminarDescuento"
                >
                </table-component>
            </div>
            <modal-component
                ref="modalDescuento"
                :titulo="tituloModal"
                :visibleBtnCerrar="true"
                :visibleBtnContinuar="btnContinuar"
                @cerrar="modalCerrar"
                @continuar="modalContinuar"
            >
                <div class="row">
                    <div class="col-lg-6 mb-1">
                        <label for="titulo" class="form-label">Título</label>
                        <input type="text" class="form-control" id="titulo" required minlength="1" maxlength="50" ref="titulo" v-model="campos.titulo" :disabled="disabled.titulo">
                        <div id="tituloError" v-show="msgError.titulo" class="form-text text-danger">{{ msgError.titulo }}</div>
                    </div>
                    <div class="col-lg-6 mb-1">
                        <label for="total" class="form-label">Total</label>
                        <input type="numeric" class="form-control" id="total" required min="1" max="1000000" ref="total" v-model="campos.total" :disabled="disabled.total">
                        <div id="totalError" v-show="msgError.total" class="form-text text-danger">{{ msgError.total }}</div>
                    </div>
                    <div class="col-lg-6 mb-1" v-if="fechaVisible">
                        <label for="fecha" class="form-label">Fecha</label>
                        <input type="datetime-local" class="form-control" id="fecha" required ref="fecha" v-model="campos.fecha" :disabled="disabled.fecha">
                        <div id="fechaError" v-show="msgError.fecha" class="form-text text-danger">{{ msgError.fecha }}</div>
                    </div>
                    <div class="col-lg-6 mb-1">
                        <label for="idGimnasio" class="form-label">IdGimnasio</label>
                        <select class="form-select" id="idGimnasio" required ref="idGimnasio" v-model="campos.idGimnasio" :disabled="disabled.idGimnasio">
                            <option value="" selected>{{ textSelectGeneral }}</option>
                            <option v-for="(option, index) in optionsIdGimnasio" :value="option.value" :key="index">
                                {{ option.text }}
                            </option>
                        </select>
                        <div id="idGimnasioError" v-show="msgError.idGimnasio" class="form-text text-danger">{{ msgError.idGimnasio }}</div>
                    </div>
                    <div class="col-lg-6 mb-1">
                        <label for="idTrabajado" class="form-label">IdTrabajado</label>
                        <select class="form-select" id="idTrabajado" required ref="idTrabajado" v-model="campos.idTrabajado" :disabled="disabled.idTrabajado">
                            <option value="" selected>{{ textSelectGeneral }}</option>
                            <option v-for="(option, index) in optionsIdTrabajado" :value="option.value" :key="index">
                                {{ option.text }}
                            </option>
                        </select>
                        <div id="idTrabajadoError" v-show="msgError.idTrabajado" class="form-text text-danger">{{ msgError.idTrabajado }}</div>
                    </div>
                    <div class="col-lg-6 mb-1">
                        <label for="idTrabajador" class="form-label">IdTrabajador</label>
                        <select class="form-select" id="idTrabajador" required ref="idTrabajador" v-model="campos.idTrabajador" :disabled="disabled.idTrabajador">
                            <option value="" selected>{{ textSelectGeneral }}</option>
                            <option v-for="(option, index) in optionsIdTrabajador" :value="option.value" :key="index">
                                {{ option.text }}
                            </option>
                        </select>
                        <div id="idTrabajadorError" v-show="msgError.idTrabajador" class="form-text text-danger">{{ msgError.idTrabajador }}</div>
                    </div>
                    <div class="col-lg-12 mb-1">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" id="descripcion" minlength="1" maxlength="255" rows="3" ref="descripcion" v-model="campos.descripcion" :disabled="disabled.descripcion"></textarea>
                        <div id="descripcionError" v-show="msgError.descripcion" class="form-text text-danger">{{ msgError.descripcion }}</div>
                    </div>
                    <div class="col-lg-6 mt-2">
                        <input type="checkbox" class="form-check-input" id="estado" :required="required.estado" ref="estado" v-model="campos.estado" :disabled="disabled.estado">
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
import { Validador } from "../../services/validador.js";

export default {
    name: 'Descuentos',
    components: {
        "modal-component": modal,
        "table-component": table,
    },
    data() {
        return {
            validador: null,
            textSelectGeneral: 'escoja una opcion',
            mostrar: 10,
            optionsMostrar: [
                {text: '10', value: 10},
                {text: '20', value: 20},
                {text: '30', value: 30},
            ],
            buscarInTable: '',
            tituloModal: '',
            editando: false,
            creando: false,
            btnContinuar: true,
            titleModalSuccess: '',
            msgModalSuccess: '',
            fechaVisible: false,

            required: {
                estado: true,
            },

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
            this.limpiarErrores();

            let valido = this.validador.validarCampos();
            if (valido.msg) {
                this.msgError[valido.id] = valido.msg;
                return
            } else if (valido) {
                console.log('campos', this.campos);
                if (this.editando == true) {
                    let datos = await enviarData('editarDescuento', this.campos);
                    console.log('editar', datos);
                    if(datos == true) {
                        this.$refs.modalDescuento.hide();
                        this.mostrarMsg('Exito', 'Se actualizo el descuento con exito');
                    }else{
                        this.mostrarMsg('Error', 'Error inesperado');
                    }
                } else if (this.creando == true) {
                    let datos = await enviarData('crearDescuento', this.campos);
                    console.log('crear', datos);
                    if(datos == true) {
                        this.$refs.modalDescuento.hide();
                        this.mostrarMsg('Exito', 'Se creo el descuento con exito');
                    }else{
                        this.mostrarMsg('Error', 'Error inesperado');
                    }
                }
            }
        },
        async agregarDescuento() {
            this.limpiarErrores();
            this.desbloquearCampos()
            this.vaciarCampos();

            this.fechaVisible = false;
            this.required.estado = true;
            this.btnContinuar = true;
            this.editando = false;
            this.creando = true;

            this.tituloModal = 'Agregar Descuento'
            this.$refs.modalDescuento.show();

            setTimeout(() => {
                this.validador = new Validador([
                    'titulo',
                    'total',
                    'idGimnasio',
                    'idTrabajado',
                    'idTrabajador',
                    'descripcion',
                    'estado',
                ])
            }, 10);
        },
        async cargarSelects() {
            await this.llenarSelectIdGimnasio();
            await this.llenarSelectIdTrabajado();
            await this.llenarSelectIdTrabajador();
        },
        async editarDescuento(index, id) {
            this.$refs.tableDescuento.cargando = true;

            await this.cargarSelects();
            this.limpiarErrores();
            this.desbloquearCampos();
            this.llenarCampos(index);

            this.required.estado = false;
            this.btnContinuar = true;
            this.editando = true;
            this.creando = false;
            this.fechaVisible = false;

            this.tituloModal = 'Actualizar Descuento '+ id
            this.$refs.modalDescuento.show();

            this.$refs.tableDescuento.cargando = false;

            setTimeout(() => {
                this.validador = new Validador([
                    'titulo',
                    'total',
                    'idGimnasio',
                    'idTrabajado',
                    'idTrabajador',
                    'descripcion',
                    'estado',
                ])
            }, 10);
        },
        llenarCamposDescuento(datos) {
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
        async verDescuento(index) {
            this.$refs.tableDescuento.cargando = true;

            let datos = this.$refs.tableDescuento.datatable[index]

            await this.cargarSelects();
            this.limpiarErrores();
            this.bloquearCampos();
            this.llenarCamposDescuento(datos);

            this.btnContinuar = false;
            this.fechaVisible = true;

            this.tituloModal = 'ver Descuento'
            this.$refs.modalDescuento.show();

            this.$refs.tableDescuento.cargando = false;
        },
        async continuarModalEliminar() {
            this.$refs.modalEliminar.hide();
            let datos = await enviarData('eliminarDescuento', {id: this.campos.id});
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
            location.reload();
        },
        modalCerrar() {
            this.$refs.modalDescuento.hide();
        },
        vaciarCampos() {
            delete this.campos.id

            for (const i in this.campos) {
                this.campos[i] = '';
            }
        },
        llenarCampos(index){
            let datos = this.$refs.tableDescuento.datatable[index];
            this.campos.id = datos.id;

            this.llenarCamposDescuento(datos);
        },
        eliminarDescuento(id) {
            this.campos.id = id
            this.$refs.modalEliminar.show();
        },
        cerrarModalEliminar() {
            this.$refs.modalEliminar.hide();
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
        limpiarErrores() {
            for (const i in this.msgError) {
                this.msgError[i] = '';
            }
        },
        buscar(e) {
            console.log(e, 'escucho');
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
