<template>
    <div class="m-4">
        <div class="container">
            <div class="row">
                <div class="d-grid gap-2 col-lg-3 mb-1">
                    <button type="button" class="btn btn-primary" @click="agregarHoraLiga">Agregar</button>
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
            <div class="tableHoraLiga">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Horas</th>
                            <th scope="col">Precio</th>
                            <th scope="col">Acción</th>
                        </tr>
                    </thead>
                    <tbody id="contenidoHoraLiga">
                        <tr>
                            <th scope="row">1</th>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                            <td>
                                <i class="bi bi-eye-fill ms-1" @click="verHoraLiga"></i>
                                <i class="bi bi-pencil-fill ms-1" @click="editatHoraLiga"></i>
                                <i class="bi bi-x-lg ms-1" @click="eliminarHoraLiga"></i>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <modal-component
                ref="modalHoraLiga"
                :titulo="tutiloModal"
                :visibleBtnCerrar="true"
                :visibleBtnContinuar="btnContinuar"
                @cerrar="modalCerrar"
                @continuar="modalContinuar"
            >
                <div class="row">
                    <div class="col-lg-6 mb-1">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" minlength="1" maxlength="50" ref="nombre" v-model="campos.nombre" :disabled="disabled.nombre">
                        <div id="nombreError" v-show="msgError.nombre" class="form-text text-danger">{{ msgError.nombre }}</div>
                    </div>
                    <div class="col-lg-6 mb-1">
                        <label for="horas" class="form-label">Horas</label>
                        <input type="number" class="form-control" id="horas" step="0.5" min="0.5" max="10" value="0.5" ref="horas" v-model="campos.horas" :disabled="disabled.horas">
                        <div id="horasError" v-show="msgError.horas" class="form-text text-danger">{{ msgError.horas }}</div>
                    </div>
                    <div class="col-lg-6 mb-1">
                        <label for="precio" class="form-label">Precio</label>
                        <input type="number" class="form-control" id="precio" min="500" max="1000000" ref="precio" v-model="campos.precio" :disabled="disabled.precio">
                        <div id="precioError" v-show="msgError.precio" class="form-text text-danger">{{ msgError.precio }}</div>
                    </div>
                    <div class="col-lg-6 mb-1">
                        <label for="fecha" class="form-label">Fecha</label>
                        <input type="datetime-local" class="form-control" id="fecha" ref="fecha" v-model="campos.fecha" :disabled="disabled.fecha">
                        <div id="fechaError" v-show="msgError.fecha" class="form-text text-danger">{{ msgError.fecha }}</div>
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
                    <div class="col-lg-12 mt-2">
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
    name: 'HoraLigas',
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
                nombre: '',
                horas: '',
                precio: '',
                fecha: '',
                estado: '',
                idGimnasio: '',
            },

            disabled: {
                nombre: false,
                horas: false,
                precio: false,
                fecha: false,
                estado: false,
                idGimnasio: false,
            },

            msgError: {
                nombre: '',
                horas: '',
                precio: '',
                fecha: '',
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
            this.$refs.modalHoraLiga.hide();
        },
        modalContinuar() {
            this.$refs.modalHoraLiga.hide();
        },
        buscar(e) {
            console.log(e, 'escucho');
        },
        agregarHoraLiga() {
            this.desbloquearCampos()
            this.btnContinuar = true;

            this.editando = false;
            this.creando = true;
            this.viendo = false;

            this.tutiloModal = 'Agregar HoraLiga'
            this.$refs.modalHoraLiga.show();
        },
        editatHoraLiga() {
            this.desbloquearCampos()
            this.btnContinuar = true;

            this.editando = true;
            this.creando = false;
            this.viendo = false;

            this.tutiloModal = 'Actualizar HoraLiga'
            this.$refs.modalHoraLiga.show();
        },
        verHoraLiga() {
            this.bloquearCampos()
            this.btnContinuar = false;

            this.editando = false;
            this.creando = false;
            this.viendo = true;

            this.tutiloModal = 'Ver HoraLiga'
            this.$refs.modalHoraLiga.show();
        },
        eliminarHoraLiga() {
            console.log('eliminar');
        },
        bloquearCampos() {
            this.disabled.nombre = true;
            this.disabled.horas = true;
            this.disabled.precio = true;
            this.disabled.fecha = true;
            this.disabled.idGimnasio = true;
            this.disabled.estado = true;
        },
        desbloquearCampos() {
            this.disabled.nombre = false;
            this.disabled.horas = false;
            this.disabled.precio = false;
            this.disabled.fecha = false;
            this.disabled.idGimnasio = false;
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
