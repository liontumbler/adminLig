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
                        :id="'nickname'"
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
                        :id="'clave'"
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
                        :id="'caja'"
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
                        <button class="btn btn-primary" type="button" @click="trabajar" :disabled="btnDisabledTrabajar">Trabajar</button>
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
import { Methods } from "../services/methods.js";
import inputp from "../components/controls/input.vue";
import modalp from "../components/controls/modal.vue";

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
            btnDisabledTrabajar: false,
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

                let validCampos = await Methods.validarCampos(this, array);
                if (valid && validCampos) {
                    let data = await Methods.armardatos(this, array);

                    console.log('b', data);
                    this.btnDisabledTrabajar = true;
                    let rdta = await ApiService.post(urlLogin, data);
                    this.btnDisabledTrabajar = false;
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
                    console.log(validCampos, valid, 'valor valido');
                    //no es valido
                    if (!valid) {
                        this.msgError = 'Validar reCAPTCHA';
                        this.$refs.modalError.show();
                    }
                }
            }, 'recaptcha');
        },
    },
};
</script>
