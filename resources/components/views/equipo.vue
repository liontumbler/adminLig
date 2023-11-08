<template>
    <div class="m-4">
        <div class="container">
            <div class="row">
                <div class="d-grid gap-2 col-lg-3 mb-1">
                    <button type="button" class="btn btn-primary" @click="agregarEquipo">Agregar</button>
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
            <div class="tableEquipo">
                <table-component
                    ref="tableEquipo"
                    :url="'cargarEquipos'"
                    :cabecera="{
                        id: {
                            text: '#',
                            type: 'text'
                        },
                        nombre: {
                            text: 'Nombre',
                            type: 'text'
                        },
                        fecha: {
                            text: 'Fecha',
                            type: 'datetime-local'
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
                    @ver="verEquipo"
                    @editar="editarEquipo"
                    @eliminar="eliminarEquipo"
                >
                </table-component>
            </div>
            <modal-component
                ref="modalEquipo"
                :titulo="tituloModal"
                :visibleBtnCerrar="true"
                :visibleBtnContinuar="btnContinuar"
                @cerrar="modalCerrar"
                @continuar="modalContinuar"
            >
                <div class="row">
                    <div class="col-lg-6 mb-1">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" required minlength="1" maxlength="50" v-model="campos.nombre" :disabled="disabled.nombre">
                        <div id="nombreError" v-show="msgError.nombre" class="form-text text-danger">{{ msgError.nombre }}</div>
                    </div>
                    <div class="col-lg-6 mb-1">
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
                    <div class="col-lg-12 mt-2">
                        <input type="checkbox" class="form-check-input" id="estado" required ref="estado" v-model="campos.estado" :disabled="disabled.estado">
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
                Seguro que desea borrar el equipo
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
    name: 'Equipos',
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
            tituloModal: '',
            editando: false,
            creando: false,
            btnContinuar: true,
            titleModalSuccess: '',
            msgModalSuccess: '',

            campos: {
                nombre: '',
                fecha: '',
                idGimnasio: '',
                estado: '',
            },

            disabled: {
                nombre: false,
                fecha: false,
                idGimnasio: false,
                estado: false,
            },
            msgError: {
                nombre: '',
                fecha: '',
                idGimnasio: '',
                estado: '',
            },

            optionsIdGimnasio:[],
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
        async modalContinuar() {

            console.log('campos', this.campos);
            if (this.editando == true) {
                let datos = await enviarData('editarEquipo', this.campos);
                console.log('editar', datos);
                if(datos == true) {
                    this.mostrarMsg('Exito', 'Se actualizo el equipo con exito');
                }else{
                    this.mostrarMsg('Error', 'Error inesperado');
                }
            } else if (this.creando == true) {
                console.log(this.campos)
                let datos = await enviarData('crearEquipo', this.campos);
                console.log('crear', datos);
                if(datos == true) {
                    this.mostrarMsg('Exito', 'Se creo el equipo con exito');
                }else{
                    this.mostrarMsg('Error', 'Error inesperado');
                }
            }
        },
        async agregarEquipo() {
            this.desbloquearCampos()
            this.btnContinuar = true;

            this.editando = false;
            this.creando = true;

            this.vaciarCampos();

            this.tituloModal = 'Agregar Equipo'
            this.$refs.modalEquipo.show();
        },
        async cargarSelects() {
            await this.llenarSelectIdGimnasio();
        },

        async editarEquipo(index, id) {
            this.$refs.tableEquipo.cargando = true;

            await this.cargarSelects();

            this.desbloquearCampos()

            this.btnContinuar = true;

            this.editando = true;
            this.creando = false;

            this.llenarCampos(index);

            this.tituloModal = 'Actualizar Equipo '+ id
            this.$refs.modalEquipo.show();
            this.$refs.tableEquipo.cargando = false;
        },
        async verEquipo(index) {
            this.$refs.tableEquipo.cargando = true;

            await this.cargarSelects();

            this.bloquearCampos();

            this.btnContinuar = false;

            let datos = this.$refs.tableEquipo.datatable[index]

            this.campos.nombre = datos.nombre
            this.campos.fecha = datos.fecha
            this.campos.idGimnasio = datos.idGimnasio
            this.campos.estado = datos.estado == 1 ? true : false

            this.tituloModal = 'ver Equipo'
            this.$refs.modalEquipo.show();
            this.$refs.tableEquipo.cargando = false;
        },
        async continuarModalEliminar() {
            this.$refs.modalEliminar.hide();
            let datos = await enviarData('eliminarEquipo', {id: this.campos.id});
            console.log('elimino', datos);
            if(datos == true) {
                this.mostrarMsg('Exito', 'Se eliminó el equipo con exito');
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
            this.$refs.modalEquipo.hide();
        },
        vaciarCampos() {
            delete this.campos.id
            this.campos.nombre = ''
            this.campos.fecha = ''
            this.campos.idGimnasio = ''
            this.campos.estado = ''
        },
        llenarCampos(index){
            let datos = this.$refs.tableEquipo.datatable[index]

            this.campos.id = datos.id
            this.campos.nombre = datos.nombre
            this.campos.fecha = datos.fecha
            this.campos.idGimnasio = datos.idGimnasio
            this.campos.estado = datos.estado == 1 ? true : false
        },
        eliminarEquipo(id) {
            this.campos.id = id
            this.$refs.modalEliminar.show();
        },
        cerrarModalEliminar() {
            this.$refs.modalEliminar.hide();
        },
        bloquearCampos() {
            this.disabled.nombre = true;
            this.disabled.fecha = true;
            this.disabled.idGimnasio = true;
            this.disabled.estado = true;
        },
        desbloquearCampos() {
            this.disabled.nombre = false;
            this.disabled.fecha = false;
            this.disabled.idGimnasio = false;
            this.disabled.estado = false;
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
