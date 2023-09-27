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
                        <i class="bi bi-eye-fill ms-1" @click="cargando ? null : $emit('ver', i)" :class="{'campo-disabled': cargando}"></i>
                        <i class="bi bi-pencil-fill ms-1" @click="cargando ? null : $emit('editar', i, data['id'])" :class="{'campo-disabled': cargando}"></i>
                        <i class="bi bi-x-lg ms-1" @click="cargando ? null : $emit('eliminar', data['id'])" :class="{'campo-disabled': cargando}"></i>
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
        url: String,
        cabecera: Object
    },
    async mounted() {
        this.datatable = await cargarDatos(this.url);
    },
    data() {
        return {
            datatable: [],
            cargando: false
        };
    },
}
</script>
