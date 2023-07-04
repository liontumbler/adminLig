<template>
    <input class="form-control" :aria-describedby="'error'"
    :value="value"
    :type="type"
    :placeholder="placeholder"
    :title="placeholder"
    :minlength="minlength"
    :maxlength="maxlength"
    :min="min"
    :max="max"
    :required="required"
    :textarroba="textarroba"
    @input="updateValue">
    <div :id="'error'" class="form-text text-danger" v-if="showError">{{ errorInput }}</div>
</template>
<script>
export default {
    name:'inputp',
    props :{
        type:{
            type: String,
            default: 'text'
        },
        value:{
            type: String,
            default: ''
        },
        placeholder: {
            type: String,
            default: 'Ingrese el valor',
        },
        minlength:{
            type: Number,
            default: 0
        },
        maxlength: {
            type: Number,
            default: 1000,
        },
        min:{
            type: String,
            default: '0'
        },
        max: {
            type: String,
            default: '10000000',
        },
        required: {
            type: Boolean,
            default: false,
        },
        textarroba: {
            type: Boolean,
            default: false,
        },
    },
    mounted() {
        if (this.textarroba) {
            this.$refs[this.id].addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9A-Za-zñÑ@]/g, '').replace(/[@]{2,}/g, '@');
            });
            console.log(this, this.value, this.$refs);
        }
    },
    data() {
        return {
            showError: false,
            errorInput: '',
        };
    },
    methods:{
        updateValue(e) {
            console.log(this.value, e.target, 'rrr');

            this.$emit('model', e.target.value);

            let campo = e.target;
            this.validarError(campo)
        },
        validarError(campo){
            //if (!e.altKey && !e.ctrlKey) {

            console.log(campo.value, this.value);
            if (!campo.value && campo.required) {
                this.showError = true;
                campo.setCustomValidity('');
                console.log(campo.validationMessage);
                this.errorInput = campo.validationMessage;
                return;
            }

            if(campo.type == 'number'){
                const numeroMax = campo.max.indexOf(',') >= 0 ? parseFloat(campo.max) : parseInt(campo.max);
                const numeroMin = campo.min.indexOf(',') >= 0 ? parseFloat(campo.min) : parseInt(campo.min);
                const numerovalue = campo.value.indexOf(',') >= 0 ? parseFloat(campo.value) : parseInt(campo.value);

                if(campo.max && numerovalue > numeroMax){
                    this.showError = true;
                    this.errorInput = campo.validationMessage;
                    return;
                }else if(campo.min && numerovalue < numeroMin){
                    this.showError = true;
                    this.errorInput = campo.validationMessage;
                    return;
                }
            }

            if (campo.type == 'number') {

            }

            if (campo.type == 'password') {
                if (campo.value.length < 8) {
                    this.showError = true;
                    this.errorInput = 'la password es menor a 8 caracteres';
                    return;
                }

                const lowercaseCount = (campo.value.match(/[a-z]/g) || []).length;
                const uppercaseCount = (campo.value.match(/[A-Z]/g) || []).length;
                const numberCount = (campo.value.match(/[0-9]/g) || []).length;
                const specialCharCount = (campo.value.match(/[^a-zA-Z0-9 ]/g) || []).length;
                if (
                    lowercaseCount < 2 ||
                    uppercaseCount < 2 ||
                    numberCount < 2 ||
                    specialCharCount < 2
                ) {
                    this.showError = true;
                    this.errorInput = 'la password debe tener 2 mayusculas, 2 minusculas, 2 numeros, 2 caracteres especiales no importa el orden';
                    return;
                }
            }

            if(campo.type == 'text' || campo.type == 'number' || campo.type == 'password'){
                if(campo.value && campo.getAttribute('maxlength') && parseInt(campo.value.length) > parseInt(campo.getAttribute('maxlength'))){
                    this.showError = true;
                    this.errorInput = (campo.validationMessage ? campo.validationMessage : 'Error en maximo de caracteres');
                    return;
                } else if(campo.value && campo.getAttribute('minlength') && parseInt(campo.value.length) < parseInt(campo.getAttribute('minlength'))){
                    this.showError = true;
                    this.errorInput = (campo.validationMessage ? campo.validationMessage : 'Error en minimo de caracteres');
                    return;
                }
            }
            //console.log('dos');
            if (campo.type == 'email' && campo.value) {
                let validacion1 = '([a-zA-Z0-9]{1,50}[\\_\\-\\.]?[a-zA-Z0-9]{1,50}){1,100}';
                let validacion2 = '[a-zA-Z]{2,5}$';
                let cadena = '^'+ validacion1 +'@'+ validacion1 +'\\.'+ validacion2 +'';
                let expreg = new RegExp(cadena);
                if(!expreg.test(campo.value)){
                    this.showError = true;
                    this.errorInput = (campo.validationMessage ? campo.validationMessage : 'Correo invalido');
                    return;
                }
            }

            if (this.textarroba) {
                if (!campo.value.includes('@')) {
                    console.log(campo.value, '@');
                    this.showError = true;
                    this.errorInput = 'debe tener minimo un @';
                    return;
                }
            }
            //console.log('tres');

            this.showError = false;
            this.errorInput = '';
        }
    }
}
</script>
