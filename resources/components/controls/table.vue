<template>
    <table class="table">
        <thead>
            <tr>
                <td v-for="(cabe, index) in cabecera" :key="index">
                    {{ cabe.text }}
                </td>
            </tr>
        </thead>
        <tbody id="contenidoDescuento">
            <tr v-for="(data, i) in datatable" :key="i">
                <td v-for="(cabe, e) in cabecera" :key="e" width="300">
                    <div v-if="cabe.type == 'text'">
                        {{ data[e] }}
                    </div>
                    <div v-if="cabe.type == 'text-large'" class="text-lage">
                        {{ data[e] }}
                    </div>
                    <div v-if="cabe.type == 'estado'">
                        <input type="checkbox" class="form-check-input" :checked="data[e] == 1 ? true : false" :disabled="true">
                    </div>
                    <div v-if="cabe.type == 'accion'">
                        <i class="cursor bi bi-eye-fill ms-1" v-if="r" :title="titleVer" @click="cargando ? null : $emit('ver', i)" :class="{'campo-disabled': cargando}"></i>
                        <i class="cursor bi bi-pencil-fill ms-1" v-if="u" :title="titleEditar" @click="cargando ? null : $emit('editar', i, data['id'])" :class="{'campo-disabled': cargando}"></i>
                        <i class="cursor bi bi-x-lg ms-1" v-if="d" :title="titleEliminar" @click="cargando ? null : $emit('eliminar', data['id'])" :class="{'campo-disabled': cargando}"></i>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</template>
<script>
import { cargarDatos } from "../../services/servicesApi.js";

export default {
    name:'table',
    props :{
        title:{
            type: String,
            default: ''
        },
        url: String,
        cabecera: Object,
        r: {
            type: Boolean,
            default: true,
        },
        u: {
            type: Boolean,
            default: true,
        },
        d: {
            type: Boolean,
            default: true,
        }
    },
    async mounted() {
        await this.cargarTabla();
    },
    data() {
        return {
            datatable: [],
            cargando: false,
            titleVer: 'Ver ' + this.title,
            titleEditar: 'Editar ' + this.title,
            titleEliminar: 'Eliminar ' + this.title
        };
    },
    methods: {
        async cargarTabla() {
            this.datatable = await cargarDatos(this.url);
        }
    },
}
</script>
