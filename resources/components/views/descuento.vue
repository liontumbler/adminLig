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
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Título</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Acción</th>
                        </tr>
                    </thead>
                    <tbody id="contenidoDescuento">
                        <tr>
                            <th scope="row">1</th>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                            <td>
                                <i class="bi bi-eye-fill ms-1" @click="verDescuento"></i>
                                <i class="bi bi-pencil-fill ms-1" @click="editatDescuento"></i>
                                <i class="bi bi-x-lg ms-1" @click="eliminarDescuento"></i>
                            </td>
                        </tr>
                    </tbody>
                </table>
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
                        <input type="text" class="form-control" id="titulo" v-model="titulo" :disabled="tituloDisabled">
                        <div id="tituloError" v-show="tituloError" class="form-text text-danger">{{ msgErrorTitulo }}</div>
                    </div>
                    <div class="col-lg-6 mb-1">
                        <label for="total" class="form-label">Total</label>
                        <input type="number" class="form-control" id="total" v-model="total" :disabled="totalDisabled">
                        <div id="totalError" v-show="totalError" class="form-text text-danger">{{ msgErrorTotal }}</div>
                    </div>
                    <div class="col-lg-6 mb-1">
                        <label for="fecha" class="form-label">fecha</label>
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
                    <div class="col-lg-6 mb-1">
                        <label for="idTrabajado" class="form-label">idTrabajado</label>
                        <select class="form-select" id="idTrabajado" v-model="idTrabajado" :disabled="idTrabajadoDisabled">
                            <option value="" selected>{{ textSelectGeneral }}</option>
                            <option v-for="(option, index) in optionsIdTrabajado" :value="option.value" :key="index">
                                {{ option.text }}
                            </option>
                        </select>
                        <div id="idTrabajadoError" v-show="idTrabajadoError" class="form-text text-danger">{{ msgErrorIdTrabajado }}</div>
                    </div>
                    <div class="col-lg-6 mb-1">
                        <label for="idTrabajador" class="form-label">idTrabajador</label>
                        <select class="form-select" id="idTrabajador" v-model="idTrabajador" :disabled="idTrabajadorDisabled">
                            <option value="" selected>{{ textSelectGeneral }}</option>
                            <option v-for="(option, index) in optionsIdTrabajador" :value="option.value" :key="index">
                                {{ option.text }}
                            </option>
                        </select>
                        <div id="idTrabajadorError" v-show="idTrabajadorError" class="form-text text-danger">{{ msgErrorIdTrabajador }}</div>
                    </div>
                    <div class="col-lg-12 mb-1">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" id="descripcion" rows="3" v-model="descripcion" :disabled="descripcionDisabled"></textarea>
                        <div id="descripcionError" v-show="descripcionError" class="form-text text-danger">{{ msgErrorDescripcion }}</div>
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
    name: 'Descuentos',
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

            titulo: '',
            tituloError: false,
            msgErrorTitulo: '',
            tituloDisabled: false,

            descripcion: '',
            descripcionError: false,
            msgErrorDescripcion: '',
            descripcionDisabled: false,

            total: '',
            totalError: false,
            msgErrorTotal: '',
            totalDisabled: false,

            estado: false,
            estadoError: false,
            msgErrorEstado: '',
            estadoDisabled: false,

            fecha: '',
            fechaError: false,
            msgErrorFecha: '',
            fechaDisabled: false,

            optionsIdGimnasio:[
                {text: 'text', value: 1}
            ],
            idGimnasio: '',
            idGimnasioError: false,
            msgErrorIdGimnasio: '',
            idGimnasioDisabled: false,

            optionsIdTrabajado:[
                {text: 'text', value: 1}
            ],
            idTrabajado: '',
            idTrabajadoError: false,
            msgErrorIdTrabajado: '',
            idTrabajadoDisabled: false,

            optionsIdTrabajador:[
                {text: 'text', value: 1}
            ],
            idTrabajador: '',
            idTrabajadorError: false,
            msgErrorIdTrabajador: '',
            idTrabajadorDisabled: false,
        }
    },
    methods: {
        modalCerrar() {
            this.$refs.modalDescuento.hide();
        },
        modalContinuar() {
            this.$refs.modalDescuento.hide();
        },
        buscar(e) {
            console.log(e, 'escucho');
        },
        agregarDescuento() {
            this.desbloquearCampos()
            this.btnContinuar = true;

            this.editando = false;
            this.creando = true;
            this.viendo = false;

            this.tutiloModal = 'Agregar Descuento'
            this.$refs.modalDescuento.show();
        },
        editatDescuento() {
            this.desbloquearCampos()
            this.btnContinuar = true;

            this.editando = true;
            this.creando = false;
            this.viendo = false;

            this.tutiloModal = 'Actualizar Descuento'
            this.$refs.modalDescuento.show();
        },
        verDescuento() {
            this.bloquearCampos()
            this.btnContinuar = false;

            this.editando = false;
            this.creando = false;
            this.viendo = true;

            this.tutiloModal = 'ver Descuento'
            this.$refs.modalDescuento.show();
        },
        eliminarDescuento() {
            console.log('eliminar');
        },
        bloquearCampos() {
            this.tituloDisabled = true;
            this.descripcionDisabled = true;
            this.totalDisabled = true;
            this.fechaDisabled = true;
            this.idGimnasioDisabled = true;
            this.idTrabajadoDisabled = true;
            this.idTrabajadorDisabled = true;
            this.estadoDisabled = true;
        },
        desbloquearCampos() {
            this.tituloDisabled = false;
            this.descripcionDisabled = false;
            this.totalDisabled = false;
            this.fechaDisabled = false;
            this.idGimnasioDisabled = false;
            this.idTrabajadoDisabled = false;
            this.idTrabajadorDisabled = false;
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
