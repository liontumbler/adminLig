<template>
    <div class="m-4">
        <div class="container anchoStandar">
            <div class="row">
                <div class="col-lg-12 mb-1">
                    <checkbox-component
                        ref="exiteCliente"
                        :id="'exiteCliente'"
                        :required="false"
                        v-model="exiteCliente"
                        @model="updateExiteCliente"
                    ></checkbox-component>
                    <label class="form-check-label" for="exiteCliente">
                        Cliente existe?
                    </label>
                </div>
                <div class="col-lg-12 mb-1" v-if="exiteCliente">
                    <label for="cliente" class="form-label">Clientes *</label>
                    <select-component
                        :required="true"
                        :predeterminado="{ text: 'Seleccione una opción', value: '' }"
                        :options="[
                            { text: 'Cedula de ciudadania', value: 'CC' },
                            { text: 'Tarjeta de identidad', value: 'TI' },
                        ]"
                        ref="cliente"
                        :value="cliente"
                        @model="updateCliente"
                    ></select-component>
                </div>
                <div class="col-lg-6 mb-1" v-if="!exiteCliente">
                    <label for="nombreYapellido" class="form-label">Nombre Y Apellido *</label>
                    <input-component
                        :id="'nombreYapellido'"
                        :type="'text'"
                        :minlength="1"
                        :maxlength="50"
                        :required="true"
                        :placeholder="'Nombre Y Apellido del Cliente'"
                        ref="nombreYapellido"
                        :value="nombreYapellido"
                        @model="updateNombreYapellido"
                    ></input-component>
                </div>
                <div class="col-lg-6 mb-1" v-if="!exiteCliente">
                    <label for="documento" class="form-label">Documento</label>
                    <input-component
                        :id="'documento'"
                        :type="'number'"
                        :minlength="1"
                        :maxlength="50"
                        :min="'1'"
                        :max="'999999999999'"
                        :required="false"
                        :placeholder="'Documento del Cliente'"
                        ref="documento"
                        :value="documento"
                        @model="updateDocumento"
                    ></input-component>
                </div>
                <div class="col-lg-12 mb-1" v-if="!exiteCliente">
                    <label for="equipo" class="form-label">Equipo</label>
                    <select-component
                        :id="'equipo'"
                        :required="false"
                        :predeterminado="{ text: 'Seleccione una opción', value: '' }"
                        :options="[
                            { text: 'Cedula de ciudadania', value: 'CC' },
                            { text: 'Tarjeta de identidad', value: 'TI' },
                        ]"
                        ref="equipo"
                        :value="equipo"
                        @model="updateEquipo"
                    ></select-component>
                </div>
                <div class="col-lg-12 mb-1">
                    <label for="selectHora" class="form-label">Hora *</label>
                    <select-component
                        :id="'selectHora'"
                        :required="true"
                        :predeterminado="{ text: 'Seleccione una opción', value: '' }"
                        :options="[
                            { text: 'Cedula de ciudadania', value: 'CC' },
                            { text: 'Tarjeta de identidad', value: 'TI' },
                        ]"
                        ref="selectHora"
                        :value="selectHora"
                        @model="updateSelectHora"
                    ></select-component>
                </div>
                <div class="col-lg-12 mb-1">
                    <checkbox-component
                        ref="fechaDefault"
                        :id="'fechaDefault'"
                        :required="false"
                        v-model="fechaDefault"
                        @model="updateFechaDefault"
                    ></checkbox-component>
                    <label class="form-check-label" for="fechaDefault">
                        Fecha default
                    </label>
                </div>
                <div class="col-lg-12 mb-1" v-if="!fechaDefault">
                    <label for="fechaInicio" class="form-label">Fecha Y hora de inicio *</label>
                    <input-component
                        :id="'fechaInicio'"
                        :type="'datetime-local'"
                        :min="'2018-06-07T00:00'"
                        :max="'2018-06-14T00:00'"
                        :required="true"
                        :placeholder="'fecha y hora de inicio'"
                        ref="fechaInicio"
                        :value="fechaInicio"
                        @model="updateFechaInicio"
                    ></input-component>
                </div>
                <div class="col-lg-12 mb-1">
                    <checkbox-component
                        ref="pago"
                        :id="'pago'"
                        :required="false"
                        v-model="pago"
                        @model="updatePago"
                    ></checkbox-component>
                    <label class="form-check-label" for="pago">
                        Pago?
                    </label>
                </div>
                <div class="col-lg-12 mb-1 ms-3" v-if="pago">
                    <radio-component
                        :radios="[
                            {
                                value: 'efectivo',
                                checked: true,
                                label: 'Efectivo'
                            },
                            {
                                value: 'digital',
                                checked: false,
                                label: 'Digital'
                            }
                        ]"
                        :required="false"
                        :value="'efectivo'"
                        :name="'tipoPago'"
                        ref="tipoPago"
                        v-model="tipoPago"
                        @model="updateTipoPago"
                    ></radio-component>
                </div>
                <hr>
                <div class="col-lg-12 mb-1">
                    <label class="form-label">Total: {{ total }}</label>
                </div>
                <div class="col-lg-12 mb-1">
                    <div class="d-grid gap-2">
                        <button @click="agregarLiga" class="btn btn-primary" type="button">
                            <i class="bi bi-alarm"></i>&nbsp;Agregar Liga
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import inputp from "../components/controls/input.vue";
import selectp from "../components/controls/select.vue";
import checkboxp from "../components/controls/checkbox.vue";
import radiop from "../components/controls/radio.vue";
export default {
    name: 'ligas',
    components: {
        "input-component": inputp,
        "select-component": selectp,
        "checkbox-component": checkboxp,
        "radio-component": radiop,
    },
    data() {
        return {
            exiteCliente: true,
            fechaDefault: true,
            pago: true,
            total: 0,
            nombreYapellido: '',
            documento: '',
            fechaInicio: '',
            cliente: '',
            equipo: '',
            tipoPago: 'efectivo',
            selectHora: ''

        }
    },
    methods: {
        armardatos(arrayCampos) {
            let data = {}
            arrayCampos.forEach(campo => {
                data[campo] = this[campo]
            });
            return data;
        },
        agregarLiga() {
            console.log('agregarLiga', [
                this.exiteCliente,
                this.fechaDefault,
                this.pago,
                this.total,
                this.nombreYapellido,
                this.documento,
                this.fechaInicio,
                this.cliente,
                this.equipo,
                this.tipoPago,
                this.selectHora,
            ]);

            let array = []
            if(this.exiteCliente && this.pago && this.fechaDefault){
                array = ['cliente', 'selectHora', 'tipoPago']
            } else if(this.exiteCliente && !this.pago && this.fechaDefault){
                array = ['cliente', 'selectHora']
            } else if(!this.exiteCliente && !this.pago && this.fechaDefault){
                array = ['nombreYapellido', 'documento', 'equipo', 'selectHora']
            } else if(!this.exiteCliente && this.pago && this.fechaDefault){
                array = ['nombreYapellido', 'documento', 'equipo', 'selectHora', 'tipoPago']
            } else if(this.exiteCliente && !this.pago && !this.fechaDefault){
                array = ['cliente', 'selectHora', 'fechaInicio']
            } else if(!this.exiteCliente && !this.pago && !this.fechaDefault){
                array = ['nombreYapellido', 'documento', 'equipo', 'selectHora', 'fechaInicio']
            } else if(!this.exiteCliente && this.pago && !this.fechaDefault){
                array = ['nombreYapellido', 'documento', 'equipo', 'selectHora', 'tipoPago', 'fechaInicio']
            } else if(this.exiteCliente && this.pago && !this.fechaDefault){
                array = ['cliente', 'selectHora', 'tipoPago', 'fechaInicio']
            }

            let validCampos = this.validarCampos(array)

            if (validCampos) {
                let data = this.armardatos(array);

                console.log('b', data);

                /*let rdta = await ApiService.post(urlLogin, data)
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
                }*/
            }else{
                //no es valido
                //this.msgError = 'Hay campos sin validar';
                //this.$refs.modalError.show();
            }

            console.log(validCampos, 'resedwin');

        },
        updateExiteCliente(value) {
            this.exiteCliente = value;
        },
        updateNombreYapellido(value) {
            this.nombreYapellido = value;
        },
        updateDocumento(value) {
            this.documento = value;
        },
        updateFechaInicio(value) {
            this.fechaInicio = value;
        },
        updateCliente(value) {
            this.cliente = value;
        },
        updateEquipo(value) {
            this.equipo = value;
        },
        updateTipoPago(value) {
            this.tipoPago = value;
        },
        updatePago(value) {
            this.pago = value;
        },
        updateFechaDefault(value) {
            this.fechaDefault = value;
        },
        updateSelectHora(value) {
            this.selectHora = value;
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

