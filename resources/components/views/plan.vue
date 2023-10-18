<template>
    <div class="m-4">
        <div class="container">
            <div class="row">
                <div class="d-grid gap-2 col-lg-3 mb-1">
                    <button type="button" class="btn btn-primary" @click="agregarPlan">Agregar</button>
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
            <div class="tablePlan">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Acción</th>
                        </tr>
                    </thead>
                    <tbody id="contenidoPlan">
                        <tr>
                            <th scope="row">1</th>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                            <td>
                                <i class="bi bi-eye-fill ms-1" @click="verPlan"></i>
                                <i class="bi bi-pencil-fill ms-1" @click="editatPlan"></i>
                                <i class="bi bi-x-lg ms-1" @click="eliminarPlan"></i>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <modal-component
                ref="modalPlan"
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
                        <label for="trabajadores" class="form-label">Trabajadores</label>
                        <input type="number" class="form-control" id="trabajadores" min="1" max="1000" ref="trabajadores" v-model="campos.trabajadores" :disabled="disabled.trabajadores">
                        <div id="trabajadoresError" v-show="msgError.trabajadores" class="form-text text-danger">{{ msgError.trabajadores }}</div>
                    </div>
                    <div class="col-lg-6 mb-1">
                        <label for="numcamphora" class="form-label">Numero de filas horaliga</label>
                        <input type="number" class="form-control" id="numcamphora" min="1" max="10000" ref="numcamphora" v-model="campos.numcamphora" :disabled="disabled.numcamphora">
                        <div id="numcamphoraError" v-show="msgError.numcamphora" class="form-text text-danger">{{ msgError.numcamphora }}</div>
                    </div>
                    <div class="col-lg-6 mb-1">
                        <label for="ligas" class="form-label">Ligas</label>
                        <input type="number" class="form-control" id="ligas" min="1" max="10000" ref="ligas" v-model="campos.ligas" :disabled="disabled.ligas">
                        <div id="ligasError" v-show="msgError.ligas" class="form-text text-danger">{{ msgError.ligas }}</div>
                    </div>
                    <div class="col-lg-6 mb-1">
                        <label for="tienda" class="form-label">Tienda</label>
                        <input type="number" class="form-control" id="tienda" min="1" max="10000" ref="tienda" v-model="campos.tienda" :disabled="disabled.tienda">
                        <div id="tiendaError" v-show="msgError.tienda" class="form-text text-danger">{{ msgError.tienda }}</div>
                    </div>
                    <div class="col-lg-6 mb-1">
                        <label for="pagos" class="form-label">Pagos</label>
                        <input type="number" class="form-control" id="pagos" min="1" max="1000000" ref="pagos" v-model="campos.pagos" :disabled="disabled.pagos">
                        <div id="pagosError" v-show="msgError.pagos" class="form-text text-danger">{{ msgError.pagos }}</div>
                    </div>
                    <div class="col-lg-6 mb-1">
                        <label for="productos" class="form-label">Productos</label>
                        <input type="number" class="form-control" id="productos" min="1" max="10000" ref="productos" v-model="campos.productos" :disabled="disabled.productos">
                        <div id="productosError" v-show="msgError.productos" class="form-text text-danger">{{ msgError.productos }}</div>
                    </div>
                    <div class="col-lg-6 mb-1">
                        <label for="descuentos" class="form-label">Descuentos</label>
                        <input type="number" class="form-control" id="descuentos" min="1" max="10000" ref="descuentos" v-model="campos.descuentos" :disabled="disabled.descuentos">
                        <div id="descuentosError" v-show="msgError.descuentos" class="form-text text-danger">{{ msgError.descuentos }}</div>
                    </div>
                    <div class="col-lg-6 mb-1">
                        <label for="equipos" class="form-label">Equipos</label>
                        <input type="number" class="form-control" id="equipos" min="1" max="10000" ref="equipos" v-model="campos.equipos" :disabled="disabled.equipos">
                        <div id="equiposError" v-show="msgError.equipos" class="form-text text-danger">{{ msgError.equipos }}</div>
                    </div>
                    <div class="col-lg-12 mb-1">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" id="descripcion" minlength="0" maxlength="300" rows="5" ref="descripcion" v-model="campos.descripcion" :disabled="disabled.descripcion"></textarea>
                        <div id="descripcionError" v-show="msgError.descripcion" class="form-text text-danger">{{ msgError.descripcion }}</div>
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
    name: 'Plans',
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
                descripcion: '',
                trabajadores: '',
                numcamphora: '',
                ligas: '',
                tienda: '',
                pagos: '',
                productos: '',
                descuentos: '',
                equipos: '',
                estado: '',
            },

            disabled: {
                nombre: false,
                descripcion: false,
                trabajadores: false,
                numcamphora: false,
                ligas: false,
                tienda: false,
                pagos: false,
                productos: false,
                descuentos: false,
                equipos: false,
                estado: false,
            },

            msgError: {
                nombre: '',
                descripcion: '',
                trabajadores: '',
                numcamphora: '',
                ligas: '',
                tienda: '',
                pagos: '',
                productos: '',
                descuentos: '',
                equipos: '',
                estado: '',
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
            this.$refs.modalPlan.hide();
        },
        modalContinuar() {
            this.$refs.modalPlan.hide();
        },
        buscar(e) {
            console.log(e, 'escucho');
        },
        agregarPlan() {
            this.desbloquearCampos()
            this.btnContinuar = true;

            this.editando = false;
            this.creando = true;
            this.viendo = false;

            this.tutiloModal = 'Agregar Plan'
            this.$refs.modalPlan.show();
        },
        editatPlan() {
            this.desbloquearCampos()
            this.btnContinuar = true;

            this.editando = true;
            this.creando = false;
            this.viendo = false;

            this.tutiloModal = 'Actualizar Plan'
            this.$refs.modalPlan.show();
        },
        verPlan() {
            this.bloquearCampos()
            this.btnContinuar = false;

            this.editando = false;
            this.creando = false;
            this.viendo = true;

            this.tutiloModal = 'ver Plan'
            this.$refs.modalPlan.show();
        },
        eliminarPlan() {
            console.log('eliminar');
        },
        bloquearCampos() {
            this.disabled.nombre = true;
            this.disabled.descripcion = true;
            this.disabled.trabajadores = true;
            this.disabled.numcamphora = true;
            this.disabled.ligas = true;
            this.disabled.tienda = true;
            this.disabled.pagos = true;
            this.disabled.productos = true;
            this.disabled.descuentos = true;
            this.disabled.equipos = true;
            this.disabled.estado = true;
        },
        desbloquearCampos() {
            this.disabled.nombre = false;
            this.disabled.descripcion = false;
            this.disabled.trabajadores = false;
            this.disabled.numcamphora = false;
            this.disabled.ligas = false;
            this.disabled.tienda = false;
            this.disabled.pagos = false;
            this.disabled.productos = false;
            this.disabled.descuentos = false;
            this.disabled.equipos = false;
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
