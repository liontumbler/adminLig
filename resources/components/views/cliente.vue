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
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">correo</th>
                            <th scope="col">telefono</th>
                            <th scope="col">nombre y apellido</th>
                            <th scope="col">accion</th>
                        </tr>
                    </thead>
                    <tbody id="contenidoCliente">
                        <tr>
                            <th scope="row">1</th>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                            <td>
                                <i class="bi bi-eye-fill ms-1" @click="verCliente"></i>
                                <i class="bi bi-pencil-fill ms-1" @click="editatCliente"></i>
                                <i class="bi bi-x-lg ms-1" @click="eliminarCliente"></i>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <modal-component
                ref="modalCliente"
                :titulo="tutiloModal"
                :visibleBtnCerrar="true"
                :visibleBtnContinuar="btnContinuar"
                @cerrar="modalCerrar"
                @continuar="modalContinuar"
            >
                <div class="row">
                    <div class="col-lg-6 mb-1">
                        <label for="correo" class="form-label">Correo</label>
                        <input type="email" class="form-control" id="correo" v-model="correo" :disabled="correoDisabled">
                        <div id="correoError" v-show="correoError" class="form-text text-danger">{{ msgErrorCorreo }}</div>
                    </div>
                    <div class="col-lg-6 mb-1">
                        <label for="telefono" class="form-label">Telefono</label>
                        <input type="number" class="form-control" id="telefono" v-model="telefono" :disabled="telefonoDisabled">
                        <div id="telefonoError" v-show="telefonoError" class="form-text text-danger">{{ msgErrorTelefono }}</div>
                    </div>
                    <div class="col-lg-6 mb-1">
                        <label for="nombresYapellidos" class="form-label">Nombres Y Apellidos</label>
                        <input type="text" class="form-control" id="nombresYapellidos" v-model="nombresYapellidos" :disabled="nombresYapellidosDisabled">
                        <div id="nombresYapellidosError" v-show="nombresYapellidosError" class="form-text text-danger">{{ msgErrorNombresYapellidos }}</div>
                    </div>
                    <div class="col-lg-6 mb-1">
                        <label for="documento" class="form-label">Documento</label>
                        <input type="number" class="form-control" id="documento" v-model="documento" :disabled="documentoDisabled">
                        <div id="documentoError" v-show="documentoError" class="form-text text-danger">{{ msgErrorDocumento }}</div>
                    </div>
                    <div class="col-lg-6 mb-1">
                        <label for="idGimnasio" class="form-label">idGimnasio</label>
                        <select class="form-select" id="idGimnasio" v-model="idGimnasio" :disabled="idGimnasioDisabled">
                            <option value="" selected>{{ textSelectGeneral }}</option>
                            <option v-for="(option, index) in optionsIdGimnasio" :value="option.value" :key="index">
                                {{ option.text }}
                            </option>
                        </select>
                        <div id="idGimnasioError" v-show="idGimnasioError" class="form-text text-danger">{{ msgErrorIdGimnasio }}</div>
                    </div>
                    <div class="col-lg-6 mb-1">
                        <label for="idEquipo" class="form-label">idEquipo</label>
                        <select class="form-select" id="idEquipo" v-model="idEquipo" :disabled="idEquipoDisabled">
                            <option value="" selected>{{ textSelectGeneral }}</option>
                            <option v-for="(option, index) in optionsIdEquipo" :value="option.value" :key="index">
                                {{ option.text }}
                            </option>
                        </select>
                        <div id="idEquipoError" v-show="idEquipoError" class="form-text text-danger">{{ msgErrorIdEquipo }}</div>
                    </div>
                    <div class="col-lg-6 mt-2">
                        <input type="checkbox" class="form-check-input" id="estado" v-model="estado" :disabled="estadoDisabled">
                        <label class="form-check-label" for="estado">Estado</label>
                        <div id="estadoError" v-show="estadoError" class="form-text text-danger">{{ msgErrorestado }}</div>
                    </div>
                </div>
            </modal-component>
        </div>
    </div>

</template>
<script>
import modal from "../../components/controls/modal.vue";

export default {
    name: 'Clientes',
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

            correo: '',
            correoError: false,
            msgErrorCorreo: '',
            correoDisabled: false,

            telefono: '',
            telefonoError: false,
            msgErrorTelefono: '',
            telefonoDisabled: false,

            nombresYapellidos: '',
            nombresYapellidosError: false,
            msgErrorNombresYapellidos: '',
            nombresYapellidosDisabled: false,

            estado: false,
            estadoError: false,
            msgErrorEstado: '',
            estadoDisabled: false,

            documento: '',
            documentoError: false,
            msgErrorDocumento: '',
            documentoDisabled: false,

            optionsIdGimnasio:[
                {text: 'text', value: 1}
            ],
            idGimnasio: '',
            idGimnasioError: false,
            msgErrorIdGimnasio: '',
            idGimnasioDisabled: false,

            optionsIdEquipo:[
                {text: 'text', value: 1}
            ],
            idEquipo: '',
            idEquipoError: false,
            msgErrorIdEquipo: '',
            idEquipoDisabled: false,
        }
    },
    methods: {
        modalCerrar() {
            this.$refs.modalCliente.hide();
        },
        modalContinuar() {
            this.$refs.modalCliente.hide();
        },
        buscar(e) {
            console.log(e, 'escucho');
        },
        agregarCliente() {
            this.desbloquearCampos()
            this.btnContinuar = true;

            this.editando = false;
            this.creando = true;
            this.viendo = false;

            this.tutiloModal = 'Agregar Cliente'
            this.$refs.modalCliente.show();
        },
        editatCliente() {
            this.desbloquearCampos()
            this.btnContinuar = true;

            this.editando = true;
            this.creando = false;
            this.viendo = false;

            this.tutiloModal = 'Actualizar Cliente'
            this.$refs.modalCliente.show();
        },
        verCliente() {
            this.bloquearCampos()
            this.btnContinuar = false;

            this.editando = false;
            this.creando = false;
            this.viendo = true;

            this.tutiloModal = 'ver Cliente'
            this.$refs.modalCliente.show();
        },
        eliminarCliente() {
            console.log('eliminar');
        },
        bloquearCampos() {
            this.correoDisabled = true;
            this.telefonoDisabled = true;
            this.nombresYapellidosDisabled = true;
            this.documentoDisabled = true;
            this.idGimnasioDisabled = true;
            this.idEquipoDisabled = true;
            this.estadoDisabled = true;
        },
        desbloquearCampos() {
            this.correoDisabled = false;
            this.telefonoDisabled = false;
            this.nombresYapellidosDisabled = false;
            this.documentoDisabled = false;
            this.idGimnasioDisabled = false;
            this.idEquipoDisabled = false;
            this.estadoDisabled = false;
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
