<template>
    <div class="m-4">
        <div class="container">
            <div class="row">
                <div class="d-grid gap-2 col-lg-3 mb-1">
                    <button type="button" class="btn btn-primary" @click="agregarTrabajador">Agregar</button>
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
            <div class="tableTrabajador">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombres y Apellidos</th>
                            <th scope="col">Nickname</th>
                            <th scope="col">Correo</th>
                            <th scope="col">Acción</th>
                        </tr>
                    </thead>
                    <tbody id="contenidoTrabajador">
                        <tr>
                            <th scope="row">1</th>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                            <td>
                                <i class="bi bi-eye-fill ms-1" @click="verTrabajador"></i>
                                <i class="bi bi-pencil-fill ms-1" @click="editatTrabajador"></i>
                                <i class="bi bi-x-lg ms-1" @click="eliminarTrabajador"></i>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <modal-component
                ref="modalTrabajador"
                :titulo="tutiloModal"
                :visibleBtnCerrar="true"
                :visibleBtnContinuar="btnContinuar"
                @cerrar="modalCerrar"
                @continuar="modalContinuar"
            >
                <div class="row">
                    <div class="col-lg-6 mb-1">
                        <label for="nombresYapellidos" class="form-label">Nombres Y Apellidos</label>
                        <input type="text" class="form-control" id="nombresYapellidos" minlength="1" maxlength="50" ref="nombresYapellidos" v-model="campos.nombresYapellidos" :disabled="disabled.nombresYapellidos">
                        <div id="nombresYapellidosError" v-show="msgError.nombresYapellidos" class="form-text text-danger">{{ msgError.nombresYapellidos }}</div>
                    </div>
                    <div class="col-lg-6 mb-1">
                        <label for="nickname" class="form-label">Nickname</label>
                        <input type="text" class="form-control" id="nickname" minlength="1" maxlength="50" ref="nickname" v-model="campos.nickname" :disabled="disabled.nickname">
                        <div id="nicknameError" v-show="msgError.nickname" class="form-text text-danger">{{ msgError.nickname }}</div>
                    </div>
                    <div class="col-lg-6 mb-1">
                        <label for="correo" class="form-label">Correo</label>
                        <input type="email" class="form-control" id="correo" minlength="1" maxlength="50" ref="correo" v-model="campos.correo" :disabled="disabled.correo">
                        <div id="correoError" v-show="msgError.correo" class="form-text text-danger">{{ msgError.correo }}</div>
                    </div>
                    <div class="col-lg-6 mb-1">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="number" class="form-control" id="telefono" min="1000000" max="9999999999" ref="telefono" v-model="campos.telefono" :disabled="disabled.telefono">
                        <div id="telefonoError" v-show="msgError.telefono" class="form-text text-danger">{{ msgError.telefono }}</div>
                    </div>
                    <div class="col-lg-6 mb-1">
                        <label for="documento" class="form-label">Documento</label>
                        <input type="text" class="form-control" id="documento" minlength="6" maxlength="9999999999" ref="documento" v-model="campos.documento" :disabled="disabled.documento">
                        <div id="documentoError" v-show="msgError.documento" class="form-text text-danger">{{ msgError.Documento }}</div>
                    </div>
                    <div class="col-lg-6 mb-1">
                        <label for="clave" class="form-label">Clave</label>
                        <input type="password" class="form-control" id="clave" minlength="8" maxlength="50" ref="clave" v-model="campos.clave" :disabled="disabled.clave">
                        <div id="claveError" v-show="msgError.clave" class="form-text text-danger">{{ msgError.clave }}</div>
                    </div>
                    <div class="col-lg-6 mb-1">
                        <label for="clavecaja" class="form-label">Clave caja</label>
                        <input type="text" class="form-control" id="clavecaja" minlength="4" maxlength="50" ref="clavecaja" v-model="campos.clavecaja" :disabled="disabled.clavecaja">
                        <div id="clavecajaError" v-show="msgError.clavecaja" class="form-text text-danger">{{ msgError.clavecaja }}</div>
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
    name: 'Trabajadors',
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
            arrayMsjError: [
                '(min 8 caracteres max 50)',
                '(min 2 mayusculas max 2 minusculas)',
                '(min 2 caracteres esp y 2 num)',
            ],

            campos: {
                nombresYapellidos: '',
                nickname: '',
                correo: '',
                telefono: '',
                documento: '',
                clave: '',
                clavecaja: '',
                estado: '',
                idGimnasio: '',
            },

            disabled: {
                nombresYapellidos: false,
                nickname: false,
                correo: false,
                telefono: false,
                documento: false,
                clave: false,
                clavecaja: false,
                estado: false,
                idGimnasio: false,
            },

            msgError: {
                nombresYapellidos: '',
                nickname: '',
                correo: '',
                telefono: '',
                documento: '',
                clave: '',
                clavecaja: '',
                estado: '',
                idGimnasio: '',
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
            this.$refs.modalTrabajador.hide();
        },
        modalContinuar() {
            this.$refs.modalTrabajador.hide();
        },
        buscar(e) {
            console.log(e, 'escucho');
        },
        agregarTrabajador() {
            this.desbloquearCampos()
            this.btnContinuar = true;

            this.editando = false;
            this.creando = true;
            this.viendo = false;

            this.tutiloModal = 'Agregar Trabajador'
            this.$refs.modalTrabajador.show();
        },
        editatTrabajador() {
            this.desbloquearCampos()
            this.btnContinuar = true;

            this.editando = true;
            this.creando = false;
            this.viendo = false;

            this.tutiloModal = 'Actualizar Trabajador'
            this.$refs.modalTrabajador.show();
        },
        verTrabajador() {
            this.bloquearCampos()
            this.btnContinuar = false;

            this.editando = false;
            this.creando = false;
            this.viendo = true;

            this.tutiloModal = 'ver Trabajador'
            this.$refs.modalTrabajador.show();
        },
        eliminarTrabajador() {
            console.log('eliminar');
        },
        bloquearCampos() {
            this.disabled.nombresYapellidos = true;
            this.disabled.nickname = true;
            this.disabled.correo = true;
            this.disabled.telefono = true;
            this.disabled.documento = true;
            this.disabled.clave = true;
            this.disabled.clavecaja = true;
            this.disabled.estado = true;
            this.disabled.idGimnasio = true;
        },
        desbloquearCampos() {
            this.disabled.nombresYapellidos = false;
            this.disabled.nickname = false;
            this.disabled.correo = false;
            this.disabled.telefono = false;
            this.disabled.documento = false;
            this.disabled.clave = false;
            this.disabled.clavecaja = false;
            this.disabled.estado = false;
            this.disabled.idGimnasio = false;
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
