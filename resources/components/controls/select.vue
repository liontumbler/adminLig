<template>
    <select class="form-select" :aria-describedby="'error'+id"
        :ref="id"
        :id="id"
        :title="predeterminado.text"
        :required="required"
        :value="value"
        @input="updateValue"
    >
        <option selected :value="predeterminado.value">{{ predeterminado.text }}</option>
        <option v-for="(option, index) in options" :value="option.value" :key="index">
            {{ option.text }}
        </option>
    </select>
    <div :id="'error'+id" class="form-text text-danger" v-if="showError">{{ errorInput }}</div>
</template>
<script>
export default {
    name:'select',
    props :{
        id:{
            type: String,
            default: 'text'
        },
        value:{
            type: String,
            default: ''
        },
        predeterminado:{
            type: Object,
            default: {}
        },
        options:{
            type: Array,
            default: []
        },
        required: {
            type: Boolean,
            default: false,
        },
    },
    data() {
        return{
            showError: false,
            errorInput: '',
        };
    },
    methods: {
        updateValue(e) {
            this.$emit('model', e.target.value);

            let campo = e.target;
            this.validarError(campo)
        },
        validarError(campo) {
            console.log(campo.value, this.value);
            if (!campo.value && campo.required) {
                this.showError = true;
                campo.setCustomValidity('');
                console.log(campo.validationMessage);
                this.errorInput = campo.validationMessage;
                return;
            }

            this.showError = false;
            this.errorInput = '';
        }
    },
}
</script>
