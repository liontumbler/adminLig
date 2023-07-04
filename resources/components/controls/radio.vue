<template>
    <div class="form-check" v-for="(radio, i) in radios" :key="i">
        <input class="form-check-input" type="radio"
            :id="name +i"
            :value="radio.value"
            :checked="radio.checked"
            :required="required"
            :name="name"
            @input="updateValue"
        >
        <label class="form-check-label" :for="name +i">
            {{ radio.label }}
        </label>
    </div>
    <div :id="'error'" class="form-text text-danger" v-if="showError">{{ errorInput }}</div>
</template>
<script>
export default {
    name:'inputp',
    mounted() {
        console.log('radios', this.radios);
    },
    props :{
        radios:{
            type: Array,
            default: []
        },
        value:{
            type: String,
            default: ''
        },
        required: {
            type: Boolean,
            default: false,
        },
        name:{
            type: String,
            default: ''
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
            this.$emit('model', e.target.value);
        },
        /*validarError(campo) {
            if (!campo.checked && campo.required) {
                this.showError = true;
                campo.setCustomValidity('');
                console.log(campo.validationMessage);
                this.errorInput = campo.validationMessage;
                return;
            }

            this.showError = false;
            this.errorInput = '';
        }*/
    }
}
</script>
