<template>
    <div class="m-4">
        <div class="shadow d-block m-auto w-75">
            <div class="row p-5">
                <div class="col-lg-12 mb-1">
                    <img src="img/adminLig.svg" alt="Nocarga" class="w-50 d-block m-auto">
                </div>
                <div class="col-lg-12 mb-1">
                    <label for="nickname" class="form-label">Nickname *</label>
                    <input-component
                        :type="'text'"
                        :minlength="1"
                        :maxlength="50"
                        :required="true"
                        :textarroba="true"
                        :placeholder="'Digite la nickname del trabajador'"
                        ref="nickname"
                        :value="nickname"
                        @model="updateNickname"
                    ></input-component>
                </div>
                <div :class="cajaSize">
                    <label for="clave" class="form-label">Clave *</label>
                    <input-component
                        :type="'password'"
                        :minlength="1"
                        :maxlength="50"
                        :required="true"
                        :placeholder="'Digite la clave del trabajador'"
                        ref="clave"
                        :value="clave"
                        @model="updateClave"
                    ></input-component>
                </div>
                <div class="col-lg-6 mb-2" v-if="login == 'trabajador'">
                    <label for="caja" class="form-label">Caja *</label>
                    <input-component
                        :type="'number'"
                        :minlength="1"
                        :maxlength="50"
                        :min="'0'"
                        :max="'1000000'"
                        :required="true"
                        :placeholder="'Digite el monto del efectivo'"
                        ref="caja"
                        :value="caja"
                        @model="updateCaja"
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
    <modal-component
        ref="modalConfirmar"
        :titulo="'confirmacion'"
        :visibleBtnCerrar="true"
        :visibleBtnContinuar="true"
        @cerrar="cerrarModalConfirmacion"
        @continuar="continuarModalConfirmacion"
    >
        {{ msgConfirmacion }}
    </modal-component>
    <modal-component
        ref="modalError"
        :titulo="'Error'"
        :visibleBtnCerrar="true"
        :visibleBtnContinuar="true"
        @cerrar="cerrarModalError"
        @continuar="continuarModalError"
    >
        {{ msgError }}
    </modal-component>
</template>
<script>
import { RecaptchaV2 } from '../js/libs/RecaptchaV2/recaptchaV2.js';
import { ApiService } from "../services/services.js";
import inputp from "../components/controls/input.vue";
import modalp from "../components/controls/modal.vue"

