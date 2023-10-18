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
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Estado</th>
                            <th scope="col">accion</th>
                        </tr>
                    </thead>
                    <tbody id="contenidoEquipo">
                        <tr>
                            <th scope="row">1</th>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                            <td>
                                <i class="bi bi-eye-fill ms-1" @click="verEquipo"></i>
                                <i class="bi bi-pencil-fill ms-1" @click="editatEquipo"></i>
                                <i class="bi bi-x-lg ms-1" @click="eliminarEquipo"></i>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <modal-component
                ref="modalEquipo"
                :titulo="tutiloModal"
                :visibleBtnCerrar="true"
                :visibleBtnContinuar="btnContinuar"
                @cerrar="modalCerrar"
                @continuar="modalContinuar"
            >
                <div class="row">
                    <div class="col-lg-6 mb-1">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" minlength="1" maxlength="50" v-model="nombre" :disabled="nombreDisabled">
                        <div id="nombreError" v-show="nombreError" class="form-text text-danger">{{ msgErrorNombre }}</div>
                    </div>
                    <div class="col-lg-6 mb-1">
                        <label for="fecha" class="form-label">Fecha</label>
                        <input type="datetime-local" class="form-control" id="fecha" v-model="fecha" :disabled="fechaDisabled">
                        <div id="fechaError" v-show="fechaError" class="form-text text-danger">{{ msgErrorFecha }}</div>
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
                    <div class="col-lg-12 mt-2">
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
    name: 'equipos',
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

            nombre: '',
            nombreError: false,
            msgErrorNombre: '',
            nombreDisabled: false,

            fecha: '',
            fechaError: false,
            msgErrorFecha: '',
            fechaDisabled: false,

            estado: false,
            estadoError: false,
            msgErrorEstado: '',
            estadoDisabled: false,

            optionsIdGimnasio:[
                {text: 'text', value: 1}
            ],
            idGimnasio: '',
            idGimnasioError: false,
            msgErrorIdGimnasio: '',
            idGimnasioDisabled: false,

        }
    },
    methods: {
        modalCerrar() {
            this.$refs.modalEquipo.hide();
        },
        modalContinuar() {
            this.$refs.modalEquipo.hide();
        },
        buscar(e) {
            console.log(e, 'escucho');
        },
        agregarEquipo() {
            this.desbloquearCampos()
            this.btnContinuar = true;

            this.editando = false;
            this.creando = true;
            this.viendo = false;

            this.tutiloModal = 'Agregar equipo'
            this.$refs.modalEquipo.show();
        },
        editatEquipo() {
            this.desbloquearCampos()
            this.btnContinuar = true;

            this.editando = true;
            this.creando = false;
            this.viendo = false;

            this.tutiloModal = 'Actualizar equipo'
            this.$refs.modalEquipo.show();
        },
        verEquipo() {
            this.bloquearCampos()
            this.btnContinuar = false;

            this.editando = false;
            this.creando = false;
            this.viendo = true;

            this.tutiloModal = 'ver equipo'
            this.$refs.modalEquipo.show();
        },
        eliminarEquipo() {
            console.log('eliminar');
        },
        bloquearCampos() {
            this.nombreDisabled = true;
            this.fechaDisabled = true;
            this.idGimnasioDisabled = true;
            this.estadoDisabled = true;
        },
        desbloquearCampos() {
            this.nombreDisabled = false;
            this.fechaDisabled = false;
            this.idGimnasioDisabled = false;
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
