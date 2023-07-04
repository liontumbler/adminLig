<template>
    <input class="form-check-input" :aria-describedby="'error'" type="checkbox"
        :required="required"
        :checked="value"
        @input="updateValue">
    <div :id="'error'" class="form-text text-danger" v-if="showError">{{ errorInput }}</div>
</template>
<script>
export default {
    name:'inputp',
    props :{
        value:{
            type: String,
            default: ''
        },
        required: {
            type: Boolean,
            default: false,
        },
    },
    data() {
        return {
            showError: false,
            errorInput: '',
        };
    },
    methods:{
        updateValue(e) {
            console.log(this.value, this.val, e.target.value);
            this.$emit('model', e.target.checked);
            let campo = e.target;
            this.validarError(campo)
        },
        validarError(campo) {
            if (!campo.checked && campo.required) {
                this.showError = true;
                campo.setCustomValidity('');
                console.log(campo.validationMessage);
                this.errorInput = campo.validationMessage;
                return;
            }

            this.showError = false;
            this.errorInput = '';
        }
    }
}
</script>
