<template>
    <div class="m-4">
        <div class="container shadow">
            <div class="row p-5">
                <div class="col-lg-12 mb-1">
                    <img src="img/adminLig.svg" alt="Nocarga" class="w-50 d-block m-auto">
                </div>
                <div class="col-lg-12 mb-1">
                    <label for="nickname" class="form-label">Nickname *</label>
                    <input-component
                        ref="nickname"
                        :id="'nickname'"
                        :type="'text'"
                        :value="''"
                        :minlength="1"
                        :maxlength="50"
                        :required="true"
                        :textarroba="true"
                        :placeholder="'Digite la nickname del trabajador'"
                    ></input-component>
                </div>
                <div class="col-lg-6 mb-1">
                    <label for="clave" class="form-label">Clave *</label>
                    <input-component
                        ref="clave"
                        :id="'clave'"
                        :type="'password'"
                        :value="''"
                        :minlength="1"
                        :maxlength="50"
                        :required="true"
                        :placeholder="'Digite la clave del trabajador'"
                    ></input-component>
                </div>
                <div class="col-lg-6 mb-2" v-if="login == 'trabajador'">
                    <label for="caja" class="form-label">Caja *</label>
                    <input-component
                        ref="caja"
                        :id="'caja'"
                        :type="'number'"
                        :value="'0'"
                        :minlength="1"
                        :maxlength="50"
                        :min="0"
                        :max="1000000"
                        :required="true"
                        :placeholder="'Digite el monto del efectivo'"
                    ></input-component>
                </div>
                <div class="col-lg-12 mb-1">
                    <div id="recaptcha"></div>
                </div>
                <div class="col-lg-12 mb-1">
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary" type="button" @click="trabajar">Trabajar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { RecaptchaV2 } from '../js/libs/RecaptchaV2/recaptchaV2.js';
import { ApiService } from "../services/services.js";
import inputp from "../components/controls/input.vue";

export default {
    name: 'login',
    components: {
        "input-component": inputp,
    },
    props: {
        login: {
            type: String,
            default: () => "",
        },
    },
    mounted() {
        let div = document.getElementById('recaptcha');
        this.recapchav2 = new RecaptchaV2(div, '6LffswQmAAAAADb0opnrrlP95wkElZdk5jGmvg2V');
    },
    data() {
        return {
            recapchav2: null,
        }
    },
    methods: {
        trabajar(e) {
            this.recapchav2.validarRV2S(async (valid) => {
                console.log(this.$refs.nickname.$refs, 'ref');
                let validCampos = false;
                let urlLogin = 'loginAdmin';
                if (this.login == 'trabajador') {
                    urlLogin = 'loginTrabajador';
                    validCampos = this.validarCampos([this.$refs.nickname, this.$refs.clave, this.$refs.caja])
                }else{
                    validCampos = this.validarCampos([this.$refs.nickname, this.$refs.clave])
                }

                console.log(validCampos, valid);
                if (valid && validCampos ) {//== true
                    let data = this.armardatos([this.$refs.nickname, this.$refs.clave]);
                    console.log('b', data);

                    let rdta = await ApiService.post(urlLogin, data)
                    console.log(rdta);

                }else{
                    //no es valido
                    console.log('m');
                }
            }, 'recaptcha');
        },
        armardatos(arrayCampos) {
            let dataReturn = {};
            arrayCampos.forEach(campo => {
                dataReturn[campo.id] = campo.value
            });
            return dataReturn;
        },
        validarCampos(arrayCampos) {
            for (let i = 0; i < arrayCampos.length; i++) {
                let ref = arrayCampos[i]
                let campo = ''
                for (const e in arrayCampos[i].$refs) {
                    campo = arrayCampos[i].$refs[e];
                }
                console.log(campo, ref.textarroba);

                if (!campo.value && campo.required) {
                    campo.setCustomValidity(campo.validationMessage);
                    campo.focus();
                    if (campo.select)
                        campo.select();

                    return campo;
                }

                if(campo.type == 'number'){
                    const numeroMax = campo.max.indexOf(',') >= 0 ? parseFloat(campo.max) : parseInt(campo.max);
                    const numeroMin = campo.min.indexOf(',') >= 0 ? parseFloat(campo.min) : parseInt(campo.min);
                    const numerovalue = campo.value.indexOf(',') >= 0 ? parseFloat(campo.value) : parseInt(campo.value);

                    if(campo.max && numerovalue > numeroMax){
                        campo.setCustomValidity(campo.validationMessage);
                        campo.focus();
                        if (campo.select)
                            campo.select();

                        return campo;
                    }else if(campo.min && numerovalue < numeroMin){
                        campo.setCustomValidity(campo.validationMessage);
                        campo.focus();
                        if (campo.select)
                            campo.select();

                        return campo;
                    }
                }

                if (campo.type == 'password') {
                    if (campo.value.length < 8) {
                        campo.setCustomValidity('la password es menor a 8 caracteres');
                        campo.focus();
                        if (campo.select)
                            campo.select();

                        return campo;
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
                        campo.setCustomValidity('la password debe tener 2 mayusculas, 2 minusculas, 2 numeros, 2 caracteres especiales no importa el orden');
                        campo.focus();
                        if (campo.select)
                            campo.select();

                        return campo;
                    }
                }

                console.log('uno');
                if(campo.type == 'text' || campo.type == 'number' || campo.type == 'password'){
                    if(campo.value && campo.getAttribute('maxlength') && parseInt(campo.value.length) > parseInt(campo.getAttribute('maxlength'))){
                        campo.setCustomValidity((campo.validationMessage ? campo.validationMessage : 'Error en maximo de caracteres'));
                        campo.focus();
                        if (campo.select)
                            campo.select();

                        return campo;
                    } else if(campo.value && campo.getAttribute('minlength') && parseInt(campo.value.length) < parseInt(campo.getAttribute('minlength'))){
                        campo.setCustomValidity((campo.validationMessage ? campo.validationMessage : 'Error en minimo de caracteres'));
                        campo.focus();
                        if (campo.select)
                            campo.select();

                        return campo;
                    }
                }
                console.log('dos');
                if (campo.type == 'email' && campo.value) {
                    let validacion1 = '([a-zA-Z0-9]{1,50}[\\_\\-\\.]?[a-zA-Z0-9]{1,50}){1,100}';
                    let validacion2 = '[a-zA-Z]{2,5}$';
                    let cadena = '^'+ validacion1 +'@'+ validacion1 +'\\.'+ validacion2 +'';
                    let expreg = new RegExp(cadena);
                    if(!expreg.test(campo.value)){
                        campo.setCustomValidity((campo.validationMessage ? campo.validationMessage : 'Correo invalido'));
                        campo.focus();
                        if (campo.select)
                            campo.select();

                        return campo;
                    }
                }
                console.log('tres');

                if (ref.textarroba) {
                    if (!campo.value.includes('@')) {
                        campo.setCustomValidity('debe tener minimo un @');
                        campo.focus();
                        if (campo.select)
                            campo.select();

                        return campo;
                    }
                }

                console.log('cuatro');
            }

            return true;
        }
    },
};
</script>
