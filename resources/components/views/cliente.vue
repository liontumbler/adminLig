<template>
    <div class="m-4">
        <div class="container">
            <div class="row">
                <div class="d-grid gap-2 col-lg-3 mb-1">
                    <button type="button" class="btn btn-primary" @click="agregarCliente">Agregar</button>
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
            <div class="tableCliente">
                <table-component
                    ref="tableCliente"
                    :url="'cargarClientes'"
                    :cabecera="{
                        id: {
                            text: '#',
                            type: 'text'
                        },
                        correo: {
                            text: 'Correo',
                            type: 'text'
                        },
                        telefono: {
                            text: 'Teléfono',
                            type: 'text'
                        },
                        nombresYapellidos: {
                            text: 'Nombre Y apellidos',
                            type: 'text'
                        },
                        accion: {
                            text: 'Acción',
                            type: 'accion'
                        },
                    }"
                    @ver="verCliente"
                    @editar="editarCliente"
                    @eliminar="eliminarCliente"
                >
                </table-component>
            </div>
            <modal-component
                ref="modalCliente"
                :titulo="tituloModal"
                :visibleBtnCerrar="true"
                :visibleBtnContinuar="btnContinuar"
                @cerrar="modalCerrar"
                @continuar="modalContinuar"
            >
                <div class="row">
                    <div class="col-lg-6 mb-1">
                        <label for="correo" class="form-label">Correo</label>
                        <input type="email" class="form-control" id="correo" minlength="1" maxlength="100" ref="correo" v-model="campos.correo" :disabled="disabled.correo">
                        <div id="correoError" v-show="msgError.correo" class="form-text text-danger">{{ msgError.correo }}</div>
                    </div>
                    <div class="col-lg-6 mb-1">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="number" class="form-control" id="telefono" min="1000000" max="9999999999" ref="telefono" v-model="campos.telefono" :disabled="disabled.telefono">
                        <div id="telefonoError" v-show="msgError.telefono" class="form-text text-danger">{{ msgError.telefono }}</div>
                    </div>
                    <div class="col-lg-6 mb-1">
                        <label for="nombresYapellidos" class="form-label">Nombres Y Apellidos</label>
                        <input type="text" class="form-control" id="nombresYapellidos" required minlength="1" maxlength="50" ref="nombresYapellidos" v-model="campos.nombresYapellidos" :disabled="disabled.nombresYapellidos">
                        <div id="nombresYapellidosError" v-show="msgError.nombresYapellidos" class="form-text text-danger">{{ msgError.nombresYapellidos }}</div>
                    </div>
                    <div class="col-lg-6 mb-1">
                        <label for="documento" class="form-label">Documento</label>
                        <input type="number" class="form-control" id="documento" min="1000" max="99999999999" ref="documento" v-model="campos.documento" :disabled="disabled.documento">
                        <div id="documentoError" v-show="msgError.documento" class="form-text text-danger">{{ msgError.Documento }}</div>
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
                        <label for="idEquipo" class="form-label">IdEquipo</label>
                        <select class="form-select" id="idEquipo" ref="idEquipo" v-model="campos.idEquipo" :disabled="disabled.idEquipo">
                            <option value="" selected>{{ textSelectGeneral }}</option>
                            <option v-for="(option, index) in optionsIdEquipo" :value="option.value" :key="index">
                                {{ option.text }}
                            </option>
                        </select>
                        <div id="idEquipoError" v-show="msgError.idEquipo" class="form-text text-danger">{{ msgError.idEquipo }}</div>
                    </div>
                    <div class="col-lg-6 mt-2">
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
                Seguro que desea borrar el cliente
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
    name: 'Clientes',
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
                correo: '',
                telefono: '',
                nombresYapellidos: '',
                estado: '',
                documento: '',
                idGimnasio: '',
                idEquipo: '',
            },

            disabled: {
                correo: false,
                telefono: false,
                nombresYapellidos: false,
                estado: false,
                documento: false,
                idGimnasio: false,
                idEquipo: false,
            },

            msgError: {
                correo: '',
                telefono: '',
                nombresYapellidos: '',
                estado: '',
                documento: '',
                idGimnasio: '',
                idEquipo: '',
            },

            optionsIdGimnasio:[],

            optionsIdEquipo:[],
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
        async llenarSelectIdEquipo() {
            let datos =  await cargarDatos('cargarEquiposSelect');
            this.optionsIdEquipo = datos.map(function(btn) {
                return {text: btn.nombre, value: btn.id};
            });
        },
        async modalContinuar() {

            console.log('campos', this.campos);
            if (this.editando == true) {
                let datos = await enviarData('editarCliente', this.campos);
                console.log('editar', datos);
                if(datos == true) {
                    this.mostrarMsg('Exito', 'Se actualizo el cliente con exito');
                }else{
                    this.mostrarMsg('Error', 'Error inesperado');
                }
            } else if (this.creando == true) {
                let datos = await enviarData('crearCliente', this.campos);
                console.log('crear', datos);
                if(datos == true) {
                    this.mostrarMsg('Exito', 'Se creo el cliente con exito');
                }else{
                    this.mostrarMsg('Error', 'Error inesperado');
                }
            }
        },
        async agregarCliente() {
            this.desbloquearCampos()
            this.btnContinuar = true;

            this.editando = false;
            this.creando = true;

            this.vaciarCampos();

            this.tituloModal = 'Agregar Cliente'
            this.$refs.modalCliente.show();
        },
        async cargarSelects() {
            await this.llenarSelectIdGimnasio();
            await this.llenarSelectIdEquipo();
        },
        async editarCliente(index, id) {
            this.$refs.tableCliente.cargando = true;

            await this.cargarSelects();

            this.desbloquearCampos()

            this.btnContinuar = true;

            this.editando = true;
            this.creando = false;

            this.llenarCampos(index);

            this.tituloModal = 'Actualizar Cliente '+ id
            this.$refs.modalCliente.show();
            this.$refs.tableCliente.cargando = false;
        },
        async verCliente(index) {
            this.$refs.tableCliente.cargando = true;

            await this.cargarSelects();

            this.bloquearCampos();

            this.btnContinuar = false;

            let datos = this.$refs.tableCliente.datatable[index]

            this.campos.correo = datos.correo
            this.campos.telefono =  datos.telefono
            this.campos.nombresYapellidos = datos.nombresYapellidos
            this.campos.documento = datos.documento
            this.campos.idGimnasio = datos.idGimnasio
            this.campos.idEquipo = datos.idEquipo
            this.campos.estado = datos.estado == 1 ? true : false

            this.tituloModal = 'ver Cliente'
            this.$refs.modalCliente.show();
            this.$refs.tableCliente.cargando = false;
        },
        async continuarModalEliminar() {
            this.$refs.modalEliminar.hide();
            let datos = await enviarData('eliminarCliente', {id: this.campos.id});
            console.log('elimino', datos);
            if(datos == true) {
                this.mostrarMsg('Exito', 'Se elimino el cliente con exito');
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
            this.$refs.modalCliente.hide();
        },
        vaciarCampos() {
            delete this.campos.id
            this.campos.correo = ''
            this.campos.telefono = ''
            this.campos.nombresYapellidos = ''
            this.campos.documento = ''
            this.campos.idGimnasio = ''
            this.campos.idEquipo = ''
            this.campos.estado = ''
        },
        llenarCampos(index){
            let datos = this.$refs.tableCliente.datatable[index]

            this.campos.id = datos.id
            this.campos.correo = datos.correo
            this.campos.telefono = datos.telefono
            this.campos.nombresYapellidos = datos.nombresYapellidos
            this.campos.documento = datos.documento
            this.campos.idGimnasio = datos.idGimnasio
            this.campos.idEquipo = datos.idEquipo
            this.campos.estado = datos.estado == 1 ? true : false
        },
        eliminarCliente(id) {
            this.campos.id = id
            this.$refs.modalEliminar.show();
        },
        cerrarModalEliminar() {
            this.$refs.modalEliminar.hide();
        },
        bloquearCampos() {
            this.disabled.correo = true;
            this.disabled.telefono = true;
            this.disabled.nombresYapellidos = true;
            this.disabled.documento = true;
            this.disabled.idGimnasio = true;
            this.disabled.idEquipo = true;
            this.disabled.estado = true;
        },
        desbloquearCampos() {
            this.disabled.correo = false;
            this.disabled.telefono = false;
            this.disabled.nombresYapellidos = false;
            this.disabled.documento = false;
            this.disabled.idGimnasio = false;
            this.disabled.idEquipo = false;
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
