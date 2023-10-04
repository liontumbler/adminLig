<template>
    <div class="m-4">
        <div class="container">
            <div class="row">
                <div class="d-grid gap-2 col-lg-3 mb-1">
                    <button type="button" class="btn btn-primary" @click="agregarProducto">Agregar</button>
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
            <div class="tableProducto">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Precio</th>
                            <th scope="col">Acción</th>
                        </tr>
                    </thead>
                    <tbody id="contenidoProducto">
                        <tr>
                            <th scope="row">1</th>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                            <td>
                                <i class="bi bi-eye-fill ms-1" @click="verProducto"></i>
                                <i class="bi bi-pencil-fill ms-1" @click="editatProducto"></i>
                                <i class="bi bi-x-lg ms-1" @click="eliminarProducto"></i>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <modal-component
                ref="modalProducto"
                :titulo="tutiloModal"
                :visibleBtnCerrar="true"
                :visibleBtnContinuar="btnContinuar"
                @cerrar="modalCerrar"
                @continuar="modalContinuar"
            >
                <div class="row">
                    <div class="col-lg-6 mb-1">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" ref="nombre" v-model="campos.nombre" :disabled="disabled.nombre">
                        <div id="nombreError" v-show="msgError.nombre" class="form-text text-danger">{{ msgError.nombre }}</div>
                    </div>
                    <div class="col-lg-6 mb-1">
                        <label for="precio" class="form-label">Precio</label>
                        <input type="number" class="form-control" id="precio" ref="precio" v-model="campos.precio" :disabled="disabled.precio">
                        <div id="precioError" v-show="msgError.precio" class="form-text text-danger">{{ msgError.precio }}</div>
                    </div>
                    <div class="col-lg-6 mb-1">
                        <label for="fecha" class="form-label">Fecha</label>
                        <input type="datetime-local" class="form-control" id="fecha" v-model="fecha" :disabled="disabled.fecha">
                        <div id="fechaError" v-show="fechaError" class="form-text text-danger">{{ msgErrorFecha }}</div>
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
                    <div class="col-lg-12 mb-1">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" id="descripcion" rows="3" ref="descripcion" v-model="campos.descripcion" :disabled="disabled.descripcion"></textarea>
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
    name: 'Productos',
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
                precio: '',
                fecha: '',
                estado: '',
                descripcion: '',
                idGimnasio: '',
            },

            disabled: {
                nombre: false,
                precio: false,
                fecha: false,
                estado: false,
                descripcion: false,
                idGimnasio: false,
            },

            msgError: {
                nombre: '',
                precio: '',
                fecha: '',
                estado: '',
                descripcion: '',
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
            this.$refs.modalProducto.hide();
        },
        modalContinuar() {
            this.$refs.modalProducto.hide();
        },
        buscar(e) {
            console.log(e, 'escucho');
        },
        agregarProducto() {
            this.desbloquearCampos()
            this.btnContinuar = true;

            this.editando = false;
            this.creando = true;
            this.viendo = false;

            this.tutiloModal = 'Agregar Producto'
            this.$refs.modalProducto.show();
        },
        editatProducto() {
            this.desbloquearCampos()
            this.btnContinuar = true;

            this.editando = true;
            this.creando = false;
            this.viendo = false;

            this.tutiloModal = 'Actualizar Producto'
            this.$refs.modalProducto.show();
        },
        verProducto() {
            this.bloquearCampos()
            this.btnContinuar = false;

            this.editando = false;
            this.creando = false;
            this.viendo = true;

            this.tutiloModal = 'ver Producto'
            this.$refs.modalProducto.show();
        },
        eliminarProducto() {
            console.log('eliminar');
        },
        bloquearCampos() {
            this.disabled.nombre = true;
            this.disabled.precio = true;
            this.disabled.fecha = true;
            this.disabled.descripcion = true;
            this.disabled.idGimnasio = true;
            this.disabled.estado = true;
        },
        desbloquearCampos() {
            this.disabled.nombre = false;
            this.disabled.precio = false;
            this.disabled.fecha = false;
            this.disabled.descripcion = false;
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
