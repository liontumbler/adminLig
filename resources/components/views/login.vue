<template>
    <div class="m-4">
        <div class="shadow-lg d-block m-auto w-50 bg-white rounded">
            <div class="row px-4 py-3">
                <div class="col-lg-12 mb-1">
                    <img :src="imglogo" alt="Nocarga" class="w-49 d-block m-auto">
                </div>
                <div class="col-lg-6 mb-1">
                    <label for="nickname" class="form-label">Nickname{{ required.nickname ? '*' : '' }}</label>
                    <input type="text" class="form-control" id="nickname" :required="required.nickname" min="1" max="1000000" ref="nickname" v-model="campos.nickname" :disabled="disabled.nickname">
                    <div id="nicknameError" v-show="msgError.nickname" class="form-text text-danger text-center"><small>{{ msgError.nickname }}</small></div>
                </div>
                <div class="col-lg-6 mb-1">
                    <label for="clave" class="form-label">Clave{{ required.clave ? '*' : '' }}</label>
                    <input type="text" class="form-control" id="clave" :required="required.clave" min="1" max="1000000" ref="clave" v-model="campos.clave" :disabled="disabled.clave">
                    <div id="claveError" v-show="msgError.clave" class="form-text text-danger text-center"><small>{{ msgError.clave }}</small></div>
                </div>
                <div class="col-lg-12 mb-1" v-if="cajaVisible">
                    <label for="caja" class="form-label">Caja{{ required.caja ? '*' : '' }}</label>
                    <input type="numeric" class="form-control" id="caja" :required="required.caja" min="1" max="1000000" ref="caja" v-model="campos.caja" :disabled="disabled.caja">
                    <div id="cajaError" v-show="msgError.caja" class="form-text text-danger text-center"><small>{{ msgError.caja }}</small></div>
                </div>
                <div class="col-lg-12 mb-1">
                    <div id="recaptcha"></div>
                </div>
                <div class="col-lg-12 mb-1">
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary" type="button" @click="loginAccion" :disabled="disabledLoginAccion">{{ loginAccionText }}</button>
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
        {{ error }}
    </modal-component>
</template>
<script>
import { RecaptchaV2 } from '../../js/libs/RecaptchaV2/recaptchaV2.js';
import { ApiService } from "../../services/services.js";
import modalp from "../../components/controls/modal.vue";
import { Validador } from "../../services/validador.js";

export default {
    name: 'login',
    components: {
        "modal-component": modalp,
    },
    props: {
        login: {
            type: String,
            default: "",
        },
        imglogo: String,
        fondo: String,
    },
    mounted() {
        let div = document.getElementById('recaptcha');
        this.recapchav2 = new RecaptchaV2(div, '6LffswQmAAAAADb0opnrrlP95wkElZdk5jGmvg2V');
        let validar = [
            'nickname',
            'clave',
        ]
        if (this.login == 'trabajador') {
            console.log(this.login, 'quien es login');
            validar = [
                'nickname',
                'clave',
                'caja',
            ]
            this.cajaVisible = true
            this.loginAccionText = 'Trabajar';
        }

        let cssFondo = "background-color: "+ this.colorFondo +" !important;";
        if (this.fondo) {
            cssFondo = "background-image: linear-gradient(#000000, #00000047, #000000), url('"+this.fondo+"'); background-color: "+ this.colorFondo +" !important;"
        }
        document.querySelector('.bg-body').style.cssText = cssFondo;

        setTimeout(() => {
            this.validador = new Validador(validar);
        }, 10);
    },
    data() {
        return {
            validador: null,
            recapchav2: null,

            loginAccionText: 'Login',

            error: '',
            msgConfirmacion: '',

            disabledLoginAccion: false,
            colorFondo: '#7a7049',

            cajaVisible: false,
            required: {
                nickname: true,
                clave: true,
                caja: true
            },

            campos: {
                nickname: '',
                clave: '',
                caja: ''
            },

            disabled: {
                nickname: false,
                clave: false,
                caja: false
            },

            msgError: {
                nickname: '',
                clave: '',
                caja: ''
            },
        }
    },
    methods: {
        limpiarErrores() {
            for (const i in this.msgError) {
                this.msgError[i] = '';
            }
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
        async loginAccion(e) {
            this.limpiarErrores();
            let valido = this.validador.validarCampos();
            if (valido.msg) {
                this.msgError[valido.id] = valido.msg;
                return
            } else if (valido) {
                this.recapchav2.validarRV2S(async (valid) => {
                    if (valid) {
                        let urlLogin = 'loginAdm';
                        if (this.login == 'trabajador') {
                            urlLogin = 'loginTra';
                        }
                        this.disabledLoginAccion = true;
                        let rdta = await ApiService.post(urlLogin, this.campos);
                        this.disabledLoginAccion = false;
                        console.log(rdta);

                        if (rdta == true) {
                            this.msgConfirmacion = 'Inicio sesión correctamente';
                            this.$refs.modalConfirmar.show();
                        }else{
                            if (rdta == 600) {
                                this.msgConfirmacion = 'Ya se inició una sesión anterior, por lo que se inició una caja, pero no sé cerro, por lo que lo llevaremos a la sesión anterior hasta que cierre caja';
                                this.$refs.modalConfirmar.show();
                            }else{
                                this.error = 'Hubo un error en los datos';
                                this.$refs.modalError.show();
                            }
                        }
                    } else {
                        console.log(validCampos, valid, 'valor valido');
                        //no es valido
                        if (!valid) {
                            this.error = 'Validar reCAPTCHA';
                            this.$refs.modalError.show();
                        }
                    }
                }, 'recaptcha');
            }
        },
    },
};
</script>
<style scoped>
@media (max-width: 576px) {
    .w-50 {
        width: 100% !important;
    }
}

@media (min-width: 576px) {
    .w-50 {
        width: 100% !important;
    }
}

@media (min-width: 768px) {
    .w-50 {
        width: 75% !important;
    }
}

@media (min-width: 992px) {
    .w-50 {
        width: 50% !important;
    }
}

@media (min-width: 1200px) {
    .w-50 {
        width: 50% !important;
    }

}

@media (min-width: 1400px) {
    .w-50 {
        width: 50% !important;
    }
}

.w-49 {
    width: 49% !important;
}
</style>
<style>
@media (max-width: 576px) {
    .g-recaptcha {
        transform: scale(0.81);
        transform-origin: 0 0;
    }
}
</style>