export default {
    name: 'login',
    components: {
        "input-component": inputp,
        "modal-component": modalp,
    },
    props: {
        login: {
            type: String,
            default: "",
        },
    },
    mounted() {
        let div = document.getElementById('recaptcha');
        this.recapchav2 = new RecaptchaV2(div, '6LffswQmAAAAADb0opnrrlP95wkElZdk5jGmvg2V');
        if (this.login == 'trabajador') {
            console.log(this.login, 'puta');
            this.cajaSize = 'col-lg-6 mb-1'
        }
    },
    data() {
        return {
            recapchav2: null,
            cajaSize: 'col-lg-12 mb-1',
            msgError: '',
            msgConfirmacion: '',
            nickname: '',
            clave: '',
            caja: '0',
        }
    },
    methods: {
        updateNickname(value) {
            this.nickname = value;
        },
        updateClave(value) {
            this.clave = value;
        },
        updateCaja(value) {
            this.caja = value;
        },
        cerrarModalConfirmacion(){
            this.$refs.modalConfirmar.hide();
            if (this.login == 'trabajador') {
                location.href = 'homeTrabajador';
            }else{
                location.href = 'homeAdmin';
            }
        },
        continuarModalConfirmacion(){
            if (this.login == 'trabajador') {
                location.href = 'homeTrabajador';
            }else{
                location.href = 'homeAdmin';
            }
        },
        cerrarModalError(){
            this.$refs.modalError.hide();
        },
        continuarModalError(){
            this.$refs.modalError.hide();
        },
        trabajar(e) {
            this.recapchav2.validarRV2S(async (valid) => {
                console.log(this.nickname, 'ref');

                let array = []
                let urlLogin = 'loginAdm';
                if (this.login == 'trabajador') {
                    urlLogin = 'loginTra';
                    array = ['nickname', 'clave', 'caja']
                }else{
                    array = ['nickname', 'clave']
                }

                let validCampos = this.validarCampos(array)

                console.log(validCampos, valid);
                if (valid && validCampos) {
                    let data = this.armardatos(array);

                    console.log('b', data);

                    let rdta = await ApiService.post(urlLogin, data)
                    console.log(rdta);

                    if (rdta == true) {
                        this.msgConfirmacion = 'Inicio sesión correctamente';
                        this.$refs.modalConfirmar.show();
                    }else{
                        if (rdta == 600) {
                            this.msgConfirmacion = 'Ya se inició una sesión anterior, por lo que se inició una caja, pero no sé cerro, por lo que lo llevaremos a la sesión anterior hasta que cierre caja';
                            this.$refs.modalConfirmar.show();
                        }else{
                            this.msgError = 'Hubo un error en los datos';
                            this.$refs.modalError.show();
                        }
                    }
                }else{
                    //no es valido
                    this.msgError = 'Hay campos sin validar';
                    this.$refs.modalError.show();
                }
            }, 'recaptcha');
        },
        armardatos(arrayCampos) {
            let data = {}
            arrayCampos.forEach(campo => {
                data[campo] = this[campo]
            });
            return data;
        },
        validarCampos(arrayCampos) {
            console.log('validarCampos', arrayCampos);
            for (let i = 0; i < arrayCampos.length; i++) {
                console.log('campo', typeof this.$refs[arrayCampos[i]], this.$refs[arrayCampos[i]].$refs.input);
                if (this.$refs[arrayCampos[i]].$refs.input) {
                    let ref = this.$refs[arrayCampos[i]];
                    let campo = this.$refs[arrayCampos[i]].$refs.input

                    if (!campo.value && campo.required) {
                        campo.setCustomValidity(campo.validationMessage);
                        campo.focus();
                        if (campo.select)
                            campo.select();

                        return false;
                    }

                    if(campo.type == 'select-one'){

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

                            return false;
                        }else if(campo.min && numerovalue < numeroMin){
                            campo.setCustomValidity(campo.validationMessage);
                            campo.focus();
                            if (campo.select)
                                campo.select();

                            return false;
                        }
                    }

                    if (campo.type == 'password') {
                        if (campo.value.length < 8) {
                            campo.setCustomValidity('la password es menor a 8 caracteres');
                            campo.focus();
                            if (campo.select)
                                campo.select();

                            return false;
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

                            return false;
                        }
                    }

                    if(campo.type == 'text' || campo.type == 'number' || campo.type == 'password'){
                        if(campo.value && campo.getAttribute('maxlength') && parseInt(campo.value.length) > parseInt(campo.getAttribute('maxlength'))){
                            campo.setCustomValidity((campo.validationMessage ? campo.validationMessage : 'Error en maximo de caracteres'));
                            campo.focus();
                            if (campo.select)
                                campo.select();

                            return false;
                        } else if(campo.value && campo.getAttribute('minlength') && parseInt(campo.value.length) < parseInt(campo.getAttribute('minlength'))){
                            campo.setCustomValidity((campo.validationMessage ? campo.validationMessage : 'Error en minimo de caracteres'));
                            campo.focus();
                            if (campo.select)
                                campo.select();

                            return false;
                        }
                    }

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

                            return false;
                        }
                    }

                    if (ref.textarroba) {
                        if (!campo.value.includes('@')) {
                            campo.setCustomValidity('debe tener minimo un @');
                            campo.focus();
                            if (campo.select)
                                campo.select();

                            return false;
                        }
                    }
                }else{
                    console.log('no tiene type');
                    console.log(arrayCampos[i]);
                    if (!this[arrayCampos[i]]) {
                        return false;
                    }
                }
            }

            return true;
        }
    },
};
</script>
