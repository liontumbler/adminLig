<template>
    <div class="m-4">
        <div class="container">
            <div class="row">
                <div class="d-grid gap-2 col-lg-3 mb-1">
                    <button type="button" class="btn btn-primary" @click="agregarGimnasio">Agregar</button>
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
            <div class="tableGimnasio">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Correo</th>
                            <th scope="col">Nickname</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Acción</th>
                        </tr>
                    </thead>
                    <tbody id="contenidoGimnasio">
                        <tr>
                            <th scope="row">1</th>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                            <td>
                                <i class="bi bi-eye-fill ms-1" @click="verGimnasio"></i>
                                <i class="bi bi-pencil-fill ms-1" @click="editatGimnasio"></i>
                                <i class="bi bi-x-lg ms-1" @click="eliminarGimnasio"></i>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <modal-component
                ref="modalGimnasio"
                :titulo="tutiloModal"
                :visibleBtnCerrar="true"
                :visibleBtnContinuar="btnContinuar"
                @cerrar="modalCerrar"
                @continuar="modalContinuar"
            >
                <div class="row">
                    <div class="col-lg-6 mb-1">
                        <label for="correo" class="form-label">Correo</label>
                        <input type="email" class="form-control" id="correo" ref="correo" v-model="correo" :disabled="correoDisabled">
                        <div id="correoError" v-show="correoError" class="form-text text-danger">{{ msgErrorCorreo }}</div>
                    </div>
                    <div class="col-lg-6 mb-1">
                        <label for="nickname" class="form-label">Nickname</label>
                        <input type="text" class="form-control" id="nickname" ref="nickname" v-model="nickname" :disabled="nicknameDisabled">
                        <div id="nicknameError" v-show="nicknameError" class="form-text text-danger">{{ msgErrorNickname }}</div>
                    </div>
                    <div class="col-lg-6 mb-1">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" v-model="nombre" :disabled="nombreDisabled">
                        <div id="nombreError" v-show="nombreError" class="form-text text-danger">{{ msgErrorNombre }}</div>
                    </div>
                    <div class="col-lg-6 mb-1">
                        <label for="clave" class="form-label">Clave</label>
                        <input type="text" class="form-control" id="clave" fer="clave" v-model="clave" :disabled="claveDisabled">
                        <div id="claveError" v-show="claveError" class="form-text text-danger">{{ msgErrorClave }}</div>
                    </div>
                    <div class="col-lg-6 mb-1">
                        <label for="color" class="form-label">Color</label>
                        <input type="color" class="form-control" id="color" ref="color" v-model="color" :disabled="colorDisabled">
                        <div id="colorError" v-show="colorError" class="form-text text-danger">{{ msgErrorColor }}</div>
                    </div>
                    <div class="col-lg-6 mb-1">
                        <label for="background" class="form-label">Background</label>
                        <input type="color" class="form-control" id="background" ref="background" v-model="background" :disabled="backgroundDisabled">
                        <div id="backgroundError" v-show="backgroundError" class="form-text text-danger">{{ msgErrorBackground }}</div>
                    </div>
                    <div class="col-lg-6 mb-1">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="direccion" ref="direccion" v-model="direccion" :disabled="direccionDisabled">
                        <div id="direccionError" v-show="direccionError" class="form-text text-danger">{{ msgErrorDireccion }}</div>
                    </div>
                    <div class="col-lg-6 mb-1">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="number" class="form-control" id="telefono" ref="telefono" v-model="telefono" :disabled="telefonoDisabled">
                        <div id="telefonoError" v-show="telefonoError" class="form-text text-danger">{{ msgErrorTelefono }}</div>
                    </div>
                    <div class="col-lg-6 mb-1">
                        <label for="fecha" class="form-label">Fecha</label>
                        <input type="datetime-local" class="form-control" id="fecha" ref="fecha" v-model="fecha" :disabled="fechaDisabled">
                        <div id="fechaError" v-show="fechaError" class="form-text text-danger">{{ msgErrorFecha }}</div>
                    </div>
                    <div class="col-lg-6 mb-1">
                        <label for="mindemasliga" class="form-label">MinDeMasLiga</label>
                        <input type="number" class="form-control" id="mindemasliga" ref="mindemasliga" v-model="mindemasliga" :disabled="mindemasligaDisabled">
                        <div id="mindemasligaError" v-show="mindemasligaError" class="form-text text-danger">{{ msgErrorMinDeMasLiga }}</div>
                    </div>
                    <div class="col-lg-12 mb-1">
                        <label for="idPlan" class="form-label">idPlan</label>
                        <select class="form-select" id="idPlan" ref="idPlan" v-model="idPlan" :disabled="idPlanDisabled">
                            <option value="" selected>{{ textSelectGeneral }}</option>
                            <option v-for="(option, index) in optionsIdPlan" :value="option.value" :key="index">
                                {{ option.text }}
                            </option>
                        </select>
                        <div id="idPlanError" v-show="idPlanError" class="form-text text-danger">{{ msgErrorIdPlan }}</div>
                    </div>
                    <div class="col-lg-12 mb-1">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" id="descripcion" ref="descripcion" rows="3" v-model="descripcion" :disabled="descripcionDisabled"></textarea>
                        <div id="descripcionError" v-show="descripcionError" class="form-text text-danger">{{ msgErrorDescripcion }}</div>
                    </div>
                    <div class="col-lg-4 mt-2">
                        <input type="checkbox" class="form-check-input" id="habilitado" ref="habilitado" v-model="habilitado" :disabled="habilitadoDisabled">
                        <label class="form-check-label" for="habilitado">Habilitado</label>
                        <div id="habilitadoError" v-show="habilitadoError" class="form-text text-danger">{{ msgErrorhabilitado }}</div>
                    </div>
                    <div class="col-lg-4 mt-2">
                        <input type="checkbox" class="form-check-input" id="superAdmin" ref="superAdmin" v-model="superAdmin" :disabled="superAdminDisabled">
                        <label class="form-check-label" for="superAdmin">superAdmin</label>
                        <div id="superAdminError" v-show="superAdminError" class="form-text text-danger">{{ msgErrorSuperAdmin }}</div>
                    </div>
                    <div class="col-lg-4 mt-2">
                        <input type="checkbox" class="form-check-input" id="estado" ref="estado" v-model="estado" :disabled="estadoDisabled">
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
    name: 'Gimnasios',
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

            nickname: '',
            nicknameError: false,
            msgErrorNickname: '',
            nicknameDisabled: false,

            nombre: '',
            nombreError: false,
            msgErrorNombre: '',
            nombreDisabled: false,

            clave: '',
            claveError: false,
            msgErrorClave: '',
            claveDisabled: false,

            color: '',
            colorError: false,
            msgErrorColor: '',
            colorDisabled: false,

            background: '',
            backgroundError: false,
            msgErrorBackground: '',
            backgroundDisabled: false,

            direccion: '',
            direccionError: false,
            msgErrorDireccion: '',
            direccionDisabled: false,

            telefono: '',
            telefonoError: false,
            msgErrorTelefono: '',
            telefonoDisabled: false,

            fecha: '',
            fechaError: false,
            msgErrorFecha: '',
            fechaDisabled: false,

            mindemasliga: '',
            mindemasligaError: false,
            msgErrorMinDeMasLiga: '',
            mindemasligaDisabled: false,

            descripcion: '',
            descripcionError: false,
            msgErrorDescripcion: '',
            descripcionDisabled: false,

            habilitado: false,
            habilitadoError: false,
            msgErrorHabilitado: '',
            habilitadoDisabled: false,

            superadmin: false,
            superadminError: false,
            msgErrorSuperAdmin: '',
            superadminDisabled: false,

            estado: false,
            estadoError: false,
            msgErrorEstado: '',
            estadoDisabled: false,

            documento: '',
            documentoError: false,
            msgErrorDocumento: '',
            documentoDisabled: false,

            optionsIdPlan:[
                {text: 'text', value: 1}
            ],
            idPlan: '',
            idPlanError: false,
            msgErrorIdPlan: '',
            idPlanDisabled: false,

        }
    },
    methods: {
        modalCerrar() {
            this.$refs.modalGimnasio.hide();
        },
        modalContinuar() {
            this.$refs.modalGimnasio.hide();
        },
        buscar(e) {
            console.log(e, 'escucho');
        },
        agregarGimnasio() {
            this.desbloquearCampos()
            this.btnContinuar = true;

            this.editando = false;
            this.creando = true;
            this.viendo = false;

            this.tutiloModal = 'Agregar Gimnasio'
            this.$refs.modalGimnasio.show();
        },
        editatGimnasio() {
            this.desbloquearCampos()
            this.btnContinuar = true;

            this.editando = true;
            this.creando = false;
            this.viendo = false;

            this.tutiloModal = 'Actualizar Gimnasio'
            this.$refs.modalGimnasio.show();
        },
        verGimnasio() {
            this.bloquearCampos()
            this.btnContinuar = false;

            this.editando = false;
            this.creando = false;
            this.viendo = true;

            this.tutiloModal = 'ver Gimnasio'
            this.$refs.modalGimnasio.show();
        },
        eliminarGimnasio() {
            console.log('eliminar');
        },
        bloquearCampos() {
            this.correoDisabled = true;
            this.nicknameDisabled = true;
            this.nombreDisabled = true;
            this.claveDisabled = true;
            this.colorDisabled = true;
            this.backgroundDisabled = true;
            this.direccionDisabled = true;
            this.telefonoDisabled = true;
            this.fechaDisabled = true;
            this.mindemasligaDisabled = true
            this.superAdminDisabled = true;;
            this.descripcionDisabled = true;
            this.habilitadoDisabled = true;
            this.idPlanDisabled = true;
            this.estadoDisabled = true;
        },
        desbloquearCampos() {
            this.correoDisabled = false;
            this.nicknameDisabled = false;
            this.nombreDisabled = false;
            this.claveDisabled = false;
            this.colorDisabled = false;
            this.backgroundDisabled = false;
            this.direccionDisabled = false;
            this.telefonoDisabled = false;
            this.fechaDisabled = false;
            this.mindemasligaDisabled = false;
            this.superAdminDisabled = false;
            this.descripcionDisabled = false;
            this.habilitadoDisabled = false;
            this.idPlanDisabled = false;
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
