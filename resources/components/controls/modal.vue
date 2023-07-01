<template>
    <div v-if="mostrar" class="modal fade show modal__general" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDefaultLabel">{{ titulo }}</h5>
                    <button type="button" class="btn-close" aria-label="Close" @click="$emit('cerrar')"></button>
                </div>
                <div class="modal-body">
                    <slot></slot>
                </div>
                <div class="modal-footer">
                    <button v-if="visibleBtnCerrar" type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="$emit('cerrar')">{{ msjBtnCerrar }}</button>
                    <button v-if="visibleBtnContinuar" type="button" class="btn btn-primary" @click="$emit('continuar')">{{ msjBtnContinuar }}</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name:'ModalDefault',
    props :{
        titulo:{
            type: String,
            default: ''
        },
        msjBtnCerrar:{
            type: String,
            default: 'Cerrar'
        },
        msjBtnContinuar:{
            type: String,
            default: 'continuar'
        },
        visibleBtnCerrar:{
            type: Boolean,
            default: false
        },
        visibleBtnContinuar:{
            type: Boolean,
            default: false
        },
    },
    data() {
        return {
            mostrar: false
        };
    },
    methods:{
        hide() {
            this.mostrar = false;
        },
        show() {
            this.mostrar = true;
        }
    }
}
</script>
<style>
.modal__general{
    display: block;
    background: #00000091;
}
</style>
